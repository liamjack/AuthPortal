# AuthPortal
### What is it

![AuthPortal Screenshot][1]

AuthPortal is an easy to use authentication portal, giving new or old projects a simple way of authenticating users, quickly and securely using a PHP API for the backend and an AngularJS client for the frontend.

### Features
* Uses [bcrypt](http://en.wikipedia.org/wiki/Bcrypt) to hash passwords, a secure algorithm that uses an expensive key setup phase
* Uses an individual 128 bit salt for each user, pulled from /dev/urandom, making rainbow tables useless
* Uses PHP's [PDO](http://php.net/manual/en/book.pdo.php) database interface and uses prepared statements meaning an efficient system, resilient against SQL injection
* Logs user actions on  the site for various security reasons
* Blocks attackers by IP for any defined time after any amount of failed actions on the portal
* No plain text passwords are sent or stored by the system
* Integrates easily into most existing websites, and can be easily built upon for new projects
* Uses [AngularJS](https://angularjs.org/), [Flight](http://flightphp.com/) and [Pure](http://purecss.io/) to provide a clean looking and fast authentication portal
* Easy configuration of multiple system parameters

### User actions
* Login
* Register
* Activate account
* Resend activation email
* Reset password
* Change password
* Change email address
* Delete account
* Logout

### Requirements
Using the AuthPortal requires a web server running PHP 5.3.7 and above, a MySQL database and PHP sendmail needs setting up correctly so that account activation emails get sent correctly.

### Configuration
To install AuthPortal you first need to upload all the files to the webserver, via FTP, SFTP, ...
Next up you need to create the database, using a tool such as PHPMyAdmin. First create the database :

![PHPMyAdmin Create database][2]

Now you can import the database, by selecting "Import" once inside the new database.

![PHPMyAdmin Import database][3]

Your new database should now be populated with the following tables :

![PHPMyAdmin Database view][4]

The database part is complete, now we have to tell the AuthPortal which database to use, and setup some other parameters. With a text editor (Notepad, Notepad++, Sublime Text...) open up api/database.php

In the file are 4 different database parameters that you have to change to allow the API to communicate with the database server.

* `$db_host`: The database hostname or IP address, usually "localhost"
* `$db_user` : The database user's username, sometimes root if it's your own server
* `$db_pass` : The database user's password
* `$db_name` : The database name, if you followed my installation instructions it should be authportal

Other parameters are configurable inside the database, via PHPMyAdmin for the moment (admin panel will come shortly), in the "config" table. Here is a quick explanation for each parameter :

* `site_name` : the name of the website to display in the activation and password reset emails
* `site_url`: the URL of the AuthPortal root, where you installed the system, without the trailing slash, also used for emails.
* `site_email` : the email address from which to send activation and password reset emails
* `cookie_name` : the name of the cookie that contains session information, do not change unless necessary
* `cookie_path` : the path of the session cookie, do not change unless necessary
* `cookie_domain` : the domain of the session cookie, do not change unless necessary
* `cookie_secure` : the HTTPS only setting of the session cookie, do not change unless necessary
* `cookie_http` : the HTTP only protocol setting of the session cookie, do not change unless necessary
* `site_key` : a random string that you should modify used to validate cookies to ensure they are not tampered with
* `duration_remember` : the time that a user will remain logged in for when ticking "remember me" on login. Must respect PHP's [strtotime](http://php.net/manual/en/function.strtotime.php) format.
* `duration_non_remember` : the time a user will remain logged in when not ticking "remember me" on login.  Must respect PHP's [strtotime](http://php.net/manual/en/function.strtotime.php) format.
* `bcrypt_cost` : the algorithmic cost of the bcrypt hashing function, can be changed based on hardware capabilities

The rest of the parameters generally do not need changing.

Now the AuthPortal should function correctly, allowing you to create an account and login.

### License

Copyright (C) 2014 - 2014 PHPAuth

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/

### Contributing

Anyone can contribute to improve or fix the AuthPortal, to do so you can either report an issue (a bug, an idea...) or fork the repository, perform modifications to your fork then request a merge.

### Credits

* [password_compat](https://github.com/ircmaxell/password_compat) - ircmaxell
* [Flight](https://github.com/mikecao/flight) - mikecao
* [angular-loading-bar](https://github.com/chieffancypants/angular-loading-bar) - chieffancypants
* [angular.js](https://github.com/angular/angular.js) - angular
* [Pure](https://github.com/yui/pure) - yui


  [1]: http://i.imgur.com/B1taXzp.png
  [2]: http://i.imgur.com/n7nLfnS.png
  [3]: http://i.imgur.com/aLUgtbM.png
  [4]: http://i.imgur.com/9Dy6CUN.png