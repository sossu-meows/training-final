## Start the application:
- I suppose, your computer has been installed Docker. 
- If you have not installed docker on your machine, please follow [this](https://runnable.com/docker/install-docker-on-windows-10) to install docker.
- Basically, please edit _docker/.env for more suitable with your local machine.
- We can start application with the command below:
~~~
sh shells/start.sh
~~~         

- Please note:
    - Please exec into docker container **lec2_php** then run these tasks below.
    - Our site can't work probably on the 1st time, because lec2 theme doesn't have its dependencies for running, please use these command below to install them.
        ~~~
            cd wp-content/themes/lec2
            composer install
        ~~~    
    - In addition, Nginx's configuration file can not be copied from **_docker/nginx/config.d.dist** to **_docker/nginx/config.d**. We need to do it manually.
        ~~~
            sudo cp _docker/nginx/conf.d.dist/lec2.conf _docker/nginx/conf.d/lec2.conf 
        ~~~
    - After the file above is copied, we will jump into docker_nginx to reload it.
        ~~~
            docker exec -it lec2_nginx bash
        ~~~
      
        - In the nginx container, the command below will be executed to reload our Nginx.
        ~~~
        nginx -s reload
        ~~~
       
- Perhaps, the URL **lec2.local** can not be found on MAC, please update your **/etc/hosts** like below.
    ~~~
    xxxx.xxx.x.xxx lec2.local
    ~~~                 
    - xxx.xxx.x.xx is your MAC's ip.

- In Ubuntu, please add this line in your **/etc/hosts**
    127.0.0.1 lec2.local
    
### Please note:
- If you are using window, please run the command below for starting apache2 inside docker container.
~~~
chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && service mysql start && cd /etc/apache2/sites-available/ && a2ensite lec2.conf && service apache2 reload
~~~ 
    
##Commands
- The commands that can be called inside docker-contain.
   
    - After phpmyadmin has been installed, we can login into it via:
        - Username: root
        - Password: 123
    - Please refer to this following section to update **wp-config.php** on your localhost.
  
        ~~~
        // ** MySQL settings - You can get this info from your web host ** //
        /** The name of the database for WordPress */
        define( 'DB_NAME', 'lec2' );

        /** MySQL database username */
        define( 'DB_USER', 'root' );

        /** MySQL database password */
        define( 'DB_PASSWORD', '123' );

        /** MySQL hostname */
        define( 'DB_HOST', 'lec2_mariadb' );

        /** Database Charset to use in creating database tables. */
        define( 'DB_CHARSET', 'utf8mb4' );

        /** The Database Collate type. Don't change this if in doubt. */
        define( 'DB_COLLATE', '' );
        ~~~


##Note:
- At project's root folder, please look at the **.env** which contains the port forwarding between docker and real machine. It also contain the project path which is the source code folder.
 
    ~~~
    PROJECTS_PATH=./
    PORT=8677
    MYSQL_PORT=3327
    ~~~

- After everything has been executed successfully, you can delete or backup this folder (**docker/mysql/database.dist**).
- Please update wp-config.php with these information above.
- I have added user which has information ```admin / 123456```. We can use it to login into admin panel.
- In Admin > Installed Plugins , please active "Advanced Custom Fields PRO"
- Then, go to Custom Fields > Tool > Import Field Groups > Choose file wp-content/themes/lec2/acf-export-lec2.json 

##Config static-html path
- static-html files are be created on **wp-content/themes/lec2/resources/views/frontend/dist**
- Please add the code below into your **.htaccess** file.
    ~~~
        #update static html URL
        RewriteRule ^static-html/(.*)$ wp-content/themes/lec2/resources/views/frontend/dist/$1 [L]
    ~~~
    
    - It look like:
        ```php
           
            <IfModule mod_rewrite.c>
            RewriteEngine On
            
            #update static html URL
            RewriteRule ^static-html/(.*)$ wp-content/themes/lec2/resources/views/frontend/dist/$1 [L]
            
            RewriteBase /
            RewriteRule ^index\.php$ - [L]
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule . /index.php [L]
            
            </IfModule>
           
        ```
     
    - We can review these created static-html files via this URL {you_domain}/static-html/sitemap.html
