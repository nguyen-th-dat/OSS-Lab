<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, user-scalable=no,
          initial-scale=1.0, maximum-scale=1.0,
          minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Registration form</title>
</head>

<body>

<?php

if (isset($_GET['register'])) {

    $p1 = $_GET['pass'];
    $p2 = $_GET['repass'];

    $name = $_GET['name'];
    $user = $_GET['user'];
    $email = $_GET['email'];
    $sex = $_GET['sex'];

    $msg = "";

    if (!empty($p1) and !empty($p2)) {

        if ($p1 == $p2)
            $msg = "Thank $name $email $user $sex";
        else
            $msg = "Incorrect confirm password";

    } else
        $msg = "Password can not be blank!!!!";
}

?>

<form name="registration" method="get">

    <table>

        <tr>
            <td colspan="2">
                <h2>Registration Form</h2>
            </td>
        </tr>

        <tr>
            <td>Full name</td>
            <td>Username</td>
        </tr>

        <tr>
            <td>
                <input
                    type="text"
                    name="name"
                    value="<?php if(isset($_GET['name'])) echo $_GET['name']; ?>"
                    placeholder="enter fullname"
                    size="20">
            </td>

            <td>
                <input
                    type="text"
                    name="user"
                    value="<?php if(isset($_GET['user'])) echo $_GET['user']; ?>"
                    placeholder="enter username"
                    size="20">
            </td>
        </tr>

        <tr>
            <td>Email</td>
            <td>Phone Number</td>
        </tr>

        <tr>
            <td>
                <input
                    type="text"
                    name="email"
                    value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>"
                    placeholder="email address"
                    size="20">
            </td>

            <td>
                <input
                    type="number"
                    name="tel"
                    value="<?php if(isset($_GET['tel'])) echo $_GET['tel']; ?>"
                    placeholder="phone number"
                    size="20">
            </td>
        </tr>

        <tr>
            <td>Password</td>
            <td>Confirm Password</td>
        </tr>

        <tr>
            <td>
                <input
                    type="password"
                    name="pass"
                    value="<?php if(isset($_GET['pass'])) echo $_GET['pass']; ?>"
                    placeholder="password"
                    size="20">
            </td>

            <td>
                <input
                    type="password"
                    name="repass"
                    value="<?php if(isset($_GET['repass'])) echo $_GET['repass']; ?>"
                    placeholder="repass"
                    size="20">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <h3>Gender</h3>
            </td>
        </tr>

        <tr>
            <td colspan="2">

                <input
                    type="radio"
                    name="sex"
                    value="Male">
                Male

                <input
                    type="radio"
                    name="sex"
                    value="Female">
                Female

                <input
                    type="radio"
                    name="sex"
                    value="none"
                    checked>
                Prefer not to say

            </td>
        </tr>

        <tr>
            <th colspan="2"
                style="background: antiquewhite; border: none;">

                <input
                    type="submit"
                    name="register"
                    value="Register">

            </th>
        </tr>

        <tr>
            <th colspan="2"
                style="color: red">

                <?php
                if (isset($msg))
                    echo $msg;
                ?>

            </th>
        </tr>

    </table>

</form>

</body>
</html>