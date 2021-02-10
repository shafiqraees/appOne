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

    <title>API Test Page</title>
    <meta charset="utf-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
        src: local('PT Sans'), local( 'PTSans-Regular' ),
        url( 'pt_sans/PT_Sans-Web-Regular.ttf' );
    }

    h1, p {
        font-family: 'pt sans';
        font-size: 15px;
    }

</style>

<body>

<div class="jumbotron text-center">

    <h1>API Tool</h1>
    <p>For testing purposes only.</p>

</div>

<div class="container" style="font-size:15px;font-family:pt sans;">

    <?php

    // Display the POST variables for development purposes only
    echo '<br><br><span style="font-size:30px;">Your variables provided </span><br><br>';
    var_dump( $_POST );
    echo '<br><br>';

    $pfData = $_POST;

    // Set timestamp
    $timestamp = date( 'Y-m-d' ) . 'T' . date( 'H:i:s' );
    $pfData['timestamp'] = $timestamp;

    // Sort the array alphabetically by key
    ksort( $pfData );

    // Normalise the array into a parameter string
    $pfParamString = '';
    foreach( $pfData as $key => $val )
    {
        if( !empty($val) && $key != 'api_action' && $key != 'submit' && $key != 'token' )
        {
            $pfParamString .= $key .'='. urlencode( trim( $val ) ) .'&';
        }
    }

    // Remove the last '&amp;' from the parameter string
    $pfParamString = substr( $pfParamString, 0, -1 );

    echo '<span style="font-size:30px;">Your Results </span><br><br>';

    // Display GET string
    echo '<strong>GET String generated: </strong><br />' . htmlentities( $pfParamString ) . '<br><br>';

    // Create the hashed signature from the url-encoded string
    $signature = md5( $pfParamString );

    // Display signature
    echo '<strong>Signature generated: </strong><br/>' . $signature . '<br><br>';

    // Set and display action
    $action = '';

    if ( $pfData['api_action'] )
    {
        $action = $pfData['api_action'];
    }

    echo '<strong>Action: </strong>' . $action . '<br><br>';

    // Set the method, based on the action, and display
    function setMethod( $action )
    {
        switch ( $action )
        {
            case 'fetch':
                return 'GET';
                break;
            case 'pause':
            case 'unpause':
            case 'cancel':
                return 'PUT';
                break;
            case 'update':
                return 'PATCH';
                break;
            case 'adhoc':
                return 'POST';
                break;
            default:
                break;
        }
    }

    $method = setMethod( $action );
    echo '<strong>Method: </strong>' . $method . '<br><br>';

    // Check for token
    $token = ( $pfData['token'] ? $pfData['token'] . '/' : '' );

    // Ensure POSTFIELDS does not include unnecessary fields
    $payload = '';
    $exclude = array( 'api_action', 'submit', 'token', 'passphrase', 'version', 'merchant-id', 'timestamp');
    foreach( $pfData as $key => $val )
    {
        if( !empty($val) && !in_array($key, $exclude))
        {
            $payload .= $key .'='. urlencode( trim( $val ) ) .'&';
        }
    }

    // Remove the last '&amp;' from the payload string
    $payload = substr( $payload, 0, -1 );

    // Display cURL details that are being used
    echo '<strong>URL: </strong>' . 'https://api.payfast.co.za/subscriptions/' . $token . $action . '?testing=true' . '<br>' ;
    echo '<strong>postfields: </strong>' . htmlentities( $payload ) . '<br>' ;
    echo '<strong>version: </strong>' . $pfData['version'] . '<br>' ;
    echo '<strong>merchant-id: </strong>' . $pfData['merchant-id']. '<br>' ;
    echo '<strong>signature: </strong>' . $signature . '<br>' ;
    echo '<strong>timestamp: </strong>' . $timestamp . '<br><br>' ;

    // Configure curl
    $ch = curl_init( 'https://api.payfast.co.za/subscriptions/' . $token . $action . '?testing=true' );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        'version: ' . $pfData['version'],
        'merchant-id: ' . $pfData['merchant-id'],
        'signature: ' . $signature,
        'timestamp: ' . $timestamp
    ) );

    // Execute and close cURL
    $response = curl_exec( $ch );
    curl_close( $ch );

    // Display response
    echo '<strong>CURL Response: </strong><br>';
    var_dump( $response );
    echo '<br><br><br><br><br><br><br><br><br><br>';

    die;

    ?>

</div>

</html>