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

    <title>HCN</title>
</head>

<body>

<?php

if (isset($_POST['submit'])) {

    $cd = $_POST['dai'];
    $cr = $_POST['rong'];

    if (is_numeric($cd) and is_numeric($cr))

        if ($cd > 0 and $cr > 0)

            if ($cd >= $cr)
                $dt = $cd * $cr;

            else
                $msg = "Chieu dai khong duoc be hon chieu rong";

        else
            $msg = "Chieu dai va chieu rong khong duoc <=0";

    else
        $msg = "Chieu dai hoac chieu rong khong phai la so";
}

?>

<form method="post" name="HCN">

    <table style="background: beige">

        <tr style="background: lightpink">
            <th colspan="2">
                DIEN TICH HINH CHU NHAT
            </th>
        </tr>

        <tr>
            <td>Chieu dai:</td>
            <td>
                <input type="number"
                       step="any"
                       name="dai"
                       size="20"
                       value="<?php if (isset($cd)) echo "$cd"; ?>">
            </td>
        </tr>

        <tr>
            <td>Chieu rong:</td>
            <td>
                <input type="number"
                       step="any"
                       name="rong"
                       size="20"
                       value="<?php if (isset($cr)) echo "$cr"; ?>">
            </td>
        </tr>

        <tr>
            <td>Dien tich:</td>
            <td>
                <input type="text"
                       name="dt"
                       size="20"
                       readonly
                       style="background: lightpink"
                       value="<?php if (isset($dt)) echo "$dt"; ?>">
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit"
                       value="Tinh"
                       name="submit">
            </td>
        </tr>

        <tr>
            <td colspan="2" style="color: red">
                <?php
                if (isset($msg))
                    echo $msg;
                ?>
            </td>
        </tr>

    </table>

</form>

</body>
</html>