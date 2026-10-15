<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bt2</title>
</head>

<body>
    <?php
    

    if (isset($_POST['tinh'])) {
        $daySo = $_POST['daySo'];

        $arr = explode(",", $daySo);
        $tong = 0;

        foreach ($arr as $value) {
            $tong += (float) trim($value);
        }
    }
    ?>

    <form method="post" action="baitap2.php">
        <table>
            <tr>
                <th colspan="2">NHẬP VÀ TÍNH TRÊN DÃY SỐ</th>
            </tr>

            <tr>
                <td>Nhập dãy số:</td>
                <td>
                    <input type="text" name="daySo"
                        value="<?php if (isset($daySo)) echo "$daySo"; ?>">
                    <span class="note">(*)</span>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" name="tinh" value="Tổng dãy số">
                </td>
            </tr>

            <tr>
                <td>Tổng dãy số:</td>
                <td>
                    <input type="text" class="result"
                        value="<?php if (isset($tong)) echo "$tong"; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <span class="note">(*)</span>
                    Các số được nhập cách nhau bằng dấu ","
                </td>
            </tr>
        </table>
    </form>
</body>

</html>