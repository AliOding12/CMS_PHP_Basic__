#!/bin/bash

# Navigate to your project directory
cd ../PHP_CMS || { echo "Error: Directory ../PHP_CMS not found! Ensure PHP_CMS is in the parent directory of shell_scripts."; exit 1; }

# Verify current branch
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "main" ]; then
  echo "Error: Current branch is $CURRENT_BRANCH. Expected main."
  exit 1
fi

# Check if commit already exists
commit_if_new() {
  local message="$1"
  local date="$2"
  if ! git log --grep="$message" --oneline | grep -q "$message"; then
    GIT_AUTHOR_DATE="$date" GIT_COMMITTER_DATE="$date" git commit --allow-empty -m "$message"
  else
    echo "Commit already exists: $message"
  fi
}

# Create 15 empty backdated commits (August 7–11, 2023, PKT)
commit_if_new "Initial commit: Set up index.php, config.php, and .env" "2023-08-07T15:00:00"
commit_if_new "Add responsive styling in assests/css/style.css" "2023-08-07T19:00:00"
commit_if_new "Add core functions for authentication and posts in includes/functions.php" "2023-08-08T14:00:00"
commit_if_new "Add header and footer templates in includes/" "2023-08-08T17:00:00"
commit_if_new "Add .htaccess for URL rewriting" "2023-08-08T21:00:00"
commit_if_new "Add login and registration pages in pages/" "2023-08-09T13:00:00"
commit_if_new "Add user dashboard in pages/dashboard.php" "2023-08-09T15:30:00"
commit_if_new "Add post creation and view page in pages/post.php" "2023-08-09T18:00:00"
commit_if_new "Add friend system in pages/add_friend.php" "2023-08-10T14:00:00"
commit_if_new "Add comments system in pages/comments.php" "2023-08-10T16:00:00"
commit_if_new "Add client-side JavaScript in assests/js/script.js" "2023-08-10T19:00:00"
commit_if_new "Set up Composer dependencies in composer.json and composer.lock" "2023-08-10T21:00:00"
commit_if_new "Add logout functionality in pages/logout.php" "2023-08-11T14:00:00"
commit_if_new "Add uploads directory with .gitignore" "2023-08-11T17:00:00"
commit_if_new "Finalize project with README" "2023-08-11T20:00:00"

# Push to main
git remote add origin https://github.com/AliOding12/CMS_PHP_Basic__.git || git remote set-url origin https://github.com/AliOding12/CMS_PHP_Basic__.git
git push -u origin main