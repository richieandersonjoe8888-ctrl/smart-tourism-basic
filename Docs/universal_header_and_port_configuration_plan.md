# Universal Navigation Header & Port Configuration Plan

The goal is to update the microservices to run on new ports (`8000`, `8001`, `8002`) and create a dynamic, role-based header (navigation bar) that connects the isolated microservices (`auth-service`, `blog-service`, and `vendor-service`).

## Proposed Changes

### 1. Updating Hardcoded Ports
- **[MODIFY]** `blog-service/resources/views/blogs/index.blade.php` (update login link to `8000`)
- **[MODIFY]** `blog-service/routes/web.php` (update login redirect to `8000`)
- **[MODIFY]** `blog-service/app/Http/Controllers/BlogServiceController.php` (update dashboard redirect to `8001`)
- **[MODIFY]** `vendor-service/resources/views/layouts/app.blade.php` (update profile/logout links to `8000`)
- **[MODIFY]** `vendor-service/routes/web.php` (update login redirect to `8000`)

### 2. The Header Component Design
The header is built with Tailwind CSS and contains logic to check `Auth::check()` and `Auth::user()->hasRole(...)`.
It renders links dynamically using the new ports:
- **Guests**: `Blogs (8002)` | `Sign In (8000)` | `Register (8000)`
- **Normal Users**: `Blogs (8002)` | `Profile (8000)`
- **Vendors**: `Blogs (8002)` | `Store Dashboard (8001)` | `Profile (8000)`
- **Admins**: `Blogs (8002)` | `Admin Dashboard (8000)` | `Profile (8000)`

### 3. Distributing to Microservices
- Create `resources/views/components/universal-header.blade.php` in `auth-service`, `blog-service`, and `vendor-service`.

### 4. Integrating the Header
- `blog-service/resources/views/blogs/index.blade.php`: Replace the hardcoded `<nav>` with `<x-universal-header />`.
- `auth-service/resources/views/layouts/navigation.blade.php` (or similar layout): Inject the universal header.
- `vendor-service/resources/views/layouts/app.blade.php` (or similar layout): Inject the universal header.
