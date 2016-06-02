# ld-iet
An import / export plugin for Learn Dash

## Important Information

MySQL Port: 3372
Apache2 Port: 4567 - From your machine localhost:4567 when the vagrant is up.
SSH Port: 2222 - User: vagrant, password: vagrant

Required Tech: Should be nothing, everything is on the vagrant.

The files that allow for Wordpress Unit Testing are located at /var/www/html/wordpress-core on the vagrant vm. The bootstrap file in the plugin
 directory under plugin-development pulls in the wordpress-core unit testing classes.
 
All PHP code for the plugin with be under the CorduroyBeach namespace.

I am using everything on the vagrant vm. What I mean by that is I am running the PHP5.9 version from the vagrant as my php version. I am also
using the phpunit.phar located in the composer vendor folder (its in bin). Using these 2 things should be all that you need in order to start
testing right away. No need for php/mysql/apache on your local machine.

I have all these things working using PHPStorm. If you need any help setting it up with a different IDE let me know.

I might put a video walk through tutorial at some point later.
