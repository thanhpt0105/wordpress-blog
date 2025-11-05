# Deployment Quick Reference

## 🚀 Quick Start

### Automatic Deployment (Recommended)
```bash
# Edit files
vim wp-content/themes/personal-blog/style.css

# Commit and push
git add .
git commit -m "Update styles"
git push origin main

# ✨ Deployment happens automatically!
```

### Manual Deployment
1. Go to **GitHub** → **Actions** → **Deploy wp-content**
2. Click **Run workflow**
3. Choose deployment mode:
   - ⚡ **Incremental** (default): Only changed files
   - 📦 **Force full deployment**: All files
4. Click **Run workflow**

## 📋 Required Secrets

Set these in GitHub Settings → Secrets → Actions:

### Essential
- `GD_SFTP_HOST` - GoDaddy hostname
- `GD_SFTP_USER` - SFTP username  
- `GD_SFTP_PASSWORD` - SFTP password
- `GD_REMOTE_PATH` - WordPress root (e.g., `html`)

### Optional (Cache Purging)
- `CLOUDFLARE_ZONE_ID` - From Cloudflare dashboard
- `CLOUDFLARE_API_TOKEN` - Create at dash.cloudflare.com/profile/api-tokens

## 🔍 Check Deployment Status

### In GitHub
1. Go to **Actions** tab
2. Click latest workflow run
3. Check:
   - ✅ Green checkmark = Success
   - ❌ Red X = Failed
   - 🟡 Yellow dot = Running

### On Server
```bash
# SSH into GoDaddy
ssh username@host

# Check deployed files
ls -la html/wp-content/themes/personal-blog/

# Check deployment time
stat html/wp-content/themes/personal-blog/style.css
```

### On Website
- Visit site in **incognito mode**
- Hard refresh: `Ctrl + Shift + R` (Windows/Linux) or `Cmd + Shift + R` (Mac)
- Check browser console for errors

## 🎯 What Gets Deployed

### ✅ Included
- `wp-content/themes/**` - Theme files
- `wp-content/plugins/**` - Plugin files
- `.htaccess` - Server configuration

### ❌ Excluded (Protected)
- `wp-content/uploads/**` - Media files
- `wp-content/mu-plugins/**` - Must-use plugins
- `wp-content/cache/**` - Cache files
- `wp-content/upgrade/**` - WordPress updates

## 🔧 Common Commands

### View Changed Files
```bash
# See what will be deployed
git diff --name-only HEAD~1 HEAD
```

### Test Locally First
```bash
# Start local WordPress
docker compose up -d

# Visit http://localhost:8080
# Test changes before pushing
```

### Check Cloudflare Cache
```bash
# Check cache headers
curl -I https://yourdomain.com | grep -i cache

# Should see:
# Cache-Control: public, max-age=300
```

## 🚨 Troubleshooting

### Changes Not Visible?

1. **Clear Cloudflare Cache**
   - Go to Cloudflare Dashboard
   - Caching → Configuration → Purge Everything

2. **Clear Browser Cache**
   - Hard refresh: `Ctrl + Shift + R`
   - Or use incognito mode

3. **Check Deployment Logs**
   - GitHub → Actions → Latest run
   - Look for "✅ Deployment completed"

### Deployment Failed?

1. **Check Secrets**
   - Verify all required secrets are set
   - Check for typos in secret values

2. **Check GoDaddy Connection**
   ```bash
   # Test SFTP connection locally
   sftp -P 22 username@host
   ```

3. **Check Workflow Logs**
   - Find error message in GitHub Actions
   - Look for red ❌ indicators

### Rollback Deployment

**Method 1: Git Revert**
```bash
git revert HEAD
git push origin main
# Automatically deploys previous version
```

**Method 2: Restore Backup**
```bash
# On GoDaddy server
cd html
tar -xzf /tmp/wp-content-backup-TIMESTAMP.tar.gz
```

**Method 3: Redeploy Old Version**
- GitHub → Actions → Find old successful run
- Click "Re-run all jobs"

## 📊 Performance

### Typical Deployment Times

| Scenario | Archive Size | Time | Speed Improvement |
|----------|--------------|------|-------------------|
| CSS/JS change | ~50 KB | 30s | **10x faster** |
| Theme update | ~500 KB | 45s | **6x faster** |
| Plugin update | ~2 MB | 1m | **4x faster** |
| Full deployment | ~50 MB | 5m | Baseline |

## 🎓 Best Practices

### ✅ Do
- Test locally before pushing
- Use descriptive commit messages
- Deploy during low traffic times
- Monitor deployment logs
- Keep backups

### ❌ Don't
- Push untested code
- Deploy during peak hours
- Skip commit messages
- Ignore deployment errors
- Forget to check production

## 🔗 Resources

- **Full Guide**: [IMPROVED_DEPLOYMENT_GUIDE.md](./IMPROVED_DEPLOYMENT_GUIDE.md)
- **Cache Management**: [CLOUDFLARE_CACHE_MANAGEMENT.md](./CLOUDFLARE_CACHE_MANAGEMENT.md)
- **Deployment History**: [DEPLOYMENT_WORKFLOW_UPDATE.md](./DEPLOYMENT_WORKFLOW_UPDATE.md)

## 💡 Tips

### Speed Up Deployments
- Only commit files you changed
- Use `.gitignore` for temporary files
- Avoid committing large media files

### Ensure Fresh Content
- Cloudflare cache auto-purges (if configured)
- Add `?t=123456` to URL to bypass cache
- Use incognito mode for testing

### Stay Safe
- Always check deployment logs
- Test in staging first (if available)
- Keep GoDaddy backups enabled
- Document custom server configs

---

**Need Help?** Check the [full deployment guide](./IMPROVED_DEPLOYMENT_GUIDE.md) or GitHub Actions logs for detailed error messages.
