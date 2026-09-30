<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Kết quả phép tính</title>

    <style>
        body {
            font-family: Arial;
        }

        table {
            margin: 50px auto;
        }

        .title {
            color: #4682B4;
            text-align: center;
            font-weight: bold;
        }

        .label {
            color: #4169E1;
            font-weight: bold;
        }

        .result {
            color: #4169E1;
            font-weight: bold;
        }

        .back {
            text-align: center;
        }

        .back a {
            color: #9932CC;
            font-style: italic;
        }
    </style>
</head>

<body>

<?php

function cong($a, $b)
{
    return $a + $b;
}

function tru($a, $b)
{
    return $a - $b;
}

function nhan($a, $b)
{
    return $a * $b;
}

function chia($a, $b)
{
    return $a / $b;
}

$so1 = $_POST['so1'];
$so2 = $_POST['so2'];
$pheptinh = $_POST['pheptinh'];

    if (is_numeric($so1) && is_numeric($so2)) {
        switch ($pheptinh) {

            case "cong":
                $tenPhepTinh = "Cộng";
                $ketqua = cong($so1, $so2);
                break;

            case "tru":
                $tenPhepTinh = "Trừ";
                $ketqua = tru($so1, $so2);
                break;

            case "nhan":
                $tenPhepTinh = "Nhân";
                $ketqua = nhan($so1, $so2);
                break;

            case "chia":
                $tenPhepTinh = "Chia";

                if ($so2 == 0) {
                    $ketqua = "Không thể chia cho 0";
                    // echo "<script>alert('Du lieu khong hop le!');</script>";
                    echo "<script>window.history.back(-1);</script>";
                    exit;
                } else {
                    $ketqua = chia($so1, $so2);
                }

                break;
        }
    } else {
        echo "<script>window.history.back(-1);</script>";
        exit;
    }

?>

<table>

    <tr>
        <td colspan="2" class="title">
            PHÉP TÍNH TRÊN HAI SỐ
        </td>
    </tr>

    <tr>
        <td class="label">
            Chọn phép tính:
        </td>

        <td>
            <b><?php echo $tenPhepTinh; ?></b>
        </td>
    </tr>

    <tr>
        <td class="label">
            Số 1:
        </td>

        <td>
            <input type="text"
                   value="<?php echo $so1; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td class="label">
            Số 2:
        </td>

        <td>
            <input type="text"
                   value="<?php echo $so2; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td class="result">
            Kết quả:
        </td>

        <td>
            <input type="text"
                   value="<?php echo $ketqua; ?>"
                   readonly>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="back">
            <a href="javascript:window.history.back(-1);">
                Quay lại trang trước
            </a>
        </td>
    </tr>

</table>

</body>
</html>