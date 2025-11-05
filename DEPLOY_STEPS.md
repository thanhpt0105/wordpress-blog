# Deployment Steps - Category Menu Cache Fix

## Current Situation
- ✅ Changes are made locally on branch `custom-theme-3`
- ✅ Changes are staged (some) but not committed
- ❌ Changes are NOT pushed to GitHub
- ❌ Changes are NOT deployed to GoDaddy

## Why Changes Aren't on GoDaddy
The GitHub Actions workflow only deploys when you push to the `main` branch.

## Steps to Deploy

### Option 1: Merge to Main and Deploy (Recommended)

```bash
# 1. Add all the changes to staging
git add .github/workflows/deploy-wp-content.yml
git add CATEGORY_MENU_FIX.md
git add DEPLOYMENT_WORKFLOW_UPDATE.md
git add HOW_TO_CHECK_GODADDY_FILES.md
git add check-godaddy-files.sh

# 2. Commit all changes
git commit -m "Fix: Category menu cache issue and deploy .htaccess

- Add custom category menu with cache invalidation
- Auto-clear cache when posts are published
- Deploy .htaccess with cache control headers
- Update GitHub Actions to include .htaccess deployment"

# 3. Switch to main branch
git checkout main

# 4. Merge your changes from custom-theme-3
git merge custom-theme-3

# 5. Push to GitHub (this will trigger the deployment)
git push origin main
```

### Option 2: Deploy from custom-theme-3 Branch

If you want to deploy directly from `custom-theme-3`, update the workflow first:

```bash
# 1. Add and commit all changes
git add .
git commit -m "Fix: Category menu cache issue and deploy .htaccess"

# 2. Push to your branch
git push origin custom-theme-3

# 3. Then manually trigger the workflow from GitHub:
#    Go to: https://github.com/thanhpt0105/wordpress-blog/actions
#    Click "Deploy wp-content" workflow
#    Click "Run workflow"
#    Select branch: custom-theme-3
#    Click "Run workflow"
```

**BUT** you need to update the workflow to allow manual runs from any branch.

### Option 3: Quick Deploy via Manual Workflow Trigger

```bash
# 1. Commit everything
git add .
git commit -m "Fix: Category menu cache issue and deploy .htaccess"

# 2. Push to custom-theme-3
git push origin custom-theme-3

# 3. Merge to main
git checkout main
git merge custom-theme-3
git push origin main
```

This will automatically trigger the deployment to GoDaddy.

## Recommended Approach

**I recommend Option 1** - it's the cleanest and will trigger the automatic deployment.

After running these commands:
1. Go to GitHub Actions: https://github.com/thanhpt0105/wordpress-blog/actions
2. Watch the "Deploy wp-content" workflow run
3. Wait for it to complete (usually 1-2 minutes)
4. Run `./check-godaddy-files.sh` again to verify deployment

## What Will Be Deployed

When you push to `main`, the following will be deployed:
- ✅ `wp-content/themes/custom-theme-3/functions.php` (with cache functions)
- ✅ `wp-content/themes/custom-theme-3/patterns/category-menu.php` (with shortcode)
- ✅ `.htaccess` (with cache control headers) **NEW!**
- ✅ All other theme files

## After Deployment

1. **Verify files on GoDaddy:**
   ```bash
   ./check-godaddy-files.sh
   ```

2. **Clear GoDaddy cache** (if they have a cache plugin/control panel)

3. **Test the fix:**
   - Create a new category
   - Create a new post with that category
   - Check if the category appears immediately in the menu (incognito mode)

## Troubleshooting

If deployment fails:
- Check GitHub Actions logs for errors
- Verify SSH credentials in GitHub Secrets
- Make sure `GD_REMOTE_PATH` is set to `html`
