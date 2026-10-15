<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thay thế</title>
</head>
<body>

<?php
// Thay the gia tri trong mang
function thay_the($mang, $cu, $moi) {
    for ($i = 0; $i < count($mang); $i++) {
        if (trim($mang[$i]) == $cu) {
            $mang[$i] = $moi;
        }
    }

    return $mang;
}

if (isset($_POST['thay'])) {
    $day_so = trim($_POST['day_so']);
    $cu = trim($_POST['cu']);
    $moi = trim($_POST['moi']);

    // Tach chuoi thanh mang
    $mang = explode(",", $day_so);

    // Kiem tra du lieu
    $hop_le = ($day_so !== "" && $cu !== "" && $moi !== "");

    foreach ($mang as $value) {
        if (trim($value) === "" || !is_numeric(trim($value))) {
            $hop_le = false;
            break;
        }
    }

    if (!is_numeric($cu) || !is_numeric($moi)) {
        $hop_le = false;
    }

    if ($hop_le) {
        // Xuat mang cu
        $mang_cu = implode(", ", array_map("trim", $mang));

        // Thay the va xuat mang moi
        $mang_sau = thay_the($mang, $cu, $moi);
        $mang_moi = implode(", ", $mang_sau);
    } else {
        $mang_cu = "";
        $mang_moi = "";
    }
}
?>

<form method="post" action="">
    <table border="1" cellpadding="5" cellspacing="0"
           width="600" align="center">
        <tr bgcolor="#a00078">
            <th colspan="2">
                <font color="white" size="5">
                    THAY THẾ
                </font>
            </th>
        </tr>

        <tr bgcolor="#f8d9f0">
            <td>Nhập các phần tử:</td>
            <td>
                <input type="text" name="day_so" size="35"
                    value="<?php  if (isset($day_so)) echo $day_so; ?>"
                    required>
            </td>
        </tr>

        <tr bgcolor="#f8d9f0">
            <td>Giá trị cần thay thế:</td>
            <td>
                <input type="number" name="cu"
                    value="<?php  if (isset($cu)) echo $cu; ?>"
                    required>
            </td>
        </tr>

        <tr bgcolor="#f8d9f0">
            <td>Giá trị thay thế:</td>
            <td>
                <input type="number" name="moi"
                    value="<?php  if (isset($moi)) echo $moi; ?>"
                    required>
            </td>
        </tr>

        <tr bgcolor="#f8d9f0">
            <td></td>
            <td>
                <input type="submit" name="thay" value="Thay thế">
            </td>
        </tr>

        <tr>
            <td>Mảng cũ:</td>
            <td>
                <input type="text" size="35"
                    value="<?php  if (isset($mang_cu)) echo $mang_cu; ?>"
                    readonly>
            </td>
        </tr>

        <tr>
            <td>Mảng sau khi thay thế:</td>
            <td>
                <input type="text" size="35"
                    value="<?php  if (isset($mang_moi)) echo $mang_moi; ?>"
                    readonly>
            </td>
        </tr>

        <tr bgcolor="#f8d9f0">
            <td colspan="2" align="center">
                <b style="color: red;">Ghi chú:</b>
                Các phần tử trong mảng cách nhau bằng dấu phẩy (,).
            </td>
        </tr>
    </table>
</form>

</body>
</html>