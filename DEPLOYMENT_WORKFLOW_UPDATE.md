# GitHub Actions Workflow Update - .htaccess Deployment

## Problem

The GitHub Actions workflow was **not deploying the `.htaccess` file** to GoDaddy because:

1. **The workflow only packed `wp-content/`** - The `.htaccess` file is in the WordPress root directory, not inside `wp-content/`.
2. **The rsync had `.htaccess` in exclusions** - Even if it was in the archive, it was explicitly excluded from deployment.

## Changes Made

### 1. Updated Compression Step (Line 26)

**Before:**
```yaml
- name: Compress wp-content
  run: |
    tar -czf wp-content.tar.gz wp-content
```

**After:**
```yaml
- name: Compress wp-content
  run: |
    tar -czf wp-content.tar.gz wp-content .htaccess
```

Now the `.htaccess` file from the root directory is included in the deployment archive.

### 2. Added .htaccess Deployment Step (Lines 96-102)

Added a new section after the wp-content rsync that specifically deploys the `.htaccess` file:

```bash
echo "Deploying .htaccess to root directory"
if [ -f "$TMP_DIR/.htaccess" ]; then
  cp "$TMP_DIR/.htaccess" "$DEPLOY_PATH/.htaccess"
  echo ".htaccess deployed successfully"
else
  echo "Warning: .htaccess not found in archive"
fi
```

This copies the `.htaccess` file to the WordPress root directory on GoDaddy.

### 3. Removed .htaccess from rsync Exclusions (Line 81)

**Before:**
```bash
--exclude='.htaccess' \
--exclude='.user.ini' \
```

**After:**
```bash
--exclude='.user.ini' \
```

Removed the `.htaccess` exclusion from the rsync command (though it's now deployed separately).

### 4. Updated Workflow Trigger (Line 7)

**Before:**
```yaml
paths:
  - "wp-content/**"
  - ".github/workflows/deploy-wp-content.yml"
```

**After:**
```yaml
paths:
  - "wp-content/**"
  - ".htaccess"
  - ".github/workflows/deploy-wp-content.yml"
```

Now pushes that modify `.htaccess` will automatically trigger the deployment workflow.

## How It Works Now

1. **On Push to Main** (that changes `wp-content/**` or `.htaccess`):
   - Workflow triggers automatically
   - Compresses both `wp-content/` and `.htaccess` into a single archive
   - Uploads to GoDaddy's `/tmp` directory
   - Extracts the archive
   - Syncs `wp-content/` with rsync (excluding uploads, cache, etc.)
   - **Copies `.htaccess` to the WordPress root directory**
   - Cleans up temporary files

2. **Manual Trigger** (`workflow_dispatch`):
   - Can still be triggered manually from GitHub Actions tab
   - Deploys everything including `.htaccess`

## Testing the Update

After committing and pushing these workflow changes:

1. **Test Automatic Deployment:**
   ```bash
   # Make a change to .htaccess
   echo "# Test change" >> .htaccess
   git add .htaccess
   git commit -m "Test .htaccess deployment"
   git push origin main
   ```

2. **Check the Workflow:**
   - Go to GitHub → Actions tab
   - Watch the "Deploy wp-content" workflow run
   - Look for the log message: "Deploying .htaccess to root directory"
   - Verify it says ".htaccess deployed successfully"

3. **Verify on GoDaddy:**
   - SSH into your GoDaddy server
   - Check if the `.htaccess` file has your cache control headers:
   ```bash
   cat html/.htaccess  # Adjust path based on your GD_REMOTE_PATH
   ```

## Important Notes

⚠️ **Backup Warning**: The workflow will overwrite your GoDaddy `.htaccess` file. If GoDaddy added any server-specific configurations, they will be lost. Before deploying:

1. **Download your current GoDaddy `.htaccess` file**:
   ```bash
   sftp GD_SFTP_USER@GD_SFTP_HOST
   cd html  # or your GD_REMOTE_PATH
   get .htaccess
   ```

2. **Merge any GoDaddy-specific rules** into your local `.htaccess` file before pushing.

3. **Common GoDaddy-specific settings** to preserve:
   - PHP version selectors
   - Security rules
   - Custom error pages
   - Domain redirects

## Alternative Approach

If you don't want to overwrite the entire `.htaccess` file, you can:

1. **Keep the workflow as-is** (don't deploy `.htaccess`)
2. **Manually add the cache headers to GoDaddy's `.htaccess`** via SFTP or their file manager
3. **Or rely on PHP headers** - The `acme_add_nocache_headers()` function in `functions.php` already sets these headers via PHP

The PHP approach is safer if GoDaddy has custom `.htaccess` rules, but `.htaccess` headers are generally more reliable across different server configurations.

## Rollback

If you need to revert these changes:

```bash
git revert <commit-hash>
git push origin main
```

Or manually edit `.github/workflows/deploy-wp-content.yml` to remove:
- `.htaccess` from the tar command
- The "Deploying .htaccess" section
- `.htaccess` from the workflow paths trigger
