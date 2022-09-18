<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
include_once 'classes/AccountClass.php';
include_once 'classes/CardClass.php';
// Start the session
session_start();

$user = new Person();
$card = new Card();

//Withdrawal amount in account
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_GET['make_payment'] == 1){
        $input_data = $_POST;
        $card->makeCreditCardPayment($input_data);
        $_SESSION['success'] = "<h4>Transaction successful</h4>";
    }
    if($_GET['make_payment'] == 2){
        $input_data = $_POST;
        $card->makeCreditCardRePayment($input_data);
        $_SESSION['success'] = "<h4>Repayment successful. Credited to your card.</h4>";
    }
}

$card_data = $card->getCardDetails(2);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Credit card payment</title>
</head>
<body>
<?php
include "includes/header.php";
?>
<?php if(!$card->checkApplication('D')):?>
    <h3>Your credit card details provided below. You can use this details to make payment.</h3>
    <?php
    foreach ($card_data as $card){
        ?>
        <table border="1" width="100%">
            <tr>
                <th>Card No</th>
                <td><?=$card->card_no?></td>
            </tr>
            <tr>
                <th>Card expiry date</th>
                <td><?=$card->exp_month.'/'.$card->exp_year?></td>
            </tr>
            <tr>
                <th>CVV</th>
                <td><?=$card->cvv?></td>
            </tr>

            <tr>
                <th>Credit Limit</th>
                <td><?=number_format($card->credit_limit, 2)?></td>
            </tr>

            <tr>
                <th>Available limit</th>
                <td><?=number_format($card->credit_limit-$card->used_limit, 2)?></td>
            </tr>
        </table>
        <a href="creditcard.php?make_payment=1">Make a payment</a>
        <a href="creditcard.php?make_payment=2">Make a repayment</a>
        <?php
    }
    if(isset($_GET['make_payment']) && $_GET['make_payment'] == 2){
        ?>
        <form action="" method="post">
            <table>
                <tr>
                    <td colspan="2">
                        <label for="password">Amount*:</label><br>
                        <input type="text" name="amount" id="amount" value="">
                    </td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>

                <tr>
                    <td colspan="2">
                        <center>
                            <input type="submit" value="Repay">
                        </center>
                    </td>
                </tr>


            </table>
        </form>
        <?php
    }

    if(isset($_GET['make_payment']) && $_GET['make_payment'] == 1){
        ?>
        <h3>Make payment with credit card</h3>
        <?php
        if(isset($_SESSION['success'])){
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
        ?>


        <form action="" method="post">
            <table>
                <tr>
                    <td colspan="2">
                        <label for="password">Name on card*:</label><br>
                        <input type="text" name="name" id="name" value="">
                    </td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>

                <tr>
                    <td colspan="2">
                        <label for="password">Card no*:</label><br>
                        <input type="text" name="card_no" id="card_no" value="">
                    </td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>

                <tr>
                    <td>
                        <label for="password">Month*:</label><br>
                        <select name="card_month" id="card_month">
                            <option value=''>--Select Month--</option>
                            <option selected value='1'>January </option>
                            <option value='2'>February</option>
                            <option value='3'>March</option>
                            <option value='4'>April</option>
                            <option value='5'>May</option>
                            <option value='6'>June</option>
                            <option value='7'>July</option>
                            <option value='8'>August</option>
                            <option value='9'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
                        </select>
                    </td>

                    <td>
                        <label for="password">Year*:</label><br>
                        <select name="card_year" id="card_year">
                            <?php
                            for ($i = 0; $i < 25; $i++){
                                ?>
                                <option value="<?=date('Y') + $i?>"><?=date('Y') + $i?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>

                <tr>
                    <td colspan="2">
                        <label for="password">CVV*:</label><br>
                        <input type="text" name="cvv" id="cvv" value="">
                    </td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>

                <tr>
                    <td colspan="2">
                        <label for="password">Amount*:</label><br>
                        <input type="text" name="amount" id="amount" value="">
                    </td>
                </tr>

                <tr><td colspan="2">&nbsp;</td></tr>

                <tr>
                    <td colspan="2">
                        <center>
                            <input type="submit" value="Pay">
                        </center>
                    </td>
                </tr>


            </table>
        </form>
    <?php } ?>
<?php else:?>
    <h3>Apply for a credit card</h3>
    <h4>Your application under review. You can view your card once approved</h4>
<?php endif; ?>

</body>
</html>

