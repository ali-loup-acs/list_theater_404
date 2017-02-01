# list_theater_404
list of spectacles per theater/region 

Main use of project:

This application is a search engine to look for contemporary shows/theatre in the area specified by the user (France only for the moment) and based on the following open source API:
																

							http://www.ressources-theatre.net/doc/api/

How to use it?

1 Get the database spectacles.sql
2 Export the entire project to your server 
3 Create file .init.php in the folder "include"

				<?php
define('DBNAME','dbname'); // variable constante, le nom de la variable en majuscule, et les données insérer à l'interieur de la variable en minuscule. //
define('HOSTNAME','localhost');
define('PASSWORD','password');
define('USERNAME','user');

4 Initialisation of the database will be done at first access of index.php file

5 First page displays name of the site and button on which access to input post-code is done by click

6 Specify the postcode in the input and link to second is done at input of the user


Details:

To be filled!


