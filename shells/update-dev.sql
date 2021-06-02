update  wp_options
set option_value = "http://lec2.docker.elidev.info:8689/"
where option_name = "siteurl" OR  option_name = "home"