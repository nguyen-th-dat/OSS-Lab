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

    <title>Kết quả thi Đại học</title>
</head>

<body>

    <?php

    if (isset($_POST['submit'])) {


        $t = $_POST['toan'];
        $l = $_POST['li'];
        $h = $_POST['hoa'];
        $dc = $_POST['DiemChuan'];

        if (is_numeric($t) and is_numeric($l) and is_numeric($h) and is_numeric($dc) and is_numeric($dc)) {

            if ($dc >= 0) {
                if ($t <= 10 and $h <= 10 and $l <= 10) {
                    if ($t > 0 and $l > 0 and $h > 0) {
                        $td = $t + $l + $h;
                        if ($td >= $dc) {
                            $kq = "Đậu";
                            // $msg = "Đậu";
                        }
                    } else {
                        $kq = "Rớt";
                        $msg = "Rớt. Diem mon hoc = 0";
                    }
                } else {
                    $msg = "diem mon hoc phai <=10";
                }
            } else {
                $msg = "Diem chuan phai >= 0";
            }
        } else
            $msg = "diem phai la so";
    }

    ?>

    <form method="post" name="TTTD">

        <table style="background: beige">

            <tr style="background: lightpink">
                <th colspan="2">
                    Kết quả thi Đại học
                </th>
            </tr>

            <tr>
                <td>Toán</td>
                <td>
                    <input type="number"
                        step="any"
                        name="toan"
                        size="20"
                        value="<?php if (isset($t)) echo "$t"; ?>">
                </td>
            </tr>

            <tr>
                <td>Lí</td>
                <td>
                    <input type="number"
                        step="any"
                        name="li"
                        size="20"
                        value="<?php if (isset($l)) echo "$l"; ?>">
                </td>
            </tr>

            <tr>
                <td>Hóa</td>
                <td>
                    <input type="number"
                        step="any"
                        name="hoa"
                        size="20"
                        value="<?php if (isset($h)) echo "$h"; ?>">
                </td>
            </tr>



            <tr>
                <td>Điểm chuẩn</td>
                <td>
                    <input type="number"
                        step="any"
                        name="DiemChuan"
                        size="20"
                        value="<?php if (isset($dc)) echo "$dc"; ?>">
                </td>
            </tr>


            <tr>
                <td>Tổng điểm</td>
                <td>
                    <input type="text"
                        name="TongDiem"
                        size="20"
                        readonly
                        style="background: lightpink"
                        value="<?php if (isset($td)) echo "$td"; ?>">
                </td>
            </tr>

            <tr>
                <td>Kết quả</td>
                <td>
                    <input type="text"
                        name="KetQua"
                        size="20"
                        readonly
                        style="background: lightpink"
                        value="<?php if (isset($kq)) echo "$kq"; ?>">
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center">
                    <input type="submit"
                        value="Xem kết quả"
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