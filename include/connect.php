<?php

require_once('.init.php');

function connect()
{
    try {
        $dbh = new PDO('mysql:host='.HOSTNAME.';dbname='.DBNAME,USERNAME,PASSWORD);
       
        }
    catch (PDOException $e)
        {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
        }

        return $dbh;
}