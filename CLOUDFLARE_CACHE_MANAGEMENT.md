# Cloudflare Cache Management for tuno.world

## Issue Identified

Your site is using **Cloudflare CDN** which is caching pages for **31 days** (`max-age=2678400`). This is why:
- Logged-in users see different content (bypass cache)
- Different PCs see different versions (different Cloudflare edge servers)
- Incognito mode shows different content (different cache state)

## Solution Deployed

I've updated the cache headers in `functions.php` to:
1. **Force 5-minute cache** (`max-age=300`)
2. **Add revalidation** (`must-revalidate`)
3. **Set Cloudflare-specific headers** (`CDN-Cache-Control`)
4. **Remove old cache headers** before setting new ones

## How to Purge Cloudflare Cache

### Option 1: Via Cloudflare Dashboard (Recommended)

1. **Log into Cloudflare Dashboard**
   - Go to https://dash.cloudflare.com/
   - Select your account
   - Click on `tuno.world` domain

2. **Purge Everything**
   - Go to **Caching** → **Configuration**
   - Click **Purge Everything** button
   - Confirm the purge

3. **Or Purge Specific URLs**
   - Go to **Caching** → **Configuration**  
   - Click **Custom Purge**
   - Enter URLs:
     ```
     https://tuno.world/
     https://tuno.world/*
     ```
   - Click **Purge**

### Option 2: Force Refresh Via URL

Visit your site with the force refresh parameter:
```
https://tuno.world/?force_refresh=1
```

This bypasses all cache layers and forces fresh content.

### Option 3: Via Cloudflare API

```bash
# Get your Cloudflare API credentials from dashboard
# Zone ID is found in the domain overview

curl -X POST "https://api.cloudflare.com/client/v4/zones/{ZONE_ID}/purge_cache" \
  -H "Authorization: Bearer {API_TOKEN}" \
  -H "Content-Type: application/json" \
  --data '{"purge_everything":true}'
```

## Recommended Cloudflare Settings

To prevent this issue in the future, configure Cloudflare:

### 1. Set Page Rules

Go to **Rules** → **Page Rules** and create:

**Rule 1: Bypass cache for admin**
- URL Pattern: `tuno.world/wp-admin*`
- Setting: Cache Level = Bypass

**Rule 2: Short cache for HTML**
- URL Pattern: `tuno.world/*`
- Settings:
  - Browser Cache TTL = 5 minutes
  - Edge Cache TTL = 5 minutes

### 2. Caching Configuration

Go to **Caching** → **Configuration**:
- **Browser Cache TTL**: 5 minutes (or "Respect Existing Headers")
- **Crawler Hints**: On
- **Query String Sort**: On

### 3. Enable Development Mode (Temporary)

When deploying changes:
1. Go to **Caching** → **Configuration**
2. Enable **Development Mode** (disables caching for 3 hours)
3. Test your changes
4. Development mode auto-disables after 3 hours

## Verify Cache Headers After Deployment

After deploying the new code, check headers:

```bash
curl -sI https://tuno.world
```

You should see:
```
cache-control: public, max-age=300, s-maxage=300, must-revalidate
cdn-cache-control: max-age=300
```

If you still see `max-age=2678400`, Cloudflare needs to be purged.

## Automatic Cache Purge (Optional)

If you want automatic Cloudflare cache purging when posts are published, install a plugin:

1. **Cloudflare Plugin**
   - Install: https://wordpress.org/plugins/cloudflare/
   - Configure with your Cloudflare API credentials
   - Automatically purges cache on post publish

2. **Or use a webhook in functions.php** (requires Cloudflare API token)

## Testing After Purge

1. **Purge Cloudflare cache** (via dashboard)
2. **Flush WordPress cache** (already done via SSH)
3. **Wait 2-3 minutes** for propagation
4. **Test in incognito mode**:
   ```bash
   # From your terminal
   curl -s "https://tuno.world?t=$(date +%s)" | grep "site-header__category-list" -A20
   ```

5. **Check different devices** - all should show same content now

## Why This Happened

The 31-day cache (`max-age=2678400`) is coming from either:
1. **Cloudflare's default settings** for your domain
2. **GoDaddy's server configuration** that Cloudflare respects
3. **WordPress default headers** that weren't being overridden

Our new code now:
- ✅ Removes old headers first
- ✅ Sets new headers with priority
- ✅ Adds Cloudflare-specific headers
- ✅ Runs on multiple hooks for redundancy

## Next Steps

1. **Deploy this change** (commit and push)
2. **Purge Cloudflare cache** (via dashboard)
3. **Configure Cloudflare page rules** (optional but recommended)
4. **Test from multiple devices/browsers**

After purging, all users should see the same up-to-date content, and the category menu will work correctly for everyone.
