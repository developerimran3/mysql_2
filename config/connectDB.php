<?php

/**
 * 
 */

function connect()
{
    try {
        $connection = new PDO("mysql:host=localhost;dbname=students", "imran", "27432afnanimu@");
        return $connection;
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
}
