# Twig FE - Working setup guide

## Environment:
- NodeJS (ver. from 10.x)
  - Command to check version:
    ```
    $ node -v
    ``` 
  - Commands to update version:
  
    ```
    $ sudo npm cache clean -f
    $ sudo npm install -g n
    $ sudo n stable
    ```
- yarn (__`$ sudo npm install -g yarn`__)

## Mannual setup 
  If need automation setup please use `.shells/install.sh`, OR follow below steps:
  1. Copy `development-example.com` to `development.json`
  2. Copy `production-example.com` to `production.json`
  3. Edit settings in the copied files if needed.
  4. Copy `yarn.lock.example` to `yarn.lock`.
  5. Run `$ yarn install` to install `node_modules`.

## Working Commands:

**Development**: `yarn start`

**Build production**: `yarn build:prod`

## Shells annotation
 1. `.shells/install.sh` Auto install and config (*Alternative to mannual setup*): 
 2. `.shells/build.sh` Build for production
 3. `.shells/push-dist.sh` Build and push folder dist to **fe-dist** branch 
 4. `.shells/pull-dist.sh` Pull folder dist from **fe-dist** branch  

## How to build new frontend version

1. Execute `.shells/build.sh` on your local machine.
2. Commit the changes in dist folder created by the `.shells/build.sh`script.
3. Push the source code.
4. Go to piplines and click `deploy_staging` or `deploy_dev`
