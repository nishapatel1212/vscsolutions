"""
quote_ai.py (now database-backed, not a static dict)
-------------------------------------------------------------
Previously price_list was a hardcoded Python dict - any new job type or
price change meant editing this file and redeploying. Now the price
list lives in the `quote_price_items` MySQL table instead, editable
from the admin Settings page without touching code.

The price list is loaded ONCE per script run and cached in memory
(mirrors job_classifier.py's pattern).
"""

import sys
import json

from db_connection import get_engine
import pandas as pd

_price_list_cache = None  # loaded lazily, once per script run


def _load_price_list():
    """Fetches active price-list rows from the database as
    {keyword: {description, amount, category}}."""
    global _price_list_cache

    if _price_list_cache is not None:
        return _price_list_cache

    engine = get_engine()
    query = "SELECT keyword, description, amount, category FROM quote_price_items WHERE active = 1"
    df = pd.read_sql(query, engine)

    _price_list_cache = {
        row["keyword"].lower(): {
            "description": row["description"],
            "amount": float(row["amount"]),
            "category": row["category"],
        }
        for _, row in df.iterrows()
    }
    return _price_list_cache


def reload_price_list():
    """Forces a fresh reload from the DB (call this if the price list
    changed mid-session, e.g. in a long-running process)."""
    global _price_list_cache
    _price_list_cache = None
    return _load_price_list()


def generate_quote(job_description):
    price_list = _load_price_list()
    job_description = job_description.lower()
    items = []
    for keyword, details in price_list.items():
        if keyword in job_description:
            items.append({
                "description": details["description"],
                "quantity": 1,
                "amount": details["amount"]
            })
    return items


if __name__ == "__main__":
    if len(sys.argv) > 1 and sys.argv[1] == "--dump-price-list":
        # Lets PHP (e.g. the chatbot) reuse this same price list instead of
        # keeping a second copy in sync by hand.
        print(json.dumps(_load_price_list()))
    else:
        job_description = sys.argv[1]  # gets text passed in from Laravel
        result = generate_quote(job_description)
        print(json.dumps({"items": result}))
