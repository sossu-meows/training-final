#!/usr/bin/env bash

# Clean local branch
git reset --hard
git pull origin

# Switch to CI branch
git checkout -f $CI_COMMIT_REF_NAME

# Reset to CI commit
git reset --hard $CI_COMMIT_SHA

# Show commit mesage
echo "\n"
git log -1
echo "\n"
