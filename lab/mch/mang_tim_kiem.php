<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm</title>
    <style>
        table {
            width: 700px;
            margin: auto;
            background-color: #d0ded5;
            font-family: Arial, sans-serif;
        }

        th {
            background-color: #309e99;
            color: white;
            font-size: 24px;
            font-style: italic;
            padding: 10px;
        }

        td {
            padding: 6px;
        }

        input[type="text"] {
            width: 400px;
        }

        .small {
            width: 110px !important;
        }

        input[type="submit"] {
            padding: 6px 20px;
            background-color: #9bc9f5;
        }

        .result {
            background-color: #bdf5f5;
            color: #c03952;
        }
    </style>
</head>
<body>

<?php
// Tim kiem gia tri trong mang
function tim_kiem($mang, $gia_tri) {
    for ($i = 0; $i < count($mang); $i++) {
        if (trim($mang[$i]) == $gia_tri) {
            return $i;
        }
    }

    return -1;
}


if (isset($_POST['tim'])) {
    $day_so = $_POST['day_so'];
    $gia_tri = $_POST['gia_tri'];

    // Tach chuoi thanh mang
    $mang = explode(",", $day_so);

    foreach ($mang as $value) {
    $value = trim($value);

    if ($value === "" || !is_numeric($value)) {
        $msg = "Cac phan tu phai la so va cach nhau bang dau phay (,).";
        break;
    }
    }

    // Chuyen mang thanh chuoi de hien thi
    $mang_kq = implode(", ", $mang);

    // Goi ham tim kiem
    $vi_tri = tim_kiem($mang, $gia_tri);

    if ($vi_tri != -1) {
        $ket_qua = "Tìm thấy $gia_tri tại vị trí thứ "
                 . ($vi_tri + 1) . " của mảng";
    } else {
        $ket_qua = "Không tìm thấy $gia_tri trong mảng";
    }
}
?>

<form method="post" action="">
    <table cellpadding="5" cellspacing="0">
        <tr>
            <th colspan="2">TÌM KIẾM</th>
        </tr>

        <tr>
            <td>Nhập mảng:</td>
            <td>
                <input type="text" name="day_so"
                    value="<?php if (isset($day_so)) { echo"$day_so"; } ?>"
                    required>
            </td>
        </tr>

        <tr>
            <td>Nhập số cần tìm:</td>
            <td>
                <input type="number" name="gia_tri"
                    class="small"
                    value="<?php if (isset($gia_tri)) { echo"$gia_tri"; } ?>"
                    required>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type="submit" name="tim" value="Tìm kiếm">
            </td>
        </tr>

        <tr>
            <td>Mảng:</td>
            <td>
                <input type="text"
                    value="<?php if (isset($mang_kq)) { echo "$mang_kq"; } ?>"
                    readonly>
            </td>
        </tr>

        <tr>
            <td>Kết quả tìm kiếm:</td>
            <td>
                <input type="text" class="result"
                    value="<?php if (isset($ket_qua)) { echo "$ket_qua"; } ?>"
                    readonly>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                Các phần tử trong mảng cách nhau bằng dấu phẩy (,).
            </td>
        </tr>
        <tr></tr>
            <td colspan="2" align="center">
                <?php
                if (isset($msg)) {
                    echo "<p style='color: red;'>" . $msg . "</p>";
                }
                ?>
            </td>
    </table>
</form>

</body>
</html>