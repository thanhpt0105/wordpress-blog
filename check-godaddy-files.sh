#!/bin/bash
#
# GoDaddy File Checker Script
# 
# This script helps you verify files deployed to GoDaddy.
# You'll be prompted for your SSH password.
#

set -e

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}=== GoDaddy File Checker ===${NC}"
echo ""

# SSH credentials (hostname and username only - password will be prompted)
SSH_HOST="e1s.5f8.myftpupload.com"
SSH_USER="client_71c15edc7e_625627"
REMOTE_PATH="html"

echo -e "${GREEN}Connecting to: ${SSH_USER}@${SSH_HOST}${NC}"
echo "You will be prompted for your password..."
echo ""

# Function to run remote commands
run_remote() {
    local command=$1
    ssh "${SSH_USER}@${SSH_HOST}" "$command"
}

echo -e "${YELLOW}1. Checking WordPress root directory...${NC}"
run_remote "ls -lah ${REMOTE_PATH}/ | grep -E '(htaccess|wp-config|index)'"
echo ""

echo -e "${YELLOW}2. Checking if .htaccess exists and showing last 20 lines...${NC}"
run_remote "if [ -f ${REMOTE_PATH}/.htaccess ]; then echo 'File exists:'; tail -20 ${REMOTE_PATH}/.htaccess; else echo '.htaccess NOT FOUND'; fi"
echo ""

echo -e "${YELLOW}3. Checking custom-theme-3 directory...${NC}"
run_remote "ls -lah ${REMOTE_PATH}/wp-content/themes/custom-theme-3/ 2>/dev/null || echo 'Theme directory not found'"
echo ""

echo -e "${YELLOW}4. Checking functions.php modification time...${NC}"
run_remote "ls -lh ${REMOTE_PATH}/wp-content/themes/custom-theme-3/functions.php 2>/dev/null || echo 'functions.php not found'"
echo ""

echo -e "${YELLOW}5. Checking category-menu.php pattern...${NC}"
run_remote "ls -lh ${REMOTE_PATH}/wp-content/themes/custom-theme-3/patterns/category-menu.php 2>/dev/null || echo 'category-menu.php not found'"
echo ""

echo -e "${YELLOW}6. Checking for cache-related text in functions.php...${NC}"
run_remote "grep -n 'acme_get_categories_with_posts\|acme_clear_category_menu_cache' ${REMOTE_PATH}/wp-content/themes/custom-theme-3/functions.php 2>/dev/null || echo 'Cache functions not found in functions.php'"
echo ""

echo -e "${YELLOW}7. Checking for shortcode in category-menu.php...${NC}"
run_remote "cat ${REMOTE_PATH}/wp-content/themes/custom-theme-3/patterns/category-menu.php 2>/dev/null | grep -A2 -B2 'acme_category_menu' || echo 'Shortcode not found'"
echo ""

echo -e "${YELLOW}8. Checking .htaccess for cache control headers...${NC}"
run_remote "grep -n 'Cache-Control\|Custom Cache Control' ${REMOTE_PATH}/.htaccess 2>/dev/null || echo 'Cache control headers not found in .htaccess'"
echo ""

echo -e "${GREEN}=== Check Complete ===${NC}"
echo ""
echo -e "${YELLOW}TIP: To manually inspect files, connect via SFTP:${NC}"
echo "  sftp ${SSH_USER}@${SSH_HOST}"
echo ""
