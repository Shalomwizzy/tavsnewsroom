# Tavsnewsroom — Upgrade & Bug Fix Project

## Project Overview

This is a **white-label news CMS platform**. The codebase ships completely blank. Every piece of content, branding, and configuration — site name, logo, colors, analytics IDs, social links, footer text, everything — is added exclusively through the admin panel and stored in the database. This allows anyone to install the script and run their own news site.

**CRITICAL RULE — enforced on ALL work:**
> **Nothing site-specific is ever hardcoded.** No site names, URLs, brand colors, email addresses, API keys, or any other instance-specific value may appear in PHP, Blade, JS, or CSS files. All such values must come from `WebsiteSetting`, `.env`, or `config/`. Any existing hardcoded value is a bug to be fixed.

**Current Stack (as-built):**
- Laravel 10.x + PHP 8.4 (Herd)
- Blade templates (server-rendered)
- Bootstrap 4.5.2 via Vite (migrating to Bootstrap 5 in Phase 4)
- jQuery 3.6.0 from CDN (removing in Phase 4)
- Owl Carousel 2 from CDN (replacing with Swiper.js in Phase 4)
- Font Awesome 5 from CDN (upgrading to FA 6 in Phase 4)
- Vite for asset bundling
- Google Analytics 4 (spatie/laravel-analytics)
- artesaos/seotools, spatie/laravel-sitemap

---

## Work Phases

### Phase 1 — Critical Bug Fixes (Do First)
These are breaking issues that affect functionality right now.

- [x] **Bug: Missing TwitterController** — Removed dead import from `routes/web.php`.
- [x] **Bug: Duplicate route** — Removed second `/cookie-policy` registration from `routes/web.php`.
- [x] **Bug: Bootstrap 4 → Bootstrap 5 migration** — Bootstrap 4 CDN JS/jQuery removed. Bootstrap 5 JS via Vite (`resources/js/bootstrap.js`). Bootstrap 4 CSS stripped from `style.css` (custom styles kept). Full BS5 migration done in Phase 4.
- [x] **Bug: Navbar query in Blade view** — Created `NavbarComposer`, registered in `AppServiceProvider`, removed direct model call from partial.
- [x] **Bug: `srcset` not actually responsive** — Stripped all fake srcset/sizes attributes from all Blade views.
- [x] **Bug: `home.blade.php` wrong content** — `/home` route now redirects to `welcome`.
- [x] **Bug: Duplicate PublishScheduledPosts command** — Deleted empty orphaned file at `app/Console/PublishScheduledPosts.php`.
- [x] **Bug: Hardcoded canonical URL** — Changed to `{{ url()->current() }}` in `layouts/app.blade.php`.
- [x] **Bug: Two conflicting CSS frameworks** — Removed Bootstrap 4 CDN CSS link; style.css via Vite is the single source. Full cleanup in Phase 4 Bootstrap migration.

---

### Phase 2 — Security Fixes (High Priority)
- [x] **XSS: Unescaped content output** — Installed `mews/purifier`. Rich text content sanitized with `clean($input, 'news_content')` on save in `PostNewsController`, `AnnouncementController`, `BlogSettingsController`, `FooterSettingsController`. Snippet views converted to `{{ Str::limit(strip_tags(...)) }}`.
- [x] **Security: .env write from user input** — `AdminController::updateEnv()` rewritten with explicit allowlist, newline stripping, and preg_replace backreference escaping.
- [x] **Security: Hardcoded maintenance secret** — Moved to `MAINTENANCE_SECRET` in `.env`. Falls back to a random string if unset.
- [x] **Security: Hardcoded GA IDs** — GA tracking ID moved to `WebsiteSetting::getValue('ga_tracking_id')` in layout. GA property ID moved to `WebsiteSetting::getValue('ga_property_id')` in `AdminController`.

---

### Phase 3 — Performance Fixes
- [x] **Perf: Synchronous email to all subscribers** — Created `SendNewsletterJob` (implements `ShouldQueue`). All three `PostNewsController` send-sites now dispatch the job. Runs sync now (QUEUE_CONNECTION=sync) but ready to go async when queue worker is set up.
- [x] **Perf: Sitemap regenerated on every save** — Created `RegenerateSitemapJob`. `PostNews::booted()` now dispatches the job instead of calling Artisan directly.
- [x] **Perf: `PostNews::index()` loads all posts into memory** — Replaced 3-query PHP merge with a single `whereIn('status', [...])->latest()->paginate(20)` DB query.
- [x] **Perf: Search fetches all rows** — `SearchController::search()` now uses `->paginate(15)->withQueryString()`. Query also scoped to `status=published` and uses grouped WHERE to avoid false OR matches.
- [x] **Perf: All CSS loaded on every page** — ~20 separate CSS files (including admin-only CSS) are loaded globally in `layouts/app.blade.php`. Split into public-layout CSS and admin-layout CSS. Use Vite's code splitting.
- [x] **Perf: Image storage** — Images stay in `public/images/news_images/` (intentional — Laravel Storage causes persistent issues in this setup; do not migrate).
- [x] **Perf: No caching** — All 11 homepage queries wrapped in `Cache::remember()` (5 min TTL). Each model's `booted()` calls `Cache::forget()` on save/delete for instant invalidation.

---

### Phase 4 — Frontend Upgrade (Modernization)
- [x] **Upgrade: Bootstrap 4 → Bootstrap 5** — All `data-toggle`→`data-bs-toggle`, `data-target`→`data-bs-target`, `mr-*`→`me-*`, `ml-*`→`ms-*` updated across all Blade views. Bootstrap 4 CSS block removed from `style.css`.
- [x] **Upgrade: Font Awesome 5 → Font Awesome 6** — CDN updated to FA 6.5.2 in `app.blade.php`.
- [x] **Upgrade: Replace Owl Carousel** — Replaced with Swiper.js across all 4 homepage carousel partials. Owl CDN removed from both layouts. `main.js` fully rewritten.
- [x] **Upgrade: Remove jQuery dependency** — `main.js` rewritten in vanilla JS (no jQuery). Bootstrap 4 jQuery CDN removed. Public layout is now jQuery-free.
- [x] **Upgrade: Twitter → X branding** — Share button updated to `fa-x-twitter` icon and "X" label. URL kept as `twitter.com/intent/tweet` (still works).
- [x] **Upgrade: Remove inline styles** — Share button inline `background-color` styles moved to `.share-btn-*` CSS classes in `share-interation.css`.
- [x] **Upgrade: Dark mode support** — Full light/dark toggle on public site and admin panel. CSS custom properties, localStorage persistence, anti-flash script, all components covered.
- [ ] **Upgrade: Skeleton loaders / loading states** — Add skeleton screens for news card grids while content loads.
- [x] **Upgrade: Open Graph / Twitter Card meta tags** — `read-more.blade.php` sets `@section('og_image')`, `@section('og_type', 'article')`. Base layout emits all OG + Twitter Card tags.
- [x] **Upgrade: Admin CSS to admin layout only** — `admin-style.css` and `dashboard.css` should only load inside `layouts/admin.blade.php`, not the public layout.

---

### Phase 5 — Laravel / Backend Upgrades
- [x] **Keep Laravel 10** — User decision: stay on Laravel 10 (familiar), use Laravel 12 for new projects only.
- [x] **PHP 8.4 deprecation notices fixed** — Suppressed in `public/index.php` via `ini_set('display_errors','0')` + `error_reporting`. Composer packages updated to latest compatible versions.
- [x] **Upgrade: Add Laravel Queue** — `QUEUE_CONNECTION=database`, jobs table migrated, `SendNewsletterJob` and `RegenerateSitemapJob` dispatched. Run `php artisan queue:work` to go async.
- [x] **Upgrade: Add image processing** — `intervention/image` v4 installed. `PostNewsController::processNewsImage()` resizes to 1200px and encodes WebP at quality 82.
- [ ] **Upgrade: Add Laravel Telescope** (dev only) — For debugging queries, jobs, and mail during development.
- [x] **Upgrade: Soft deletes on PostNews** — `SoftDeletes` trait added. Trash view, restore, and force-delete wired in admin sidebar.
- [ ] **Upgrade: Simplify news section tables** — Six separate tables (`trending_news`, `featured_news`, `popular_news`, `latest_news`, `carousel_news`, `top_news`) could become a single `post_sections` pivot table with a `section` enum column. Evaluate carefully with data migration.
- [ ] **Upgrade: Replace `laravel/ui` auth scaffolding** — `laravel/ui` is legacy. Migrate to Laravel Breeze or keep UI but modernize the Blade views.
- [ ] **Upgrade: Add Form Request classes** — Validation in controllers (e.g., `PostNewsController::store`) should move to dedicated `StorePostNewsRequest` / `UpdatePostNewsRequest` classes.

---

### Phase 6 — Code Cleanup
- [x] **Cleanup: Remove leftover dev files** — Delete `resources/views/admin/rough.html`, `resources/views/rough.html`, `resources/views/home-page/empty.html`, `resources/views/vendor/empty.html`, `app/Http/View/empty.html`, `resources/views/showpostnews.html`, `resources/views/email-template.html`.
- [x] **Cleanup: Remove commented-out routes** — Multiple commented-out `Route::` calls in `routes/web.php`.
- [ ] **Cleanup: Consolidate duplicate CSS** — Several CSS files contain overlapping/duplicate Bootstrap utility overrides. Consolidate into a single `custom.css`.
- [x] **Cleanup: Move all hardcoded config** — GA ID → `WebsiteSetting`. Maintenance secret → `MAINTENANCE_SECRET` env. TinyMCE API key → `TINYMCE_API_KEY` env + `config/services.php`. Admin layout de-duplicated (was loading jQuery/Bootstrap 3× each).

---

### Phase 7 — New Features
All features must follow the white-label rule — no hardcoded content, all configurable.

- [x] **Feature: Reading time estimate** — `reading_time` column on `post_news`. Calculated on save in `PostNews::booted()`. Displayed on article page.
- [x] **Feature: Article view counter** — `PostView` model + `post_views` table. Count incremented on `readMore`. Admin `top-articles` view with period filter.
- [x] **Feature: Breaking news badge** — `is_breaking` boolean on `post_news`. Red BREAKING badge shown in feed and on article page.
- [x] **Feature: Author profiles** — Each user (writer/admin) gets a public bio page (`/author/{username}`) showing their articles. Bio and avatar configurable from user settings.
- [x] **Feature: Save/bookmark articles** — `Bookmark` model + `bookmarks` table. Toggle route, bookmarks index page, bookmark button on article.
- [x] **Feature: Comment system** — `Comment` model. Readers comment with name+email. Admin moderation panel at `/admin/comments`.
- [x] **Feature: Social share count display** — Dropped per user request. Not needed.
- [x] **Feature: Newsletter welcome email** — `WelcomeSubscriberEmail` mailable + `SendWelcomeEmailJob` dispatched on subscribe.
- [x] **Feature: Article print view** — Print button on article page. `@media print` CSS hides nav/sidebar/comments, full-width article, source URL footer.
- [x] **Feature: Related articles (improved)** — Tag-based matching weighted by recency + view count. Shows 3 related articles on article page.

---

### Phase 8 — SEO & Performance (Lazy Loading)
All SEO values must be admin-configurable — no defaults hardcoded in templates.

**SEO fixes:**
- [x] **SEO: Open Graph tags** — `read-more.blade.php` sets `@section('og_image')`, `@section('meta_title')`, `@section('meta_description')` which feed into the base layout OG block.
- [x] **SEO: Twitter/X Card tags** — Same as above; base layout emits `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image` from the same sections.
- [x] **SEO: Schema.org structured data** — `NewsArticle` JSON-LD block present in `read-more.blade.php` via `@section('structured_data')`.
- [x] **SEO: Default meta description** — `WebsiteSetting::getValue('site_default_meta_description')` used as fallback in `layouts/app.blade.php`.
- [x] **SEO: Page title format** — `layouts/app.blade.php` renders `{Page Title} | {Site Name}` via `$fullTitle`.
- [x] **SEO: Category page meta** — `categories/news.blade.php` and `categories/index.blade.php` now set `@section('meta_title')` and `@section('meta_description')`.
- [x] **SEO: GA tracking ID from settings** — Moved to `WebsiteSetting::getValue('ga_tracking_id')`. Gtag block only renders if ID is set.
- [x] **SEO: Sitemap ping on publish** — `RegenerateSitemapJob` pings `https://www.google.com/ping?sitemap=` with the sitemap URL after generation.
- [x] **SEO: robots.txt dynamic** — Served from a route closure, content from `WebsiteSetting::getValue('robots_txt')` with sitemap URL appended.

**Lazy loading / performance:**
- [x] **Perf: Hero/carousel images use `fetchpriority="high"`** — First `swiper-slide` image in `carousel-news.blade.php` uses `loading="eager" fetchpriority="high"`. All subsequent slides use `loading="lazy"`. Preload link also scoped to first slide only.
- [x] **Perf: Consistent `loading="lazy"` on all images** — All non-hero images audited and updated across all Blade views.
- [x] **Perf: Add `width` and `height` on all `<img>` tags** — Added to all homepage partials, search results, trending, and category views.
- [x] **Perf: Defer/async non-critical scripts** — Owl Carousel and jQuery CDN scripts removed entirely. Inline Owl init script removed from `app.blade.php`. Swiper is bundled via Vite.

---

## Architecture Notes

**Data flow — news post lifecycle:**
1. Writer creates post (draft/pending) → Admin approves → status = `published`
2. On publish: newsletter email sent to all subscribers (currently synchronous — must be queued)
3. On any save/delete: sitemap regenerated (currently synchronous — must be queued)

**Key Models:**
- `PostNews` — central model; has relationships to 6 section-specific tables + tags + categories
- `Category` — top-level taxonomy; also used as tags
- `TrendingNews`, `FeaturedNews`, `PopularNews`, `LatestNews`, `CarouselNews`, `TopNews` — section assignment tables (each holds a `post_news_id` FK)

**Admin Roles:**
- `admin` — full access
- `writer` — can create/edit posts (cannot delete, approve, manage settings)

**Key third-party integrations:**
- Google Analytics 4 (spatie/laravel-analytics + google/analytics-data)
- SEO scoring (artesaos/seotools)
- Sitemap (spatie/laravel-sitemap)

---

## Development Commands

```bash
# Install dependencies
composer install
npm install

# Build assets
npm run dev       # development with HMR
npm run build     # production build

# Database
php artisan migrate
php artisan db:seed

# Queue worker (needed for email jobs once queuing is implemented)
php artisan queue:work

# Sitemap
php artisan app:generate-sitemap

# Publish scheduled posts
php artisan app:publish-scheduled-posts
```

---

## File Structure Reference

```
app/
  Http/Controllers/   — feature controllers (one per resource)
  Models/             — Eloquent models
  Mail/               — Mailable classes
  Services/           — GoogleAnalyticsService
  Console/Commands/   — Artisan commands

resources/
  views/
    layouts/          — app.blade.php (public), admin.blade.php (admin)
    partials/         — navbar, footer, topbar, cookies, error
    home-page/partials/ — each homepage section as a partial
    admin/            — all admin panel views
    post-news/        — public article pages
    auth/             — login/register/password reset

routes/
  web.php             — all routes (split into admin-only, admin+writer, public groups)
```
