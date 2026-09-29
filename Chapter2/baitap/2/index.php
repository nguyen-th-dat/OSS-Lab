<!-- Xây dựng 1 trang web thỏa yêu cầu xuất ra bảng cửu chương từ 1 → 10 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng cửu chương</title>
</head>
<body>
    <h1 align="center">BẢNG CỬU CHƯƠNG</h1>
    <table border="1" align="center">
        <tr>
            <?php
            for($i = 1; $i <= 10; $i++) {
                echo "<th>Chương $i</th>";
            }
            ?>
        </tr>
        <?php
            for($i=1; $i<=10; $i++){
                echo "<tr>";
                for($j=1; $j<=10; $j++){
                    echo "<td>$i x $j = ". $i*$j."</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
    <!-- <?php
        echo"BANG CUU CHUONG";
        echo "</br>";
        echo "</br>";
        for( $i = 1; $i <= 10; $i++ ){
            echo "Bang cuu chuong $i";
            echo "</br>";
            for( $j = 1; $j <=   10; $j++ ){
                $var = $i* $j;
                echo "$i x $j = $var";
                echo "</br>";
            }
            echo "</br>";

        }
    ?> -->
</body>
</html>