# Electrical CRM — Project Overview

A Laravel-based back-office CRM for electrical contracting businesses — originally built for Latin Electrical (REC #37241, south-east Melbourne, run by Nisha Patel), now a shared codebase deployed per client. Each client gets their own instance (own `.env`, own database), fully white-labeled via config — no business name, ABN, bank details, or branding is hardcoded anywhere in the app. See `DEPLOYMENT.md` for how to stand up a new client.

This file is meant to give anyone — a developer, an AI assistant, or a new contributor — a quick, accurate mental model of the project before making changes.

## Tech stack

- **Backend:** Laravel 10 (PHP), MySQL
- **Frontend:** Blade templates, Bootstrap 5, Font Awesome, DataTables, FullCalendar — all loaded globally from `resources/views/layouts/app.blade.php`
- **Auth / permissions:** Laravel Breeze (session auth) + `spatie/laravel-permission` (roles & permissions)
- **PDF generation:** barryvdh/laravel-dompdf
- **AI/ML sidecar:** Python scripts under `python-scripts/` (shared MySQL connection, keyword-based job classification, linear regression pricing model)
- **Shared assets:** `public/css/admin.css` (all styling, including CSS custom properties for the brand palette) and `public/js/admin.js` (shared JS helpers) + `public/js/pages/*.js` (page-specific scripts)

## Roles & permissions

Two seeded roles (`database/seeders/RolesAndPermissionsSeeder.php`, `UserSeeder.php`):

| Role | Access |
|---|---|
| **super-admin** | Everything — dashboard, customers, leads, quotes, jobs, safety checks, chatbot, audit log, users, roles, permissions |
| **electrician** | Dashboard, quotes, jobs, safety checks, chatbot only (no customers/leads/user management) |

Permissions are enforced via route middleware (`permission:...`) in `routes/web.php` and gate sidebar links via `@can` directives in `resources/views/partials/sidebar.blade.php`.

`UserSeeder` seeds exactly one account per deployment — the super-admin — from `ADMIN_NAME`/`ADMIN_EMAIL`/`ADMIN_PASSWORD` in `.env` (see `DEPLOYMENT.md`). Additional staff accounts (e.g. electricians) are added afterward through the Users page, never seeded. On this Latin Electrical deployment specifically: `<admin-email>` (super-admin) and `<electrician-email>` (electrician, added via the Users UI after initial setup) — credentials are set per-deployment in `.env`/the Users UI, never committed here.

## Modules / features (current)

1. **Auth** — Breeze login/register/password-reset (`routes/auth.php`), all admin routes wrapped in `auth` middleware.
2. **Dashboard** — KPI summary (`DashboardController`, `admin_panel/dashboard.blade.php`).
3. **Customers** — CRUD (`CustomerController`, `admin_panel/customers/*`).
4. **Quotes & Invoices** — create/edit/view/PDF export, convert quote → invoice, AI-assisted item drafting (`quote.aiDraft`) and price-anomaly checking (`quote.checkPrice`) (`QuoteController`, `admin_panel/quote/*`).
5. **Service Jobs** — CRUD + a calendar view (FullCalendar) at `/jobs/calendar` (`ServiceJobController`, `admin_panel/jobs/*`).
6. **Leads** — sales pipeline (status update, convert to customer) + public `POST /api/leads` endpoint used by the marketing site's contact form (`LeadController`, `admin_panel/leads/*`).
7. **Safety Check Reports** — electrical safety inspection reports with dynamic fault rows, checklist items (visual/polarity/earth), image uploads, PDF export (`SafetyCheckReportController`, `admin_panel/safety_check_report/*`).
8. **Chatbot** — simple AI assistant UI backed by the Python quoting logic (`ChatController`, `admin_panel/chat/chat.blade.php`).
9. **Audit Log** — tracks created/updated/deleted events (who, when, old vs new values) via an `Auditable` trait applied to Customer, Quote, Invoice, ServiceJob, Lead, SafetyCheckReport (`AuditLogController`, `admin_panel/audit_logs/index.blade.php`).
10. **Users / Roles / Permissions** — full CRUD for staff accounts and access control, super-admin only (`UserController`, `RoleController`, `PermissionController`).
11. **Email Templates (marketing)** — super-admin only. CRUD for reusable HTML email templates (seeded with starter templates: Annual Safety Check Reminder, Seasonal Promotion, Referral Thank You, New Service Announcement — wording pulls the company name from `config('latin.company_name')`, not hardcoded), a "Send" page to pick specific customers (search + select-all) and email them the template, and a per-template send log (status, recipient, errors) (`EmailTemplateController`, `admin_panel/email_templates/*`, `app/Mail/MarketingEmail.php`). Sends from whatever `COMPANY_EMAIL`/`COMPANY_NAME` this deployment's `.env` sets (via `MAIL_FROM_ADDRESS`/`MAIL_FROM_NAME`). Template body supports a `{{name}}` placeholder for per-customer personalization. Each send is logged to the `email_sends` table (template, customer, sender, status, error).
12. **SMS Templates (notifications)** — super-admin only. CRUD for SMS templates tagged by purpose (job reminder, quote follow-up, invoice due, or manual), seeded with starter templates for all three. Same "Send to selected customers" + send-log pattern as Email Templates, but matches customers by phone instead of email (`SmsTemplateController`, `admin_panel/sms_templates/*`). Sending goes through a swappable `App\Contracts\SmsDriver` interface (`app/Services/Sms/*`), bound in `AppServiceProvider` based on `config('sms.driver')`: defaults to `LogSmsDriver` (writes to the Laravel log, no real provider needed to use the feature), with ready-to-activate `TwilioSmsDriver`, `ClickSendSmsDriver`, and `MessageMediaSmsDriver` implementations — just set `SMS_DRIVER` plus the matching credentials in `.env` (see `config/sms.php`). Each send is logged to `sms_sends` (template, customer, sender, phone, status, error). **Not yet automated** — sending is manual via the UI; wiring job-reminder/quote-followup/invoice-due triggers to fire automatically (e.g. a scheduled command) is a future enhancement.
13. **Settings** — super-admin only, at `/settings` (`SettingsController`, `CompanyProfileController`, `JobTypeKeywordController`, `QuotePriceItemController`, `admin_panel/settings/*`). Three editable areas that used to be hardcoded (in Python, or scattered across Blade/env) and required a code change + redeploy to update:
    - **Company Profile** (`company_settings` table — single row) — every business-identity fact: company name, ABN, REC number, address, service area, email, phone, owner name, insurance line, bank/payment details, logo paths. Read everywhere via the `company()` helper. See "Multi-client product architecture" above.
    - **Job Type Keywords** (`job_type_keywords` table) — keyword → job-type mapping used by `job_classifier.py` to auto-classify leads/chatbot messages. (This one was already DB-backed before Settings existed; Settings just adds a UI for it.)
    - **Quote Price List** (`quote_price_items` table, replacing the old hardcoded `price_list` dict in `quote_ai.py`) — keyword, description, price, category. Drives AI quote-item drafting (`quote.aiDraft`) and the chatbot's price guide. `quote_ai.py` now loads this from the database the same way `job_classifier.py` already did (see its module docstring). Editing a price item clears the chatbot's hour-long price-list cache (`Cache::forget('chatbot.price_list')`) so changes show up immediately instead of after the TTL.

    Job Type Keywords and Quote Price List share an inline-edit-row UI pattern (`public/js/pages/settings-tables.js`) rather than separate create/edit pages, since each record is a handful of flat fields. Company Profile is a single full-page edit form instead, since it's one record with many fields.

## Multi-client product architecture

This started as a single-business app for Latin Electrical and is now a product deployed separately for multiple electrical-business clients (4 as of this writing, same feature set for all — per-client feature toggles are a possible future step, not built yet). The model, decided deliberately over a simpler shared-multi-tenant alternative:

- **One codebase, deployed as a separate instance per client** — each client gets their own folder/vhost, own `.env`, own database. No request-time tenant detection, no shared runtime between clients. Full rationale in `DEPLOYMENT.md`.
- **Business-identity facts live in the database, not `.env`.** A single-row `company_settings` table (model: `App\Models\CompanySetting`) holds company name, ABN, REC number, address, service area, email, phone, owner name, insurance line, bank/payment details, and logo file paths — editable via **Settings > Company Profile** (`CompanyProfileController`), no redeploy needed. Every read goes through the global `company()` helper (`app/helpers.php`, mirrors Laravel's `config()` helper — e.g. `company('company_name')`, `company('bank_bsb', 'fallback')`), cached forever and busted automatically on save (`CompanySetting::booted()`). **Nothing in `app/`, `resources/views/`, or `python-scripts/` hardcodes a business name or fact** — checked via a full-codebase audit; previously ~15 files hardcoded "Latin Electrical", REC 37241, bank details, etc. directly. `config/latin.php` is now just the two *technical* settings (`python_path`, `scripts_path`) — not business data.
- **`.env` only identifies the deployment and holds technical/secret settings** — `CLIENT_NAME` (an internal label, not used for DB switching or anything dynamic), DB credentials, the bootstrap `ADMIN_NAME`/`ADMIN_EMAIL`/`ADMIN_PASSWORD` for the first login, and mail/SMS provider credentials. On *this* Latin Electrical deployment, `.env` still carries the original `COMPANY_*` values too, but only as a one-time seed source for `CompanySettingSeeder` — the database is authoritative from then on; a new client's `.env.example` doesn't have `COMPANY_*` at all, since there's nothing to seed and the admin fills in Company Profile after first login instead.
- **`php artisan company:setup`** (`app/Console/Commands/CompanySetup.php`) — the one-command onboarding flow for a new client: validates `ADMIN_*` is set, migrates, then seeds roles/permissions, the super-admin account, and generic starter data (job keywords, price list, email/SMS template wording). Does **not** seed Company Profile — that's filled in through the UI after first login.
- **`.env.example`** is the real onboarding template now (not the stock Laravel one) — lists `CLIENT_NAME` and `ADMIN_*` with inline comments; no `COMPANY_*` vars, since those live in the database now.

### Dead scaffolding removed

A prior unfinished attempt at single-instance multi-tenancy existed in the codebase and has been removed: `app/Http/Middleware/SetDatabaseConnection.php` (read a `CLIENT_NAME` env var to switch DB connection per request — never registered in `Kernel.php`, so it never ran), `config/vsc.php` (a second, inconsistent client config for "VSC Solutions"), and VSC-branching logic in `application-logo.blade.php` and `safety_check_report/pdf.blade.php`. `CLIENT_NAME` itself came back deliberately afterward as a plain deployment label (see above) — that's a different, much simpler thing than the removed per-request DB-switching logic; don't reintroduce the latter.

## Python AI/ML sidecar (`python-scripts/`)

- `db_connection.py` — reads Laravel's `.env` so Python and PHP share one MySQL database.
- `job_classifier.py` — keyword-based job-type classification, keywords stored in the `job_type_keywords` DB table (editable via Settings, no code changes needed).
- `quote_ai.py` — price list used to auto-draft quote line items from free text, loaded from the `quote_price_items` DB table (editable via Settings — no longer a hardcoded dict).
- `train_model.py` — trains a per-job-type linear regression pricing model from historical `quote_items`, saves `models/pricing_model.pkl`.
- `pricing_anomaly.py` — loads the saved model and flags quotes that deviate >30% from the predicted price.

## Key data models

`User`, `Customer`, `Lead`, `Quote` / `QuoteItem`, `Invoice` / `InvoiceItem`, `ServiceJob`, `SafetyCheckReport` (+ `InspectionItem`, `VisualInspectionItem`, `PolarityTestingItem`, `EarthTestingItem`, `ReportImage`, `Fault`), `JobTypeKeyword`, `QuotePriceItem`, `CompanySetting`, `AuditLog`, `EmailTemplate`, `EmailSend`, `SmsTemplate`, `SmsSend`.

## Conventions worth knowing before editing

- **No CDN/inline CSS or JS in individual Blade views.** Global libraries (jQuery, DataTables, FullCalendar, Bootstrap, Font Awesome) are loaded once in `layouts/app.blade.php`. All styling lives in `public/css/admin.css`; bespoke per-page JS lives in `public/js/pages/*.js` and is referenced via `@push('scripts')` with `asset()`, with routes passed through `data-*` attributes rather than inlined Blade.
- Delete-confirmation on forms uses `data-confirm="..."` (handled by a delegated listener in `admin.js`) instead of inline `onsubmit="return confirm(...)"`.
- DataTable initialization goes through shared helpers `initDataTable()` / `initServerDataTable()` in `admin.js` rather than being re-written per page.
- `chat/chat.blade.php` was migrated off the orphaned `adminlte::page` layout onto the standard `layouts.app` — don't reintroduce AdminLTE-specific markup there.
- Third-party send integrations (SMS today, possibly payments/other APIs later) follow a driver-interface pattern: an interface in `app/Contracts/`, concrete implementations in `app/Services/<thing>/`, bound in `AppServiceProvider::register()` based on a `config('<thing>.driver')` value, with a no-op/log-only default so the feature works before real credentials exist. Follow this pattern rather than hardcoding a specific vendor's SDK into a controller.
- **Never hardcode a business-identity fact** (company name, ABN, REC number, address, phone, email, bank/payment details, logo filename) anywhere in `app/`, `resources/views/`, `python-scripts/`, or seeders — always go through the `company()` helper (PHP/Blade) which reads the `company_settings` table, or the database directly (Python, via `db_connection.py`). This codebase is deployed per client; a hardcoded fact here means it leaks into every other client's deployment too. See "Multi-client product architecture" above.

## Suggested pages/features not yet built

These were identified as natural next additions for the business, roughly in priority order:

**High-value**
- **Customer portal** — let customers view their own quotes, invoices, and job status/history without calling the office.
- **Payments page** — record/track invoice payments (paid/partial/overdue), possibly Stripe integration (the `Invoice` model exists but has no payment-tracking yet).
- **Technician/staff management** — assign jobs to specific staff, track availability (useful once there's more than one electrician).
- **Materials/inventory tracking** — stock levels for commonly used parts, tied into quote line items.

**Operational**
- **Reports/analytics dashboard** — revenue by month, job-type breakdown, lead conversion rate, average quote-to-invoice time.
- **Document/compliance expiry tracker** — REC license renewal, insurance, certifications, with reminders.
- **Recurring jobs/maintenance contracts** — for commercial clients needing periodic safety checks.
- ~~Email/SMS notifications~~ — **built**, see Email Templates and SMS Templates above. Still open: automatically *triggering* a send (e.g. N days before a scheduled job, N days after a quote, N days past an invoice due date) rather than sending manually from the UI.

**Nice-to-have**
- **Reviews/testimonials management** — collect and showcase customer feedback.
- ~~Settings page~~ — **built**, see Settings above.
- **Audit log enhancements** — the current audit log (see above) covers the core modules; extend it to any new module added above as a standing convention, not an afterthought.
