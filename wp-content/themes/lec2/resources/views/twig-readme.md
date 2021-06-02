#Layout sample:
- The following code block below demonstrate how to use wordpress's functions and where they will be added into twig template.
    ~~~
        <!DOCTYPE html>
        <html {{ language_attributes() }}>
                <head>
                    <meta charset="{{ blog_info( 'charset' ) }}">
                    <meta name="description" content="{{ site_description }}">
                    {{ wp_head() }}
                </head>
        
                <body {{ body_class() }}>
        
                    <div class="nav">
                        {{ wp_nav_menu('primary_navigation','nav') }}
                    </div>
        
                    <div style="float:  left; width: 60%">
                        {% block content %}
        
                        {% endblock %}
                    </div>
                    <div style="float:  left; width: 40%">
                        {% include "template/partial/sidebar.html.twig" %}
                    </div>
        
                    <div style="float: left; width: 100%">
                        <ul>
                            <li>{{ "hello" | trans }}</li>
                            <li>{{ asset_uri }}</li>
                            <li>{{ page_title }}</li>
                            <li>{{ global_3 }}</li>
                        </ul>
                    </div>
                    {{ wp_footer() }}
                </body>
        </html>
    ~~~

- I have added the **assets.json** that is used to registered styles and scripts for both frontend and backend parts. 
    
#Functions:
- These functions can be called in twig template. Please note the list below will be updated (add new or delete some functions) and they are already defined by **parsedFunctions** in **/app/Components/Twig/Twig.php**

     - **wp_head** This function will add wordpress head components that like: styles of this theme and the activated plugins.
          
     - **language_attributes**: this function will add lang attribute into html tag.
        - Example
            - In twig template
                    ``html
                        <html {{ language_attributes() }}>
                    ``
                
            - Our result:
                    ``html
                        <html lang="en-US">
                    ``
                    
     - **body_class**: wordpress will add body class via this function
        - Example 
         
            ``html
                <body {{ body_class() }}>
            ``             
        - Output
            
            ``html
                <body class="Added classes ">
            ``    
            
     - **dynamic_sidebar**: render the dynamic sidebar via sidebar's id
        - Example
            ``html
                {{ dynamic_sidebar('sidebar-primary') }}
            ``
        - We have list sidebar IDs like below, if you want to define a new sidebar id, please edit this file **/app/Components/Sidebars/Sidebars.php** 
            - sidebar-primary
            - sidebar-footer
            
    - **wp_nav_menu**: render navigation by its ID:
        - We have one id which is **primary_navigation**
        - Example:
        
            ``html
                 {{ wp_nav_menu('primary_navigation','nav') }}
            ``
        - Output
        
            ``html
                 <ul id="menu-menu-1" class="nav">
                    <li>...</li>
                    <li>...</li>
                    <li>...</li>
                 </ul>
            ``    
        - If you want to edit the IDs listing, you can do it via this file **app/Components/Menus/Menus.php**
   
    - **wp_footer** This function will add wordpress head components that like: scripts of this theme and the activated plugins.
    
    - **home_url**: Please refer [this](https://developer.wordpress.org/reference/functions/home_url/). In my opinion, this is used to add logo's link.
    - **blog_info**: please refer [this](https://developer.wordpress.org/reference/functions/bloginfo/)
    - **posts_navigation**: Please refer [this](https://codex.wordpress.org/Next_and_Previous_Links)
    - **get_search_form**: Please refer [this](https://developer.wordpress.org/reference/functions/get_search_form/)
 
#Filters
- These filters can be called in twig template. Please note the list below will be updated (add new or delete some filters) and they are already defined by **parsedFilter** into **/app/Components/Twig/Twig.php**
    - **trans** in twig template we can call it like this **{{ 'hello' | trans }}**. It will translate our text to the target language.
    - **esc_url**: we can call it like ** home_url() | esc_url **. This filter will eliminate invalid characters, and removes dangerous characters.
    
#Global variables
- These filters can be called in twig template. Please note the list below will be updated (add new or delete some variables) and they are already defined by **parsedGlobal** into **/app/Components/Twig/Twig.php**
    - **page_title**: The current page's title.
    - **site_description**: it can be used like this **<meta name="description" content="{{ site_description }}">**
    - **asset_uri**: this is the uri of the current theme asset folder and it same as this **http://Twig.local:8678/wp-content/themes/twig/resources/assets**. Actually, frontend developers can use this link to load their assets.
   