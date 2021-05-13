<?php
session_start();
require 'model/model.php';

$msgError = [];

//////////// Home Page /////////////////////////////////
function index()
{
  require 'view/homeView.php';
}

///////////////////////// CONNECT USER ///////////////////////////
function formConnect()
{
  require 'view/connectUser.php';
}

///////////////////////// DISCONNECT USER ////////////////////////

function disconnectUser()
{
  session_destroy();
  require 'view/homeView.php';
}
