#!/usr/bin/env bash

envDefaults=("production" "development")

echo -e "\033[32mCheck config files...\033[0m";
for env in "${envDefaults[@]}"
  do
    if [ ! -f config/$env.json ]; then
        echo "\033[32mCopy ${env}.json\033[0m";
        cp config/${env}-example.json config/$env.json
    fi
  done
