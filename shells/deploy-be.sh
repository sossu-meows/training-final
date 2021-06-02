#!/usr/bin/env bash

#cp -r ./wp-content/uploads.dist/* ./wp-content/uploads
#chgrp www-data ./wp-content/uploads -R
#chmod -R 775 ./wp-content/uploads

# Clean local branch
git reset --hard
git pull origin

# Switch to CI branch
git checkout -f $CI_COMMIT_REF_NAME

# Reset to CI commit
echo "\n"
git reset --hard $CI_COMMIT_SHA

# Show commit mesage
git log -1
echo "\n"

# Clear twig cache
echo "- Clear twig wp-content/uploads/cache folder"
pwd
rm -rf /var/www/lec2/wp-content/uploads/cache/*

