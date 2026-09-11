# B2B Wholesale Suite — WordPress site

This repo contains everything **specific to this site** — the custom theme and a full
database export (all pages, blog posts, menus, and settings). It does **not** include
WordPress core itself (`wp-admin/`, `wp-includes/`, root `wp-*.php` files) — that's
standard, unmodified WordPress and gets downloaded fresh, same as any WordPress install.

## What's in here

```
wp-content/themes/b2b-wholesale-suite/   ← the custom theme (all the design/layout code)
database/b2b_wholesale_suite.sql         ← full DB export: Home/Features/Pricing/FAQ/Contact
                                            pages, the 6 blog posts, and the nav menu
```

## How to deploy this on a live host (or a fresh local install)

1. **Get WordPress core.** Most hosts (and one-click installers) already provide this.
   If starting from scratch, download the latest version from
   [wordpress.org/download](https://wordpress.org/download/) and upload it to your
   server, or use your host's WordPress installer.

2. **Create a MySQL database** on your host (any name/user/password — note them down).

3. **Import the database.** Using phpMyAdmin (most hosts have this) or the command line:
   ```
   mysql -u YOUR_DB_USER -p YOUR_DB_NAME < database/b2b_wholesale_suite.sql
   ```

4. **Upload the theme.** Copy `wp-content/themes/b2b-wholesale-suite/` into your host's
   `wp-content/themes/` folder (via FTP/SFTP or your host's file manager).

5. **Configure `wp-config.php`** on your host with your real database name, username,
   password, and host (your host usually creates this for you, or copies it from
   `wp-config-sample.php` in the WordPress core package). Also update these two rows in
   the database after import so the site points at your real domain instead of
   `localhost:8888` (in phpMyAdmin, table `wp_options`, or via WP-CLI):
   ```sql
   UPDATE wp_options SET option_value = 'https://yourdomain.com' WHERE option_name IN ('siteurl','home');
   ```

6. **Activate the theme** in `wp-admin` → Appearance → Themes → "B2B Wholesale Suite" → Activate.

7. **Re-save permalinks** in `wp-admin` → Settings → Permalinks (just click Save) so the
   `/features/`, `/pricing/`, `/faq/`, `/blog/`, `/contact/` URLs work correctly on your host.

8. Update the placeholder bits before going fully live:
   - The `mailto:hello@b2bwholesalesuite.com` address on the Contact page (marked as a placeholder).
   - The `[PRICE]` figures on the Pricing page, if/when pricing tiers are introduced.
   - The "Install/Get the App" button links (currently `#`) — point them at your real
     Shopify App Store listing once it's live.

## Local development

This was built and tested locally against MAMP (PHP 8.3, MySQL 8, Apache on port 8888).
If you want to keep developing locally before deploying:

1. Install [MAMP](https://www.mamp.info/) (or any local PHP/MySQL stack).
2. Download WordPress core into your local server's document root.
3. Follow steps 2–7 above, pointing at your local MySQL instance instead.

## Design notes

- Theme is plain PHP + vanilla CSS/JS — no build step, no npm/Composer required.
- Motion libraries (GSAP, Lenis, Three.js) load from CDN (`functions.php`); no bundling needed.
- Page content (hero sections, feature grids, etc.) is stored as Custom HTML blocks in
  each page's content — editable directly in the WordPress block editor.
- Blog posts use standard WordPress blocks (heading/paragraph) — fully WYSIWYG editable.
