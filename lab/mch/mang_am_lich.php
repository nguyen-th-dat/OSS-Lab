<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tính năm âm lịch</title>

    <style>
        table {
            width: 600px;
            margin: auto;
            background-color: #b9edfa;
        }

        th {
            background-color: #0879c9;
            color: white;
            font-size: 24px;
            font-style: italic;
            padding: 8px;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        input[type="text"] {
            width: 150px;
        }

        img {
            width: 150px;
            height: 100px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<?php
$mang_can = array(
    "Quy", "Giap", "At", "Binh", "Dinh",
    "Mau", "Ky", "Canh", "Tan", "Nham"
);

$mang_chi = array(
    "Hoi", "Ty", "Suu", "Dan", "Mao", "Thin",
    "Ti", "Ngo", "Mui", "Than", "Dau", "Tuat"
);

$mang_hinh = array(
    "hoi.jpg", "ty.jpg", "suu.jpg", "dan.jpg",
    "mao.jpg", "thin.jpg", "ti.jpg", "ngo.jpg",
    "mui.jpg", "than.jpg", "dau.jpg", "tuat.jpg"
);

$nam = "";
$nam_am_lich = "";
$hinh_anh = "";
$loi = "";

if (isset($_POST['tinh'])) {
    $nam = trim($_POST['nam'] ?? "");

    if ($nam === "" || !ctype_digit($nam) || (int)$nam < 1) {
        $loi = "Vui long nhap nam duong lich hop le!";
    } else {
        $nam = (int)$nam;
        $nam_tinh = $nam - 3;

        $can = $nam_tinh % 10;
        $chi = $nam_tinh % 12;

        $nam_am_lich = $mang_can[$can] . " " . $mang_chi[$chi];
        $hinh_anh = $mang_hinh[$chi];
    }
}
?>

<form method="post" action="">
    <table cellpadding="5" cellspacing="0">
        <tr>
            <th colspan="3">TÍNH NĂM ÂM LỊCH</th>
        </tr>

        <tr>
            <td>Năm dương lịch</td>
            <td>Năm âm lịch</td>
        </tr>

        <tr>
            <td>
                <input type="text" name="nam"
                    value="<?php if (isset($nam)) echo $nam; ?>"
                    required>
            </td>

            <td>
                <input type="submit" name="tinh" value="=>">
            </td>

            <td>
                <input type="text"
                    value="<?php if (isset($nam_am_lich)) echo $nam_am_lich; ?>"
                    readonly>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                <?php
                if (isset($hinh_anh)) {
                    // echo "<img src='images/$hinh_anh' alt='Con giáp'>";
                    echo "<img src='images/haha.jpg' alt='Con giáp'>";
                }
                ?>
            </td>
        </tr>
    </table>
</form>

</body>
</html>