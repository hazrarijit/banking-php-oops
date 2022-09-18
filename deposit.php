<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
include_once 'classes/AccountClass.php';
// Start the session
session_start();

$user = new Person();
$account_data = $user->getAccountNo();


//Deposit amount in account
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_data = $_POST;
    $account = new Account();
    $return_data = $account->updateBalance($input_data, "D");
    if($return_data){
        $current_balance = $account->getBalance($input_data);
        $_SESSION['success'] = "<h4>Deposit Successfully. Your current account balance is Rs ".number_format($current_balance,2)." </h4>";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
<?php
include "includes/header.php";
?>

<h3>You can deposit your fund</h3>

<?php
if(isset($_SESSION['success'])){
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
?>


<form action="" method="post">
    <table>
        <tr>
            <td>
                <label for="pan">Account No*:</label><br>
                <select name="account_no" id="">
                    <option value="">-Select Account-</option>
                <?php
                if(!empty($account_data)){
                    $i = 0;
                    foreach ($account_data as $account){
                        ?>
                        <option value="<?= $account->id?>" <?= $i == 0 ? 'selected' : ''?>><?= $account->account_no?></option>
                        <?php
                        $i++;
                    }
                }
                ?>
                </select>
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <label for="password">Account type*:</label><br>
                <label><input type="radio" id="html" name="account_type" value="1" checked> Saving</label>
                <label><input type="radio" id="html" name="account_type" value="2"> Current</label>
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <label for="pan">Amount*:</label><br>
                <input type="text" id="amount" name="amount">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <center>
                    <input type="submit" value="Deposit">
                </center>
            </td>
        </tr>


    </table>
</form>


</body>
</html>

