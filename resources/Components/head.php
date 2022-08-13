<?php session_start();
include("$components/dbconfig.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo ($title) ?></title>
  <meta charset="UTF-8" />
  <meta name="author" content="John Naughton" />
  <meta name="description" content="Aston Events coursework webapp. Book and view upcoming Aston University events here!" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/resources/css/style.css">

<!-- Legacy code I was testing - allows additional stylesheet imports for different pages while still using the same head.php file -->
  <?php if (isset($styles)) {
    foreach ($styles as $style) {
      echo ("<link rel='stylesheet' type='text/css' href='/resources/css/$style' />");
    }
  } ?>

  <link rel="icon" href="/resources/images/icon.ico" />
</head>