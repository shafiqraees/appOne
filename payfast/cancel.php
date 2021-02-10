<?php
/** Copyright (c) 2017 PayFast (Pty) Ltd You (being anyone who is not PayFast (Pty) Ltd) may download
 * and use this code for testing purposes, in conjunction with a registered and active PayFast account.
 * If your PayFast account is terminated for any reason, you may not use this code or part thereof.
 * Except as expressly indicated in this licence, you may not use, copy, modify or distribute this
 * code or part thereof in any way.
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Cancel Page</title>
    <meta charset="utf-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</head>

<style>

    @font-face {
    font-family: 'pt sans';
    font-style: normal;
    font-weight: normal;
    src: local('PT Sans'), local('PTSans-Regular'),
      url('pt_sans/PT_Sans-Web-Regular.ttf');  }

    h1, p { font-family:'pt sans';
           font-size:15px;  }

</style>

<body>

    <div class="jumbotron text-center">
        
        <h1>Cancel Page</h1>
        <p>This is an example of a Cancel Page</p>

    </div>

    <div class="container" >
    
      <p>The buyer arrives at this page on your website once a payment has been cancelled by them on PayFast.
      </p>
      <p>
      This has been defined by the cancel_url on the checkout page.
      </p>
      <p>      
      Example text: <strong>Your payment has been cancelled.</strong>
      </p>

    </div>

</body>

</html>