# ld-iet
An import / export plugin for Learn Dash

## Important Information

**MySQL Port:** 3372

**Apache2 Port:** 4567 - From your machine localhost:4567 when the vagrant is up.

**SSH Port:** 2222 | User: vagrant, password: vagrant

**Required Tech:** Should be nothing, everything is on the vagrant.

**Setup After Download**

In the plugin directory run these commands from the command line

npm install

bower install

Those 2 commands should take care of all the package installation. Currently you must have both npm and bower installed. Looking into using a local copy of bower and making this a 1 command install if I can. For right now this should work fine however.

For running the watcher use
Windows: npm run dev-win
Linux/OSX: npm run dev-unx

**Testing**

Currently I have testing working through the use of PHPStorm. I am using the composer autoloader in cunjunction with PHPUnit. There is a local phpunit file on the vagrant box. I am currently using that for my testing (via the remote options in phpstorm). You could run PHP locally on the vagrant box from the command line. Not sure how to hook it up with other IDE's. This option however will allow us to keep testing contained to the local vagrant rather than on each of our computers (less setup). If you need help running the tests please let me know. This might be the most confusing part at the moment.
