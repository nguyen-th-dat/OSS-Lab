<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no,
          initial-scale=1.0, maximum-scale=1.0,
          minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">

    <title>Reset Btn</title>
</head>

<body>

<form method="get">

    <input type="text" name="input"
           value="<?php
           if(isset($_GET['submit']))
               if(!empty($_GET['input']))
                   echo $_GET['input'];

           if(isset($_GET['reset']))
               echo "";
           ?>"
           
           placeholder="<?php
           if(isset($_GET['submit']) and empty($_GET['input']))
               echo " yeu cau khong duoc de trong";
           ?>"
           
           size="30">

    <input type="submit" name="submit">

    <input type="submit" name="reset" value="reset">

</form>

</body>
</html>