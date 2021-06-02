##Start the application:
- I suppose, your computer has been installed docker. 
- If you have not installed docker on your machine, please follow [this](https://runnable.com/docker/install-docker-on-windows-10) to install docker.
- We can start application with the command below:
~~~
sh start.sh
~~~         
  
-  Please update your **/etc/hosts** like below.
    ~~~
    xxxx.xxx.x.xxx {your_domain}.local
    ~~~                 
    - xxx.xxx.x.xx is your MAC's ip.
    
##Commands
- The commands that can be called inside docker-contain.
   
    - **cmd_init_all**: enable sites and mysql. We don't need to call it normally, because it was added into **sh start.sh command**
    - **cmd_init_phpmyadmin**: if you want to use phpmyadmin.
        - After phpmyadmin has been installed, we can login into it via:
            - Username: root
            - Password: 123
        -  However,I don't want to use Phpmyadmin. Actually, i use Navicat to connect into Mysql with:
            - Username: **root_remote** (User was allowed to use remote host)
            - Password: **123**
            - Port: **{your_configured_port_in_env_file}**    

##Note:
- At project's root folder, please look at the **.env** which contains the port forwarding between docker and real machine. It also contain the project path which is the source code folder.
 
    ~~~
    PROJECTS_PATH=./
    PORT=8456
    MYSQL_PORT=3316
    ~~~

- After everything has been executed successfully, you can delete or backup this folder (**docker/mysql/database.dist**).
- Please update wp-config.php with these information above.
- I have added user which has information admin / admin123456!@#. We can use it to login into admin panel.

