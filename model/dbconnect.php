<?php

function dbConnect()
{
  try {
    $options = [
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $bdd = new PDO("mysql:host=sql11.freemysqlhosting.net; dbname=sql11416819; charset=utf8", "sql11416819", "HlLknuiLHS", $options);

    return $bdd;
  } catch (\Throwable $th) {
    throw $th;
  }
}
