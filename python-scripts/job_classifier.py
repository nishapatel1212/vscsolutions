"""
job_classifier.py (now database-backed, not a static dict)
-------------------------------------------------------------
Previously JOB_TYPE_KEYWORDS was a hardcoded Python dict - any new
job type meant editing this file and redeploying. Now the keyword
list lives in the `job_type_keywords` MySQL table instead, so your
brother (or you) can add/edit keywords any time without touching code.

The keyword list is loaded ONCE per script run and cached in memory
(not re-queried on every single classify_job_type() call), since this
function may be called many times in a loop when training.
"""

from db_connection import get_engine
import pandas as pd

_keyword_cache = None  # loaded lazily, once per script run


def _load_keywords():
    """Fetches active keyword -> job_type mappings from the database."""
    global _keyword_cache

    if _keyword_cache is not None:
        return _keyword_cache

    engine = get_engine()
    query = "SELECT keyword, job_type FROM job_type_keywords WHERE active = 1"
    df = pd.read_sql(query, engine)

    # Build a dict: {"downlight": "downlight", "gpo": "powerpoint", ...}
    _keyword_cache = dict(zip(df["keyword"].str.lower(), df["job_type"]))
    return _keyword_cache


def classify_job_type(description):
    """Maps a free-text description to a job_type, or None if unmatched."""
    keywords = _load_keywords()
    desc = str(description).lower()

    for keyword, job_type in keywords.items():
        if keyword in desc:
            return job_type

    return None


def reload_keywords():
    """Forces a fresh reload from the DB (call this if keywords changed
    mid-session, e.g. in a long-running process)."""
    global _keyword_cache
    _keyword_cache = None
    return _load_keywords()


if __name__ == "__main__":
    import sys
    import json

    if len(sys.argv) > 1 and sys.argv[1] == "--classify":
        description = sys.argv[2]
        print(json.dumps({"job_type": classify_job_type(description)}))
        sys.exit(0)

    # Quick manual test: py job_classifier.py
    keywords = _load_keywords()
    print(f"Loaded {len(keywords)} active keyword(s) from job_type_keywords.\n")

    test_descriptions = [
        "Install Ceilling light",
        "Lighting: Installing indoor lights, dimmer switches",
        "Rewire 3-bedroom house",
        "Something totally unrelated",
    ]

    for desc in test_descriptions:
        print(f"{desc!r} -> {classify_job_type(desc)}")