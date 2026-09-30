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

    <title>Thanh Toán Tiền Điện</title>
</head>

<body>

    <?php

    if (isset($_POST['submit'])) {


        $tench = $_POST['TenChuHo'];
        $csc = $_POST['ChiSoCu'];
        $csm = $_POST['ChiSoMoi'];
        $dg = $_POST['DonGia'];

        if (is_numeric($csc) and is_numeric($csm) and is_numeric($dg))

            if ($csc > 0 and $csm > 0)

                if ($csm >= $csc)
                    $tttt = ($csm - $csc) * $dg;

                else
                    $msg = "Chi so moi phai lon hon chi so cu";

            else {
                $msg = "Chi so moi va chi so cu phai >= 0";
            }
        else
            $msg = "Chi so moi va chi so cu phai la so";
    }
    ?>

    <form method="post" name="TTTD">

        <table style="background: beige">

            <tr style="background: lightpink">
                <th colspan="2">
                    Thanh Toán Tiền Điện
                </th>
            </tr>

            <tr>
                <td>Tên chủ hộ</td>
                <td>
                    <input type="text"
                        step="any"
                        name="TenChuHo"
                        size="20"
                        value="<?php if (isset($tench)) echo "$tench"; ?>">
                </td>
            </tr>

            <tr>
                <td>Chỉ số cũ:</td>
                <td>
                    <input type="number"
                        step="any"
                        name="ChiSoCu"
                        size="20"
                        value="<?php if (isset($csc)) echo "$csc"; ?>">
                    (Kw)
                </td>
            </tr>

            <tr>
                <td>Chỉ số mới</td>
                <td>
                    <input type="number"
                        step="any"
                        name="ChiSoMoi"
                        size="20"
                        value="<?php if (isset($csm)) echo "$csm"; ?>">
                    (Kw)
                </td>
            </tr>



            <tr>
                <td>Đơn giá</td>
                <td>
                    <input type="number"
                        step="any"
                        name="DonGia"
                        size="20"
                        value="20000">
                    <!-- value="<?php if (isset($dg)) echo "$dg"; ?>"> -->
                    (VND)
                </td>
            </tr>


            <tr>
                <td>Sổ tiền cần thanh toán</td>
                <td>
                    <input type="text"
                        name="dt"
                        size="20"
                        readonly
                        style="background: lightpink"
                        value="<?php if (isset($tttt)) echo "$tttt"; ?>">
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