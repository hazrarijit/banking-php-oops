<?php
include 'includes/Database.php';
include_once 'classes/PersonClass.php';
// Start the session
session_start();
$user = new Person();

//Create Account using Post method
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_data = $_POST;
    $login = $user->login($input_data);
    if(!$login){
        $_SESSION['error'] = "<h4>Error! Invalid credentials. Please recheck and try again.</h4>";
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
if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
?>


<form action="" method="post">
    <table>
        <tr>
            <td>
                <label for="pan">Username*:</label><br>
                <input type="text" id="username" name="username">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <label for="password">Password*:</label><br>
                <input type="password" id="password" name="password">
            </td>
        </tr>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr>
            <td>
                <center>
                    <input type="submit" value="Login">
                </center>
            </td>
        </tr>


    </table>
</form>

<p>You can create your free account by <a href="index.php">clicking here</a>.</p>

</body>
</html>

