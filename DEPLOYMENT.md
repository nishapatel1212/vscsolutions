# Deploying this app for a new client

This codebase is shared across every client — one copy of the code, deployed
as a **separate instance per client**: its own folder/vhost, its own `.env`,
its own database. There's no shared runtime between clients and no dynamic
tenant switching; isolation comes entirely from each deployment having its
own `.env` and its own MySQL database.

Nothing in `app/`, `resources/views/`, or `python-scripts/` hardcodes a
business name, ABN, REC number, bank details, or logo path. These live in
the **database** (`company_settings` table, one row per deployment),
accessed everywhere through the `company()` helper (`app/helpers.php`) —
e.g. `company('company_name')`, `company('bank_bsb')`. `.env` only
identifies *which* deployment this is (`CLIENT_NAME`) and holds technical
settings (DB/mail/SMS credentials, the admin bootstrap account) — it does
not hold branding. See `project-overview.md` for what the app does; this
file is just the "how do I stand up client #2" checklist.

## Setting up a new client

1. **Copy the codebase** to the new client's folder/vhost on the server.
2. **Create a new MySQL database** for this client (don't reuse another client's DB).
3. **Copy `.env.example` to `.env`** in the new folder and fill in:
   - `APP_URL`, `APP_KEY` (run `php artisan key:generate` after copying)
   - `CLIENT_NAME` — a short internal label for this deployment (e.g. `acme`)
   - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — this client's own database
   - `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD` — the first login this
     client will use (role: super-admin). Change the password after first login.
   - `MAIL_*` — a real SMTP account for this client, or leave as-is to use
     a local dev catcher (mailpit) during setup.
   - `SMS_DRIVER` and the matching credentials, if this client wants SMS
     sending for real (defaults to `log`, which just logs messages instead
     of sending — safe to leave until they're ready).
   - `PYTHON_PATH` — path to the Python interpreter on this server (used by
     the AI quoting/classification sidecar under `python-scripts/`).
4. **Install dependencies** (first deployment on this server only needs this once if sharing vendor/node_modules across folders isn't desired — otherwise per client):
   ```
   composer install --no-dev --optimize-autoloader
   ```
5. **Run the setup command** — this migrates the database and seeds roles,
   permissions, the super-admin account, and generic starter data (an
   electrical price list, job-type keywords, and email/SMS template
   wording — all editable afterward):
   ```
   php artisan company:setup
   ```
   It validates that `ADMIN_NAME`, `ADMIN_EMAIL`, and `ADMIN_PASSWORD` are
   set in `.env` before doing anything, and refuses to run if any are missing.
6. **Log in**, change the admin password, then go to **Settings > Company
   Profile** and fill in the business name, ABN, REC number, address,
   service area, bank/payment details, and logo file paths — nothing is
   pre-filled for a new client. Upload the actual logo image files to the
   `public/` paths you enter there.
7. **Add this client's other staff accounts** (electricians etc.) through
   the Users page — these are never seeded, only the first super-admin is.
8. **Point the Python sidecar at the right database** — it already shares
   credentials with Laravel by reading this same `.env` file
   (`python-scripts/db_connection.py`), so no separate configuration needed
   as long as step 4 used this client's own `.env`.

## What's shared vs. per-client

| Shared (one copy, same for every client) | Per-client (own `.env` / own DB) |
|---|---|
| All PHP code, Blade views, CSS/JS | Database (customers, quotes, jobs, leads, branding, etc.) |
| Python AI scripts (`python-scripts/`) | `CLIENT_NAME` + technical `.env` settings (DB/mail/SMS credentials, admin bootstrap) |
| Feature set (currently identical for all clients) | Branding — company name, ABN, bank details, logos (`company_settings` table, edited via Settings > Company Profile) |
| Email/SMS template *wording pattern* (seeded fresh per client) | Admin/staff accounts |
| | Job-type keywords & quote price list (seeded as a generic starting point, then client-specific) |

## Updating an existing client

Since every client runs the same codebase, shipping a bug fix or new
feature means re-deploying the updated code to each client's folder and
running `php artisan migrate` there (not `company:setup` again — that
re-seeds starter data, which you don't want on a live client). There's no
one-command "update all clients at once" yet; for 4 clients this is still
manageable by hand, but if the client count grows, scripting this
redeploy-and-migrate step across folders would be worth doing.

## Why this architecture, not a single shared multi-tenant app

A single running app serving all clients (one deployment, tenant switched
per-request by subdomain) would mean one codebase to update instead of N —
but it requires request-time tenant detection, a central "which client is
this" lookup, and much more careful query scoping to prevent one client
ever seeing another's data. For 4 clients, separate deployments are safer
and simpler: a bug in one client's data never risks another's, and there's
no tenant-isolation logic to get wrong. Revisit this if the client count
grows large enough that redeploying per-client by hand becomes the
bottleneck.
