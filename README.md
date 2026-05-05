# DocuCloud - Cloud Document Management SaaS

DocuCloud is a full-stack SaaS web application for cloud document management built with Laravel, Blade, Tailwind CSS, and PostgreSQL.

It supports secure document upload, sharing, and robust document versioning with restore workflows.

## Tech Stack

- Backend: Laravel 13 (PHP 8.3+)
- Frontend: Laravel Blade + Tailwind CSS 4 (Vite)
- Database: PostgreSQL
- Authentication: Laravel Breeze (Blade)
- Storage: Laravel Filesystem (`local` disk by default)

## Core Features

- Register, login, logout, and profile management
- SaaS dashboard UI with sidebar + top navbar
- Personal document space per user
- Upload documents (PDF, DOCX, images, etc.)
- Document metadata (title, size, uploaded by, timestamps)
- Rename and delete documents
- Share documents with users by email
- Sharing permissions: `view` and `edit`
- Full document version history with:
  - Incremental `version_number`
  - Upload metadata (who/when/size)
  - Optional change summary
  - Restore previous version as current
- Search documents by title

## Versioning Design

### Tables

- `documents`
  - `id`
  - `user_id`
  - `title`
  - `current_version_id`
  - timestamps + soft deletes

- `document_versions`
  - `id`
  - `document_id`
  - `storage_disk`
  - `file_path`
  - `original_filename`
  - `mime_type`
  - `size_bytes`
  - `version_number`
  - `uploaded_by`
  - `change_summary`
  - `is_current`
  - timestamps

- `document_shares`
  - `id`
  - `document_id`
  - `shared_by_user_id`
  - `shared_with_user_id`
  - `permission` (`view` or `edit`)
  - timestamps

### Data Integrity Rules

- Each document has many versions.
- Version uploads never overwrite old files.
- A PostgreSQL partial unique index guarantees only one current version per document.
- Restoring a version toggles `is_current` and updates `documents.current_version_id`.

## Routes Overview

- `GET /` -> redirects to dashboard
- `GET /dashboard` -> SaaS dashboard
- Document routes:
  - `GET /documents`
  - `POST /documents`
  - `GET /documents/{document}`
  - `GET /documents/{document}/download`
  - `PATCH /documents/{document}`
  - `DELETE /documents/{document}`
- Version routes:
  - `POST /documents/{document}/versions`
  - `POST /documents/{document}/versions/{version}/restore`
- Share routes:
  - `POST /documents/{document}/shares`
  - `DELETE /documents/{document}/shares/{share}`
- Auth routes (Breeze):
  - `login`, `register`, `logout`, password reset, email verification

## Setup Instructions

1. Clone and install dependencies:

```bash
composer install
npm install
```

2. Configure environment:

```bash
cp .env.example .env
php artisan key:generate
```

3. Set PostgreSQL credentials in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=docs_version
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

4. Run migrations:

```bash
php artisan migrate
```

5. Build assets and run the app:

```bash
npm run build
php artisan serve
```

For local development with hot reload:

```bash
npm run dev
```

## Running Tests

```bash
php artisan test
```

## Notes

- Max upload size is currently `50MB` per file (validation rule).
- Files are stored via Laravel storage APIs.
- Authorization is enforced using `DocumentPolicy` for `view`, `edit`, and `delete`.

## License

This project is open-sourced under the MIT license.
