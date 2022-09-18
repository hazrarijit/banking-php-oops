<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';

// Start the session
session_start();

$user = new Person();
//Create Account using Post method
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_data = $_POST;
    $register = $user->register($input_data);
    if($register){
        $_SESSION['success'] = "<h4>Congratulations! We have received your details. Will be verified and back to you shortly.</h4>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Banking System</title>
</head>
<body>

<h2>Open your account now</h2>

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
                <label for="fname">First name*:</label><br>
                <input type="text" id="fname" name="fname">
            </td>
            <td>
                <label for="lname">Last name*:</label><br>
                <input type="text" id="lname" name="lname">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <label for="phone">Contact No*:</label><br>
                <input type="text" id="phone" name="phone">
            </td>
            <td>
                <label for="alt_phone">Alternative Contact No (Optional):</label><br>
                <input type="text" id="alt_phone" name="alt_phone">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td colspan="2">
                <label for="email">Email*:</label><br>
                <input type="text" id="email" name="email">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <label for="aadhar">Aadhar No*:</label><br>
                <input type="text" id="aadhar" name="aadhar">
            </td>
            <td>
                <label for="pan">PAN no.*:</label><br>
                <input type="text" id="pan" name="pan">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td colspan="2">
                <label for="pan">Username*: (use for internet banking login)</label><br>
                <input type="text" id="username" name="username">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <label for="password">Password*:</label><br>
                <input type="password" id="password" name="password">
            </td>
            <td>
                <label for="con_password">Conform Password*:</label><br>
                <input type="password" id="con_password" name="con_password">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td colspan="2">
                <center>
                    <input type="submit" value="Submit">
                </center>
            </td>
        </tr>


    </table>
</form>

<p>If you already have a account <a href="login.php">click here to login</a></p>

</body>
</html>

