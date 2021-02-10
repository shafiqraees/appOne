<?php
/** Copyright (c) 2017 PayFast (Pty) Ltd You (being anyone who is not PayFast (Pty) Ltd) may download
 * and use this code for testing purposes, in conjunction with a registered and active PayFast account.
 * If your PayFast account is terminated for any reason, you may not use this code or part thereof.
 * Except as expressly indicated in this licence, you may not use, copy, modify or distribute this
 * code or part thereof in any way.
 */

// This is the Notify page (a.k.a. Callback page or ITN page) which does all the ‘heavy lifting’
// with regards to updating your database with payment information etc.

require( 'payfast_common.inc' );

// Notify PayFast that information has been received
pflog( 'PayFast ITN call received' );

// Variable Initialization
$pfError = false;
$pfErrMsg = '';
$pfDone = false;
$pfData = array();
/*$pfHost = 'sandbox.payfast.co.za';*/
$pfHost = 'sandbox.payfast.co.za';
$pfOrderId = '';
$pfParamString = '';

// Check the header response
if( !$pfError && !$pfDone )
{
    header( 'HTTP/1.0 200 OK' );
    flush();
}

// Get data sent by PayFast
pflog( 'Get posted data' );

// Posted variables from ITN
$pfData = pfGetData();

pflog( 'PayFast Data: '. print_r( $pfData, true ) );

if( $pfData === false )
{
    $pfError = true;
    $pfErrMsg = PF_ERR_BAD_ACCESS;
}

// Strip any slashes in data
foreach( $pfData as $key => $val )
{
    $pfData[$key] = stripslashes( $val );
}
$oldvalue=0;

$value=2;         // Update order as required
//$host     = "167.71.217.12";
$host     = "localhost";
$user     = "appone_stagging";
$password = "d?=S7{WwuqJX";
$database = "appone_stagging";

//error_reporting(0); # this is for when u convert ur server
$connection = mysqli_connect($host, $user, $password,$database) or die(mysqli_error());
$admincomission=0;


$today=date('Y-m-d H:i');
$query_addcredits="INSERT INTO marketer_packages (package_id, user_id,created_at)
  VALUES ('".$pfData['custom_int1']."','".$pfData['custom_int3']."','".$today."');";
$res = mysqli_query($connection,$query_addcredits);
#------------------------ insert record in transaction-------------------------------#
$query_addintransaction="INSERT INTO user_transactions (package_id,user_id,transaction_id,fee,created_at)
VALUES ('".$pfData['custom_int1']."','".$pfData['custom_int3']."','".$pfData['m_payment_id']."','".$pfData['custom_str1']."','".$today."');";
$result = mysqli_query($connection,$query_addintransaction);

//// Verify security signature
if( !$pfError && !$pfDone )
{
    pflog( 'Verify security signature' );

    $pfPassPhrase = 'Starshare246'; // Set your passphrase here

    // If signature different, log for debugging
    if( !pfValidSignature( $pfData, $pfParamString, $pfPassPhrase ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_INVALID_SIGNATURE;
    }
}

//// Verify source IP (If not in debug mode)
if( !$pfError && !$pfDone && !PF_DEBUG )
{
    pflog( 'Verify source IP' );

    if( !pfValidIP( $_SERVER['REMOTE_ADDR'] ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
    }
}

//// Verify data received
if( !$pfError )
{
    pflog( 'Verify data received' );

    $pfValid = pfValidData( $pfHost, $pfParamString );

    if( !$pfValid )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_ACCESS;
    }
}

//// Check Amounts
$dbAmount = $pfData['amount_gross'];

$amountCheck = pfAmountsEqual( $dbAmount, $pfData['amount_gross'] );

if ( !$amountCheck )
{
    $pfError = true;
    $pfErrMsg = PF_ERR_AMOUNT_MISMATCH;
}

if ( !$pfError )

    //// Check order status and update the order
    if( !$pfError && !$pfDone )
    {
        pflog( 'Check order status and update the order' );

        if ( $pfData['payment_status'] == 'COMPLETE' )
        {
            pflog( '- Complete' );
            // Update order as required
            $oldvalue=0;
            $value=2;         // Update order as required
            $host     = "localhost";
            $user     = "appone_stagging";
            $password = "d?=S7{WwuqJX";
            $database = "appone_stagging";
//error_reporting(0); # this is for when u convert ur server
            $connection = mysqli_connect($host, $user, $password,$database) or die(mysqli_error());
            $admincomission=0;
#------------------------------- make previous status 0---------------------------------------#


            $today=date('Y-m-d H:i');
            $query_addcredits="INSERT INTO marketer_packages (package_id, user_id,created_at)
  VALUES ('".$pfData['custom_int1']."','".$pfData['custom_int3']."','".$today."');";
            $res = mysqli_query($connection,$query_addcredits);
#------------------------ insert record in transaction-------------------------------#
            $query_addintransaction="INSERT INTO user_transactions (package_id,user_id,transaction_id,fee,created_at)
VALUES ('".$pfData['custom_int1']."','".$pfData['custom_int3']."','".$pfData['m_payment_id']."','".$pfData['custom_str1']."','".$today."');";
            $result = mysqli_query($connection,$query_addintransaction);

        }
    }

// If an error occurred
if( $pfError )
{
    pflog( 'Error occurred: '. $pfErrMsg );
}

