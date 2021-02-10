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

    <title>API Integration</title>
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

    table#api_tool { max-width: 800px;
                      font-size:15px;
                      font-family:'pt sans';  }
    table#api_tool label { float: left;  }
    table#api_tool input { width: 100%;}
                     
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

        <h1>API Integration</h1>
        <p>Test your access to PayFast's API</p>

    </div>

    <div class="container" >

        <p>
        Please provide the required input below, appropriate to the action you wish to use. <br>
        You will then be able to review your GET string and the signature it generates.<br>
        You will also see the response to the CURL call.
        </p>

        <form action="api_test.php" method="POST">
            <table id="api_tool" class="table table-striped table-bordered" >

                <!-- Merchant Details -->
                <tr>
                    <td>
                        <label for="merchant-id">Merchant ID </label>
                    </td>
                    <td>
                        <input type="number" name="merchant-id"  />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="amount">Item Amount (amount in cents)</label>
                    </td>
                    <td>
                        <input type="number" name="amount" min="200" step="1" />
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
                    <!-- Token -->
                <tr>
                    <td>
                        <label for="token">Token </label>
                    </td>
                    <td>
                        <input type="text" name="token" maxlength="36"/>
                    </td>
                </tr>
                    <!-- PayFast Version -->
                <tr>
                    <td>
                        <label for="version">PayFast Version </label>
                    </td>
                    <td>
                        <input type="text" name="version" />
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
                    <!-- Action -->
                <tr>
                    <td>
                        <label for="api_action">API Action </label>
                    </td>
                    <td>
                        <input type="text" name="api_action" list="actions">
                        <datalist id="actions">
                            <option value="pause" >
                            <option value="unpause" >
                            <option value="cancel" >
                            <option value="update" >
                            <option value="fetch" >
                            <option value="adhoc">
                        </datalist>
                    </td>
                </tr>
                <!-- Cycles -->
                <tr>
                    <td>
                        <label for="cycles">Cycles </label>
                    </td>
                    <td>
                        <input type="number" name="cycles" /><br>
                    </td>
                </tr>
                <!-- Frequency -->
                <tr>
                    <td>
                        <label for="frequency">Frequency </label>
                    </td>
                    <td>
                        <input type="number" name="frequency" /><br>
                    </td>
                </tr>
                <!-- Date -->
                <tr>
                    <td>
                        <label for="run_date">Date </label>
                    </td>
                    <td>
                        <input type="date" name="run_date" min="2000-01-01"/><br>
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
                <input type='submit' class="btn" name='submit' value='Submit' />
            </p>
        </form>
    </div>

</body>

</html>