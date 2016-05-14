# Simple core framework
**Simple example of homemade framework.**

Prehistory: *(Why i did it)*  
*One day I was asked to correct on some website some information.
As it turned out the site was static.
The task was that it would be correct title, description, keywords tags on pages.
Just hardcode them in html I did not want ...
Pulls on the CMS website, too, did not want to ...
I decided to make the admin panel and quickly make from sketch a kind of framework.
Of course, I could use for example the laravel.
But I wanted to write it from scratch,* **just for fun.**

Features:

+ Controller and actions
+ One dependency container in `Core::$app`
+ Simple routing to controller\action
+ Base model class with validation
+ Base ORM class for working with SQL database
+ Url helper
+ Request helper
+ Session and Flash helpers
+ Base controller class
+ Templating system
+ Database migrations
+ Configuration for working with SQLite instead MySQL
+ Symfony2 coding style
