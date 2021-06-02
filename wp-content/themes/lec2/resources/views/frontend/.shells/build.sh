#!/usr/bin/env bash

git pull origin

yarn
OUTPUT=build yarn build:prod

npx rimraf ./dist
mkdir ./dist
cp -r ./build/* ./dist/
