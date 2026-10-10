"""
pricing_anomaly.py (now uses a saved model - no retraining per request)
---------------------------------------------------------------------
LOADS the model that train_model.py already trained and saved to
models/pricing_model.pkl, instead of retraining from scratch every
time. This is much faster and is called by Laravel on every price
check, so speed matters here.

If you've added new quotes since the last training, run
`py train_model.py` again to refresh the saved model.

Usage:
  Full report on your existing quotes (using the saved model):
    py pricing_anomaly.py

  Check a single NEW quote before saving it (used by Laravel):
    py pricing_anomaly.py --check "Install downlight" 6 2100
"""

import os
import sys
import json
import joblib
import pandas as pd

from job_classifier import classify_job_type
from db_connection import get_engine

MODEL_PATH = os.path.join(os.path.dirname(__file__), "models", "pricing_model.pkl")
THRESHOLD_PCT = 30


def load_saved_model():
    """Loads the trained model bundle from disk. Returns None if not found."""
    if not os.path.exists(MODEL_PATH):
        return None
    return joblib.load(MODEL_PATH)


def predict_amount(models_by_type, job_type, quantity):
    if job_type not in models_by_type:
        return None
    m = models_by_type[job_type]
    return float(m.predict(pd.DataFrame([[quantity]], columns=["quantity"]))[0])


# ---------------------------------------------------------------
# Mode 1: Check a single new quote (called by Laravel)
# ---------------------------------------------------------------
def check_new_quote(description, quantity, proposed_amount):
    bundle = load_saved_model()

    if bundle is None:
        return {
            "flagged": False,
            "note": "No trained model found yet. Run 'py train_model.py' first.",
        }

    models_by_type = bundle["models_by_type"]
    job_type = classify_job_type(description)

    if job_type is None:
        return {"flagged": False, "note": f"Unrecognized job type in description: '{description}'"}

    predicted = predict_amount(models_by_type, job_type, quantity)

    if predicted is None:
        return {"flagged": False, "note": f"No trained history for job type '{job_type}'."}

    diff_pct = ((proposed_amount - predicted) / predicted) * 100
    is_anomaly = abs(diff_pct) > THRESHOLD_PCT

    return {
        "job_type": job_type,
        "predicted_amount": round(predicted, 2),
        "proposed_amount": proposed_amount,
        "difference_pct": round(diff_pct, 1),
        "flagged": is_anomaly,
        "model_trained_at": bundle["trained_at"],
    }


# ---------------------------------------------------------------
# Mode 2: Full report using the saved model, checked against live DB data
# ---------------------------------------------------------------
def run_full_report():
    bundle = load_saved_model()

    if bundle is None:
        print("❌ No trained model found. Run 'py train_model.py' first.")
        return

    print(f"Using model trained at: {bundle['trained_at']}")
    print(f"Trained on {bundle['total_rows_trained_on']} row(s) across "
          f"{len(bundle['models_by_type'])} job type(s).\n")

    models_by_type = bundle["models_by_type"]

    engine = get_engine()
    data = pd.read_sql("SELECT description, quantity, amount FROM quote_items", engine)
    data["job_type"] = data["description"].apply(classify_job_type)
    data = data.dropna(subset=["job_type"]).copy()

    if data.empty:
        print("No quote_items matched a known job_type.")
        return

    data["predicted_amount"] = data.apply(
        lambda row: predict_amount(models_by_type, row["job_type"], row["quantity"]), axis=1
    )
    data["pct_diff"] = ((data["amount"] - data["predicted_amount"]) / data["predicted_amount"]) * 100
    data["anomaly"] = data["pct_diff"].abs() > THRESHOLD_PCT

    pd.set_option("display.float_format", lambda x: f"{x:,.2f}")
    print(data[["job_type", "quantity", "amount", "predicted_amount", "pct_diff", "anomaly"]]
          .to_string(index=False))

    print("\n--- Flagged Anomalies ---")
    anomalies = data[data["anomaly"]]
    if anomalies.empty:
        print("None found.")
    else:
        for _, row in anomalies.iterrows():
            direction = "HIGH" if row["pct_diff"] > 0 else "LOW"
            print(f"⚠️  {row['job_type']} (qty {row['quantity']}): "
                  f"quoted ${row['amount']:,.2f}, expected ~${row['predicted_amount']:,.2f} "
                  f"-> {direction} by {abs(row['pct_diff']):.1f}%")


if __name__ == "__main__":
    if len(sys.argv) > 1 and sys.argv[1] == "--check":
        description = sys.argv[2]
        quantity = float(sys.argv[3])
        proposed_amount = float(sys.argv[4])

        result = check_new_quote(description, quantity, proposed_amount)
        print(json.dumps(result))
    else:
        run_full_report()