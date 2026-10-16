<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập 1</title>
</head>

<body>
    <?php
    if (isset($_POST['kiemtra'])) {
        $n = $_POST['n'];
    }
    ?>
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
    if (isset($n)) {

        // a. Kiem tra n co phai so nguyen duong
        if (!is_numeric($n) && $n <= 0) {
            echo "<p style='color: red;'>" . "Vui lòng nhập một số nguyên dương!" . "</p>";
        } else {
            echo "<p style='color: black;'>" . "$n là số nguyên dương" . "</p>";

            // b. Phat sinh mang ngau nhien gom n so nguyen
            for ($i = 0; $i < $n; $i++) {
                $arr[] = rand(-100, 100);
            }
            echo "<p style='color: black;'>";
            echo "Mảng ngẫu nhiên gồm $n số nguyên: ";
            echo implode(", ", $arr);
            echo "<br>";

            // c. Dem so phan tu chan
            $demchan = 0;
            foreach ($arr as $value) {
                if ($value % 2 == 0) {
                    $demchan++;
                }
            }
            echo "<p style='color: black;'>";
            echo "Mảng có $demchan phần tử chẵn";
            echo "</p>";

            // d. Dem so phan tu nho hon 100
            $countLess100 = 0;
            foreach ($arr as $value) {
                if ($value < 100) {
                    $countLess100++;
                }
            }

            echo "<p style='color: black;'>";
            echo "Mảng có $countLess100 phần tử nhỏ hơn 100";
            echo "</p>";

            // e. Tinh tong cac phan tu am
            $sumNegative = 0;
            $arrNegative = [];

            foreach ($arr as $value) {
                if ($value < 0) {
                    $sumNegative += $value;
                    $arrNegative[] = $value;
                }
            }

            echo "<p style='color: black;'>";
            echo "Cac phan tu am: " . implode(" + ", $arrNegative);
            echo " = $sumNegative";
            echo "</p>";

            // f. In vi tri cac phan tu bang 0
            $positions = [];
            echo "<p style='color: black;'>";


            if (count($positions) > 0) {
                echo "Vi tri cac phan tu bang 0: ";
                foreach ($arr as $index => $value) {
                    if ($value == 0) {
                        $positions[] = $index;
                    }
                }
                echo implode(", ", $positions);
            } else {
                echo "Khong co phan tu nao bang 0";
            }
            echo "</p>";

            // g. Sap xep mang tang dan
            echo "<p style='color: black;'>";
            sort($arr);
            echo "Mang sau khi sap xep tang dan:";
            echo implode(", ", $arr);
            echo "</p>";
        }
    } else {
        echo "<p style='color: red;'>" . "Vui lòng nhập một số nguyên dương!" . "</p>";
    }
    ?>
</body>

</html>