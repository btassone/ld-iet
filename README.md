# ld-iet
An import / export plugin for Learn Dash

## Important Information

**MySQL Port:** 3372

**Apache2 Port:** 4567 - From your machine localhost:4567 when the vagrant is up.

**SSH Port:** 2222 | User: vagrant, password: vagrant

**Required Tech:** Should be nothing, everything is on the vagrant.

**Requires**

node, bower, sass. Please have all 3 of these installed globally.

**Setup After Download**

In the plugin directory run these commands from the command line

php composer.phar install (if you don't have composer installed globally)

npm install

bower install

tsd install (located under node_modules/.bin for local copy)

Those 4 commands should take care of all the package installation. Currently you must have both npm and bower installed. Looking into using a local copy of bower and making this a 1 command install if I can. For right now this should work fine however.

Commands for running watchers / building:

gulp - default watcher, watches for sass and typescript changes. outputs typescript changes to the dev folder.

gulp build - for when you want to push your development changes after testing to the Main.js file (concatenates everything to that file). This will allow you to see javascript changes in the plugin.

gulp test - the jasmine test runner for your tests in resources/js/tests

**Testing**

Currently I have testing working through the use of PHPStorm. I am using the composer auto-loader in conjunction with PHPUnit. There is a local phpunit file on the vagrant box. I am currently using that for my testing (via the remote options in phpstorm). You could run PHP locally on the vagrant box from the command line. Not sure how to hook it up with other IDE's. This option however will allow us to keep testing contained to the local vagrant rather than on each of our computers (less setup). If you need help running the tests please let me know. This might be the most confusing part at the moment.

**PHPStorm Notes**

If you use PHPStorm, do not forget to mark the src folder as the sources root, the tests folder as the tests sources root, and the resources folder as the resources root.
