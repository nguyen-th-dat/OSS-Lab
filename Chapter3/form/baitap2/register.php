<?php

$fullname = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$gender = $_POST['gender'];

if ($password != $confirm_password) {
    echo "<font color='red'>Incorrect confirm password!</font>";
}
else {
    echo "<font color='red'>Thank you $fullname, please confirm registration in your email: $email";
}

?>
