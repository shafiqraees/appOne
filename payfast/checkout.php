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

    <title>Checkout Page</title>
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

    table#checkout { max-width: 800px;
                      font-size:15px;
                      font-family:'pt sans';  }
    table#checkout label { float: left;  }
    table#checkout input { width: 100%;}
                     
    table td  { padding: 1px;
                 text-align: left;
                 max-width: 200px;  }
    table tr  { max-width: 200px;  }  

    aside { padding: 1em;
        color: #B34B00;
        background: #FADEC8;
        font-size:15px;
        font-family:'pt sans';
        line-height: 1.6;
        border: 1px solid #B34B00;
        border-radius: 4px;
        max-width: 800px;  }

    h1, p { font-family:'pt sans';
             font-size:15px;  }

</style>

<body>

    <div class="jumbotron text-center">

        <h1>Checkout Page</h1>
        <p>The form below resembles the hidden form sent from the Checkout Page to PayFast</p> 

    </div>

    <div class="container" >

        <p>
        Please provide the input below, to review your GET string created, and the signature generated.<br>
        Then proceed to make a test payment using Sandbox.
        </p>
        <p>
        For your convenience, we have included the default sandbox testing credentials, as well as details for a test user.
        </p>

        <form action="signature.php" method="POST">
            <table id="checkout" class="table table-striped table-bordered" >

                <!-- Merchant Details -->
                <tr>
                    <td>
                        <label for="merchant_id">Merchant ID </label>          
                    </td>
                    <td>                          
                        <input type="text" name="merchant_id" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="merchant_key">Merchant KEY </label>     
                    </td>
                    <td>                                     
                        <input type="text" name="merchant_key" />
                    </td>
                </tr>
                <tr>  
                    <td>
                        <label for="return_url">Return URL </label>
                    </td>
                    <td>
                        <input type="url" name="return_url" />
                    </td>  
                </tr>
                <tr>          
                    <td>
                        <label for="cancel_url">Cancel URL </label>
                    </td>
                    <td>    
                        <input type="url" name="cancel_url" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="notify_url">Notify URL </label>
                    </td>
                    <td>
                        <input type="url" name="notify_url" />
                    </td>
                </tr>
                    <!-- Buyer details -->    
                <tr>        
                    <td>
                        <label for="name_first">Buyer's First Name </label>      
                    </td>
                    <td>
                        <input type="text" name="name_first" />
                    </td>
                </tr>
                <tr>                  
                    <td>
                        <label for="name_last">Buyer's Last Name </label>      
                    </td>
                    <td>
                        <input type="text" name="name_last" />
                    </td>
                </tr>
                <tr>             
                    <td>
                        <label for="email_address">Buyer's Email Address </label>      
                    </td>
                    <td>
                        <input type="email" name="email_address" />
                    </td>
                </tr>
                <tr>                  
                    <td>
                        <label for="cell_number">Buyer's Cell Number </label>      
                    </td>
                    <td>
                        <input type="tel" name="cell_number"/>
                    </td>
                </tr>
                    <!-- Transaction details -->
                <tr>                 
                    <td>
                        <label for="m_payment_id">Merchant's Payment ID </label>      
                    </td>
                    <td>
                        <input type="text" name="m_payment_id" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="amount">Item Amount </label>
                    </td>
                    <td>
                        <input type="number" name="amount" min="0.00" step="0.01"/>
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="item_name">Item Name </label>      
                    </td>
                    <td>
                        <input type="text" name="item_name" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="item_description">Item Description </label>      
                    </td>
                    <td>
                        <input type="text" name="item_description" />
                    </td>
                </tr>
                    <!-- Custom Integers -->
                <tr>                 
                    <td>
                        <label for="custom_int1">Custom Integer 1 </label>      
                    </td>
                    <td>
                        <input type="number" name="custom_int1" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_int2">Custom Integer 2 </label>      
                    </td>
                    <td>
                        <input type="number" name="custom_int2" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_int3">Custom Integer 3 </label>      
                    </td>
                    <td>
                        <input type="number" name="custom_int3" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_int4">Custom Integer 4 </label>      
                    </td>
                    <td>
                        <input type="number" name="custom_int4" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_int5">Custom Integer 5 </label>      
                    </td>
                    <td>
                        <input type="number" name="custom_int5" />
                    </td>
                </tr>

                    <!-- Custom Strings -->  
                <tr> 
                    <td>                  
                        <label for="custom_str1">Custom String 1 </label>      
                    </td>
                    <td>
                        <input type="text" name="custom_str1" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_str2">Custom String 2 </label>      
                    </td>
                    <td>
                        <input type="text" name="custom_str2" />
                    </td>
                </tr>
                <tr>                 
                    <td>            
                        <label for="custom_str3">Custom String 3 </label>      
                    </td>
                    <td>
                        <input type="text" name="custom_str3" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_str4">Custom String 4 </label>      
                    </td>
                    <td>
                        <input type="text" name="custom_str4" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="custom_str5">Custom String 5 </label>      
                    </td>
                    <td>
                        <input type="text" name="custom_str5" />
                    </td>
                </tr>
                    <!-- Email Confirmation -->   
                <tr>
                    <td>        
                        <label for="email_confirmation">Send email confirmation to Merchant of transaction </label>      
                    </td>
                    <td>
                        <input type="checkbox" class="checkbox-inline" name="email_confirmation" style="width:initial;"/> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="confirmation_address">Email address to send Merchant's confirmation email </label>
                    </td>
                    <td>
                        <input type="email" name="confirmation_address"/>
                    </td>
                </tr>
                    <!-- Set Payment Method -->            
                <tr>
                    <td>
                        <label for="payment_method">Payment Method </label>                   
                    </td>
                    <td>
                        <input type="text" name="payment_method" list="payment_methods">
                            <datalist id="payment_methods">
                                <option value="eft" >
                                <option value="cc" >
                                <option value="dc" >
                                <option value="bc" >
                                <option value="mp" >
                                <option value="mc" >                            
                            </datalist>
                    </td>                
                </tr>
                    <!-- Recurring Billing -->                
                <tr>          
                    <td>            
                        <label for="subscription_type">Subscription Type </label>                    
                    </td>
                    <td>
                        <input type="number" name="subscription_type" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="billing_date">Billing Date </label>
                    </td>
                    <td>
                        <input type="date" name="billing_date" />
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="recurring_amount">Recurring Amount (e.g. 123.45)</label>     
                    </td>
                    <td>
                        <input type="number" name="recurring_amount" min="0.00" step="0.01" />
                    </td>
                </tr>
                <tr>                
                    <td>
                        <label for="frequency">Frequency </label>
                    </td>
                    <td>
                        <input type="text" name="frequency" list="frequencies">
                            <datalist id="frequencies">
                                <option value="3" >
                                <option value="4" >
                                <option value="5" >
                                <option value="6" >
                            </datalist>
                    </td>
                </tr>
                <tr>                 
                    <td>
                        <label for="cycles">Cycles </label>      
                    </td>
                    <td>
                        <input type="number" name="cycles" />
                    </td>                
                </tr>
                    <!-- Passphrase -->
                <tr>           
                    <td>                
                        <label for="passphrase">Passphrase </label>               
                    </td>
                    <td>
                        <input type="text" name="passphrase"/> <br>
                    </td>
                </tr>

            </table>

            <aside>
                <b>Only</b> use a PassPhrase here if you have created your own sandbox account<br>
                <b>AND</b> are using those unique Merchant credentials from that account in the fields above<br>
                <b>AND</b> have a PassPhrase set on that account
            </aside>

            <p>
                <br>
                <input type='submit' class="btn" name='submit' value='Review String & Signature' />
            </p>
        </form>
    </div>

</body>

</html>