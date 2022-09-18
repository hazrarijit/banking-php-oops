<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
include_once 'classes/CardClass.php';
// Start the session
session_start();
$user = new Person();
$card = new Card();
?>
<!DOCTYPE html>
<html>
<body>
<?php
include "includes/header.php";
?>

<h3>Please select your banking option</h3>
<table>
    <tr>
        <td>
            <a href="deposit.php"><b>Deposit</b></a>
        </td>
    </tr>
    <tr>
        <td>
            <a href="withdraw.php"><b>Withdraw</b></a>
        </td>
    </tr>

    <tr>
        <td>
            <a href="passbook.php"><b>Print Passbook</b></a>
        </td>
    </tr>
    <?php if($card->checkApplication('D')){ ?>
    <tr>
        <td>
            <a href="debitcard_form.php"><b>Apply for Debit Card</b></a>
        </td>
    </tr>
    <?php } else {
        ?>
        <tr>
            <td>
                <a href="debitcard.php"><b>View Debit Card</b></a>
            </td>
        </tr>
        <?php
    } ?>
    <?php if($card->checkApplication('D')){ ?>
    <tr>
        <td>
            <a href="creditcard_form.php"><b>Apply for Credit Card</b></a>
        </td>
    </tr>
    <?php } else { ?>
        <tr>
            <td>
                <a href="creditcard.php"><b>View Credit Card</b></a>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>

