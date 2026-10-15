<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sắp xếp mảng</title>
</head>
<body>

<?php
// Hoan vi hai so
function hoan_vi(&$a, &$b) {
    $tam = $a;
    $a = $b;
    $b = $tam;
}

// Sap xep tang dan
function sap_tang($mang) {
    $n = count($mang);

    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ($mang[$i] > $mang[$j]) {
                hoan_vi($mang[$i], $mang[$j]);
            }
        }
    }

    return $mang;
}

// Sap xep giam dan
function sap_giam($mang) {
    $n = count($mang);

    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ($mang[$i] < $mang[$j]) {
                hoan_vi($mang[$i], $mang[$j]);
            }
        }
    }

    return $mang;
}

// $day_so = "3,1,7,4,8,5,9,1,2,6";
$tang = "";
$giam = "";
$loi = "";

if (isset($_POST['sap_xep'])) {
    $day_so = trim($_POST['day_so']);

    if ($day_so == "") {
        $loi = "Vui long nhap mang!";
    } else {
        $mang = explode(",", $day_so);
        $hop_le = true;

        // Kiem tra cac phan tu trong mang
        foreach ($mang as $value) {
            $value = trim($value);

            if ($value == "" || !is_numeric($value)) {
                $hop_le = false;
                break;
            }
        }

        if ($hop_le) {
            $mang = array_map("trim", $mang);

            $mang_tang = sap_tang($mang);
            $mang_giam = sap_giam($mang);

            $tang = implode(", ", $mang_tang);
            $giam = implode(", ", $mang_giam);
        } else {
            $loi = "Mang khong hop le! Cac so phai cach nhau bang dau phay.";
        }
    }
}
?>

<form method="post" action="">
    <table border="1" cellpadding="5" cellspacing="0"
           width="600" align="center">

        <tr bgcolor="#309e99">
            <th colspan="2">
                <font color="white" size="5">
                    SAP XEP MANG
                </font>
            </th>
        </tr>

        <tr>
            <td>Nhap mang:</td>
            <td>
                <input type="text" name="day_so" size="35"
                    value="<?php if (isset($day_so)) echo $day_so; ?>"
                    required>
                <span style="color:red;">(*)</span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type="submit" name="sap_xep"
                       value="Sap xep tang/giam">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <b style="color:red;">Sau khi sap xep:</b>
            </td>
        </tr>

        <tr>
            <td>Tang dan:</td>
            <td>
                <input type="text" size="35" readonly
                    value="<?php if (isset($tang)) echo $tang; ?>">
            </td>
        </tr>

        <tr>
            <td>Giam dan:</td>
            <td>
                <input type="text" size="35" readonly
                    value="<?php if (isset($giam)) echo $giam; ?>">
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <span style="color:red;">(*)</span>
                Cac so duoc nhap cach nhau bang dau phay (,).
            </td>
        </tr>

        <?php if ($loi != "") { ?>
        <tr>
            <td colspan="2" style="color:red;">
                <?php echo $loi; ?>
            </td>
        </tr>
        <?php } ?>

    </table>
</form>

</body>
</html>