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

    <title>Tinh Tien Karaoke</title>
</head>

<body>

    <?php

    if (isset($_POST['submit'])) {


        $gbd = $_POST['giobatdau'];
        $gkt = $_POST['gioketthuc'];
        if (
            is_numeric($gbd) &&
            is_numeric($gkt) &&
            $gbd >= 10 && $gbd <= 24 &&
            $gkt >= 10 && $gkt <= 24
        ) {

            if ($gkt >= $gbd) {

                if ($gbd <= 17 && $gkt <= 17) {

                    // Cả hai đều trong khoảng 10h - 17h
                    $tt = ($gkt - $gbd) * 20000;
                } elseif ($gbd >= 17 && $gkt >= 17) {

                    // Cả hai đều trong khoảng 17h - 24h
                    $tt = ($gkt - $gbd) * 45000;
                } elseif ($gbd < 17 && $gkt > 17) {

                    // Bắt đầu trước 17h, kết thúc sau 17h
                    $tt = (17 - $gbd) * 20000
                        + ($gkt - 17) * 45000;
                } else {
                    $msg = "Nhap khong hop le!";
                }
            } else {
                $msg = "Gio ket thuc phai lon hon hoac bang gio bat dau";
            }
        } else {
            $msg = "Gio phai la so >= 10 va <= 24";
        }
    }

    ?>

    <form method="post" name="TTTD">

        <table style="background: beige">

            <tr style="background: lightpink">
                <th colspan="2">
                    Tinh Tien Karaoke
                </th>
            </tr>

            <tr>
                <td>Giờ bắt đầu</td>
                <td>
                    <input type="number"
                        step="any"
                        name="giobatdau"
                        size="20"
                        value="<?php if (isset($gbd)) echo "$gbd"; ?>">
                    (h)
                </td>
            </tr>

            <tr>
                <td>Giờ kết thúc</td>
                <td>
                    <input type="number"
                        step="any"
                        name="gioketthuc"
                        size="20"
                        value="<?php if (isset($gkt)) echo "$gkt"; ?>">
                    (h)
                </td>
            </tr>



            <tr>
                <td>Tiền thanh toán</td>
                <td>
                    <input type="text"
                        name="TongTien"
                        size="20"
                        readonly
                        style="background: lightpink"
                        value="<?php if (isset($tt)) echo "$tt"; ?>">
                    (VND)
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center">
                    <input type="submit"
                        value="Tính Tiền"
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