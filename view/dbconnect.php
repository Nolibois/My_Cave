<?php

function dbConnect()
{
  try {
    $options = [
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $bdd = new PDO("mysql:host=localhost; dbname=mycave; charset=utf8", "root", "", $options);

    return $bdd;
  } catch (\Throwable $th) {
    throw $th;
  }
}
