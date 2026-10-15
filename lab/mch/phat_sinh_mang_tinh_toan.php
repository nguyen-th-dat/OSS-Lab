<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phát sinh mảng và tính toán</title>
</head>

<body>

    <?php
    // Tao mang ngau nhien
    function tao_mang($n)
    {
        $mang = [];

        for ($i = 0; $i < $n; $i++) {
            $mang[] = rand(0, 20);
        }

        return $mang;
    }

    // Xuat mang thanh chuoi
    function xuat_mang($mang)
    {
        return implode(" ", $mang);
    }

    // Tinh tong mang
    function tinh_tong($mang)
    {
        $tong = 0;

        foreach ($mang as $value) {
            $tong += $value;
        }

        return $tong;
    }

    // Tim gia tri lon nhat
    function tim_max($mang)
    {
        return max($mang);
    }

    // Tim gia tri nho nhat
    function tim_min($mang)
    {
        return min($mang);
    }

    if (isset($_POST['tinh'])) {
        $n = (int) $_POST['n'];

        if ($n >= 1 && $n <= 1000) {
            $mang = tao_mang($n);
            $mang_kq = xuat_mang($mang);
            $tong = tinh_tong($mang);
            $max = tim_max($mang);
            $min = tim_min($mang);
        }
    }
    ?>

    <form method="post">
        <table border="1" cellpadding="5" cellspacing="0"
            width="650" align="center">
            <tr bgcolor="#a00078">
                <th colspan="2">
                    <font color="white" size="5">
                        PHÁT SINH MẢNG VÀ TÍNH TOÁN
                    </font>
                </th>
            </tr>

            <tr bgcolor="#f8d9f0">
                <td>Nhập số phần tử:</td>
                <td>
                    <input type="texts" name="n"
                        min="1" max="1000"
                        value="<?php if (isset($n)) echo $n; ?>" required>
                </td>
            </tr>

            <tr bgcolor="#f8d9f0">
                <td></td>
                <td>
                    <input type="submit" name="tinh"
                        value="Phát sinh và tính toán">
                </td>
            </tr>

            <tr>
                <td>Mảng:</td>
                <td>
                    <input type="text" size="45"
                        value="<?php if (isset($mang_kq)) echo $mang_kq; ?>"
                        readonly>
                </td>
            </tr>

            <tr>
                <td>GTLN (MAX) trong mảng:</td>
                <td>
                    <input type="text" size="15"
                        value="<?php if (isset($max)) echo $max; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td>TTNN (MIN) trong mảng:</td>
                <td>
                    <input type="text" size="15"
                        value="<?php if (isset($min)) echo $min; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td>Tổng mảng:</td>
                <td>
                    <input type="text" size="15"
                        value="<?php if (isset($tong)) echo $tong; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <b>Ghi chú:</b>
                    Các phần tử trong mảng có giá trị từ 0 đến 20.
                </td>
            </tr>
        </table>
    </form>

</body>

</html>
