<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
include_once 'classes/AccountClass.php';
include_once 'classes/CardClass.php';
// Start the session
session_start();

$user = new Person();
$card = new Card();
$account_data = $user->getAccountNo();
$person_data = $user->getPerson();

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
<?php if($card->checkApplication('D')):?>
    <h3>Apply for a debit card</h3>

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
                    <label for="password">Name*:</label><br>
                    <input type="text" name="name" id="name" value="<?= $person_data->firstname.' '.$person_data->lastname?>">
                </td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <tr>
                <td>
                    <label for="password">Phone*:</label><br>
                    <input type="text" name="phone" id="phone" value="<?= $person_data->phone?>">
                </td>

                <td>
                    <label for="password">Email*:</label><br>
                    <input type="text" name="email" id="email" value="<?= $person_data->email?>">
                </td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <tr>
                <td>
                    <label for="password">Aadhar no.*:</label><br>
                    <input type="text" name="aadhar" id="aadhar" value="<?= $person_data->aadhar?>">
                </td>

                <td>
                    <label for="password">Pan*:</label><br>
                    <input type="text" name="pan" id="pan" value="<?= $person_data->pan?>">
                </td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <tr>
                <td colspan="2">
                    <label for="pan">Account No*:</label><br>
                    <select name="account_no" id="account_no">
                        <option value="">-Select Account-</option>
                        <?php
                        if(!empty($account_data)){
                            foreach ($account_data as $account){
                                ?>
                                <option value="<?= $account->id?>"><?= $account->account_no?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <tr>
                <td colspan="2">
                    <label for="password">Account type*:</label><br>
                    <label><input type="radio" id="html" name="account_type" value="1"> Saving</label>
                    <label><input type="radio" id="html" name="account_type" value="2"> Current</label>
                </td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <tr>
                <td colspan="2">
                    <center>
                        <input type="submit" value="Apply">
                    </center>
                </td>
            </tr>


        </table>
    </form>
<?php else :?>
    <h3>Apply for a debit card</h3>
    <h4>Your application under review. You can view your card once approved</h4>
<?php endif; ?>

</body>
</html>

