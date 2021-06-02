#!/usr/bin/env bash

branch=$(git rev-parse --abbrev-ref HEAD)
commitMessage="donlq - build frontend"

# Exec frontend build
sh .shells/build.sh

if ([ -f dist/index.html ]); then
  # Push built files
  git stash
  git pull origin
  git stash apply
  git add *dist*
  git commit -m "$commitMessage"
  git push origin $branch
  echo '\nBUILD AND PUSHED!'
else
  echo '\nBUILD ERROR - SKIP PUSH!'
fi
