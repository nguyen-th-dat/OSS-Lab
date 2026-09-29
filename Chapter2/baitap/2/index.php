<!-- Xây dựng 1 trang web thỏa yêu cầu xuất ra bảng cửu chương từ
1 → 10. -->
<?php
    echo"BANG CUU CHUONG";;
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
echo "";
    }
?>
