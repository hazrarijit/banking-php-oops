<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
include_once 'classes/AccountClass.php';
// Start the session
session_start();


$user = new Person();
$account = new Account();
$user_data = $user->getPerson();
$transactions = $account->getTransaction();


?>
<!DOCTYPE html>
<html>
<body>
<?php
include "includes/header.php";
?>

<h3>Your passbook</h3>
<table border="1" width="100%">
    <tr>
        <th>Name</th>
        <td><?=$user_data->firstname.' '.$user_data->lastname?></td>
    </tr>
    <tr>
        <th>Account no.</th>
        <td><?=$user_data->account_no?></td>
    </tr>
    <tr>
        <th>Account type</th>
        <td><?=$user_data->account_type == '1' ? 'Saving' : 'Current' ?></td>
    </tr>
</table>
<br>
<br>
<table border="1" width="100%">
    <tr>
        <th>Date</th>
        <th>Ref No</th>
        <th>Amount</th>
        <th>Type</th>
    </tr>
    <?php
    foreach($transactions as $transaction){
        ?>
        <tr>
            <td><?= $transaction->created_at ?></td>
            <td><?= $transaction->ref_no ?></td>
            <td><b><?= $transaction->amount ?></b></td>
            <td><b><?= $transaction->transaction_type == 1 ? "Debited" : "Credited" ?></b></td>
        </tr>
        <?php
    }
    ?>
</table>

<center>
    <br><br>
    <button onclick="window.print()">Print</button>
</center>

</body>
</html>

