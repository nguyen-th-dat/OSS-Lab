<?php
if (isset($_POST['kiemtra'])) {
    $n = $_POST['n'];

    // a. Kiem tra n co phai so nguyen duong
    if (!is_numeric($n) && $n <= 0) {
        $msg = "Vui lòng nhập một số nguyên dương!";
    } else {
        $msg = "$n là số nguyên dương";
    

    // b. Phat sinh mang ngau nhien gom n so nguyen
    for ($i = 0; $i < $n; $i++) {
        $arr[] = rand(-100, 100);
    }

    // c. Dem so phan tu chan
    $demchan = 0;
    foreach ($arr as $value) {
        if ($value % 2 == 0) {
            $demchan++;
        }
    }

    // d. Dem so phan tu nho hon 100
    $countLess100 = 0;
    foreach ($arr as $value) {
        if ($value < 100) {
            $countLess100++;
        }
    }


    // e. Tinh tong cac phan tu am
    $sumNegative = 0;
    foreach ($arr as $value) {
        if ($value < 0) {
            $sumNegative += $value;
        }
    }


    // f. In vi tri cac phan tu bang 0
    $positions = [];

    // g. Sap xep mang tang dan
    }

}
else {
    $msg = "Vui lòng nhập một số nguyên dương!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập 1</title>
</head>

<body>
    <!-- // a. Kiem tra n co phai so nguyen duong -->
    <form action="baitap1.php" method="post">
        <table>
            <tr>
                <td>
                    Nhập N:
                </td>
                <td>
                    <input type="text" name="n" placeholder="Nhập số nguyên dương" value="<?php if (isset($n)) echo "$n"; ?>">
                </td>
                <td>
                    <input type="submit" value="Kiểm tra" name="kiemtra">
                </td>

            </tr>
        </table>
    </form>

    <?php
    if (isset($msg)) {
        echo "<p style='color: red;'>" . $msg . "</p>";
    }
    ?>


    
    <?php
    // b. Phat sinh mang ngau nhien gom n so nguyen
    if (isset($arr)) {
        echo "<p style='color: red;'>";
        echo "Mảng ngẫu nhiên gồm $n số nguyên: ";

        echo implode(", ", $arr);
        echo "</p>";
    }
    ?>

    
    <?php
    // c. Dem so phan tu chan
    if (isset($demchan)) {
        echo "<p style='color: red;'>";
        echo "Mảng có $demchan phần tử chẵn";
        echo "</p>";
    }
    ?>

    
    <?php
    // d. Dem so phan tu nho hon 100
    if (isset($countLess100)) {
        echo "<p style='color: red;'>";
        echo "Mảng có $countLess100 phần tử nhỏ hơn 100";
        echo "</p>";
    }
    ?>
    
    
    <?php
    // e. Tinh tong cac phan tu am
    if (isset($sumNegative)) {
        echo "<p style='color: red;'>";
        echo "Tổng các phần tử âm: $sumNegative";
        echo "</p>";
    }
    ?>

    
    <?php
    // f. In vi tri cac phan tu bang 0
    if (isset($positions)) {
        echo "<p style='color: red;'>";
        echo "Vi tri cac phan tu bang 0: ";
        

        foreach ($arr as $index => $value) {
            if ($value == 0) {
                $positions[] = $index;
            }
        }

        if (count($positions) > 0) {
            echo implode(", ", $positions);
        } else {
            echo "Khong co phan tu nao bang 0";
        }
        echo "</p>";
    }
    ?>

    <?php
    // g. Sap xep mang tang dan
    if (isset($demchan)) {
        echo "<p style='color: red;'>";
        sort($arr);
        echo "Mang sau khi sap xep tang dan:";
        echo implode(", ", $arr);
        echo "</p>";
    }
    ?>

</body>

</html>