"""
train_model.py
----------------
Trains the pricing model from your quote_items database and SAVES it
to disk (models/pricing_model.pkl). This is the "training" step -
run it manually whenever you want the model to learn from your latest
quote data (e.g. once a week, or after adding a batch of new quotes).

Why this matters: without this, pricing_anomaly.py had to retrain
from scratch on EVERY single price check - wasteful, and it gets
slower as your quote history grows. Now: train once here, then
pricing_anomaly.py just loads the saved model instantly.

Usage:
    py train_model.py
"""

import os
import joblib
import pandas as pd
from datetime import datetime
from sklearn.linear_model import LinearRegression

from db_connection import get_engine
from job_classifier import classify_job_type

MODEL_DIR = os.path.join(os.path.dirname(__file__), "models")
MODEL_PATH = os.path.join(MODEL_DIR, "pricing_model.pkl")


def load_training_data():
    engine = get_engine()
    query = "SELECT description, quantity, amount FROM quote_items"
    raw = pd.read_sql(query, engine)

    print(f"Fetched {len(raw)} row(s) from quote_items.")

    raw["job_type"] = raw["description"].apply(classify_job_type)
    unmatched = raw["job_type"].isna().sum()

    if unmatched:
        print(f"Note: {unmatched} row(s) didn't match a known job_type keyword "
              f"and were excluded from training.")

    data = raw.dropna(subset=["job_type"]).copy()
    return data[["job_type", "quantity", "amount"]]


def train_models(data):
    models_by_type = {}
    row_counts = {}

    for job_type, group in data.groupby("job_type"):
        X = group[["quantity"]]
        y = group["amount"]

        if len(group) >= 2:
            m = LinearRegression()
            m.fit(X, y)
        else:
            unit_price = (group["amount"] / group["quantity"]).mean()
            m = LinearRegression()
            m.coef_ = pd.Series([unit_price]).values
            m.intercept_ = 0.0

        models_by_type[job_type] = m
        row_counts[job_type] = len(group)

    return models_by_type, row_counts


def save_model(models_by_type, row_counts, total_rows):
    os.makedirs(MODEL_DIR, exist_ok=True)

    bundle = {
        "models_by_type": models_by_type,
        "row_counts": row_counts,
        "total_rows_trained_on": total_rows,
        "trained_at": datetime.now().isoformat(),
    }

    joblib.dump(bundle, MODEL_PATH)
    print(f"\n✅ Model saved to {MODEL_PATH}")
    print(f"   Trained on {total_rows} row(s) across {len(models_by_type)} job type(s):")
    for job_type, count in row_counts.items():
        print(f"     - {job_type}: {count} row(s)")


if __name__ == "__main__":
    data = load_training_data()

    if data.empty:
        print("\n❌ No usable training data found. Add some quotes first, "
              "or check that JOB_TYPE_KEYWORDS matches your real descriptions.")
    else:
        models_by_type, row_counts = train_models(data)
        save_model(models_by_type, row_counts, len(data))