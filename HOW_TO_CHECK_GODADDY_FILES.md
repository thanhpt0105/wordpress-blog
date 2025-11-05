# How to Check Your GoDaddy Files

## ⚠️ SECURITY FIRST
**IMMEDIATELY change your SSH password** since you shared it. Go to GoDaddy control panel → SFTP/SSH settings → Reset password.

## Quick SSH Commands

### 1. Connect to GoDaddy
```bash
ssh client_71c15edc7e_625627@e1s.5f8.myftpupload.com
```
You'll be prompted for your password (use the NEW password after changing it).

### 2. Once Connected, Run These Commands

#### Check if .htaccess was deployed:
```bash
ls -lh html/.htaccess
cat html/.htaccess
```

#### Check if theme files are updated:
```bash
# Check functions.php modification time
ls -lh html/wp-content/themes/custom-theme-3/functions.php

# See if cache functions exist
grep -n "acme_get_categories_with_posts" html/wp-content/themes/custom-theme-3/functions.php
```

#### Check category-menu.php pattern:
```bash
cat html/wp-content/themes/custom-theme-3/patterns/category-menu.php
```

#### Verify cache control headers in .htaccess:
```bash
grep -A5 "Custom Cache Control" html/.htaccess
```

#### Check when files were last modified:
```bash
ls -lt html/wp-content/themes/custom-theme-3/functions.php
ls -lt html/wp-content/themes/custom-theme-3/patterns/category-menu.php
ls -lt html/.htaccess
```

### 3. Exit SSH
```bash
exit
```

## Using the Helper Script (Easier)

I created a script that checks everything automatically:

```bash
# Run the script from your project directory
./check-godaddy-files.sh
```

This will:
- Check if .htaccess exists
- Verify cache control headers
- Check if functions.php has the cache functions
- Verify category-menu.php has the shortcode
- Show file modification times

You'll be prompted for your SSH password once.

## Using SFTP to Download and Inspect Files

### With Command Line:
```bash
sftp client_71c15edc7e_625627@e1s.5f8.myftpupload.com
cd html
get .htaccess
get wp-content/themes/custom-theme-3/functions.php
get wp-content/themes/custom-theme-3/patterns/category-menu.php
exit

# Now view them locally
cat .htaccess
cat functions.php | grep "acme_get_categories"
```

### With GUI Client (FileZilla, Cyberduck, etc.):
1. Open your SFTP client
2. Connect with:
   - Host: `e1s.5f8.myftpupload.com`
   - Port: `22`
   - Protocol: `SFTP`
   - Username: `client_71c15edc7e_625627`
   - Password: `[your NEW password]`
3. Navigate to `html/` directory
4. Download files to inspect locally

## What to Look For

### ✅ In `.htaccess`:
Should contain:
```apache
# BEGIN Custom Cache Control for Dynamic Content
<IfModule mod_headers.c>
  <FilesMatch "\.(html|htm|php)$">
    Header set Cache-Control "public, max-age=300, must-revalidate"
  </FilesMatch>
  ...
</IfModule>
# END Custom Cache Control for Dynamic Content
```

### ✅ In `functions.php`:
Should contain:
```php
function acme_get_categories_with_posts() {
function acme_clear_category_menu_cache() {
function acme_category_menu_shortcode() {
```

### ✅ In `patterns/category-menu.php`:
Should contain:
```html
<!-- wp:shortcode -->
[acme_category_menu]
<!-- /wp:shortcode -->
```

NOT the old:
```html
<!-- wp:categories {"showPostCounts":false,...} /-->
```

## Verify Deployment Worked

After checking files, if they're updated:

1. **Clear GoDaddy Cache** (if they have a cache plugin/control panel)
2. **Test in incognito mode**:
   - Visit your site: https://tuno.world (or your domain)
   - Create a new post with a new category
   - Check if the category appears immediately in the menu

## Update GitHub Secrets

Don't forget to update your repository secrets with the credentials:

1. Go to: https://github.com/thanhpt0105/wordpress-blog/settings/secrets/actions
2. Update:
   - `GD_SFTP_HOST` = `e1s.5f8.myftpupload.com`
   - `GD_SFTP_USER` = `client_71c15edc7e_625627`
   - `GD_SFTP_PASSWORD` = `[NEW PASSWORD - after you change it!]`
   - `GD_SFTP_PORT` = `22`
   - `GD_REMOTE_PATH` = `html`

## Need Help?

If files aren't updated:
1. Check GitHub Actions logs to see if deployment succeeded
2. Look for errors in the workflow run
3. Verify the remote path is correct (`html` vs `public_html` vs root)
