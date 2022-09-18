<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
include_once 'classes/AccountClass.php';
include_once 'classes/CardClass.php';
// Start the session
session_start();

$user = new Person();
$card = new Card();
$card_data = $card->getCardDetails();

//Withdrawal amount in account
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_data = $_POST;
    $card->applyDebitCard($input_data);
    $_SESSION['success'] = "<h4>Thanks for applying our bank credit card. Your application On the way.</h4>";
}

?>
<!DOCTYPE html>
<html>
<body>
<?php
include "includes/header.php";
?>
<?php if(!$card->checkApplication('D')):?>
    <h3>Your debit card details provided below. You can use this details to make payment.</h3>
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
        </table>
        <a href="debitcard.php?make_payment=1">Make a payment</a>
        <?php
    }

    if(isset($_GET['make_payment']) && $_GET['make_payment'] == 1){
    ?>

    <h3>Make payment with debit card</h3>

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
                    <input type="text" name="name" id="name" value="">
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
    <h3>Apply for a debit card</h3>
    <h4>Your application under review. You can view your card once approved</h4>
<?php endif; ?>

</body>
</html>

