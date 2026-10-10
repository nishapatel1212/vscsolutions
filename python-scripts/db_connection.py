"""
db_connection.py
-----------------
Shared helper so every Python script in this folder connects to the
SAME database your Laravel app uses - by reading Laravel's own .env
file. This means there's only ONE place your DB credentials live
(Laravel's .env), not duplicated across Python and PHP.
"""

import os
import pymysql
from dotenv import load_dotenv
from sqlalchemy import create_engine

# Path to your Laravel project's .env file.
# Your scripts live in: D:\Wamp\www\latin_electrical\python-scripts
# The .env file lives one folder up, at: D:\Wamp\www\latin_electrical\.env
ENV_PATH = os.path.join(os.path.dirname(__file__), "..", ".env")

load_dotenv(dotenv_path=ENV_PATH)


def get_connection():
    """
    Raw pymysql connection - use for simple queries/cursor.execute().
    """
    return pymysql.connect(
        host=os.getenv("DB_HOST", "127.0.0.1"),
        port=int(os.getenv("DB_PORT", 3306)),
        user=os.getenv("DB_USERNAME", "root"),
        password=os.getenv("DB_PASSWORD", ""),
        database=os.getenv("DB_DATABASE"),
        cursorclass=pymysql.cursors.DictCursor,
    )


def get_engine():
    """
    SQLAlchemy engine - use this for pandas.read_sql(), which expects
    a SQLAlchemy engine rather than a raw DBAPI connection.
    """
    host = os.getenv("DB_HOST", "127.0.0.1")
    port = os.getenv("DB_PORT", 3306)
    user = os.getenv("DB_USERNAME", "root")
    password = os.getenv("DB_PASSWORD", "")
    database = os.getenv("DB_DATABASE")

    url = f"mysql+pymysql://{user}:{password}@{host}:{port}/{database}"
    return create_engine(url)


if __name__ == "__main__":
    # Quick test: run this file directly to confirm the connection works.
    # Usage:  py db_connection.py
    try:
        conn = get_connection()
        with conn.cursor() as cursor:
            cursor.execute("SELECT COUNT(*) AS total FROM quote_items")
            result = cursor.fetchone()
            print(f"✅ Connected successfully. Found {result['total']} rows in quote_items.")
        conn.close()
    except Exception as e:
        print("❌ Connection failed:", e)
        print("\nCheck that:")
        print("1. WAMP/MySQL is running")
        print("2. The .env path above is correct")
        print("3. DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env match your MySQL setup")