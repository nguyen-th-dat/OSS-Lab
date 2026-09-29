<!-- Viết 1 trang web nhận một giá trị ngẫu nhiên là số tự nhiên N có giá trị từ 1 → 100. Hãy xuất ra trình duyệt những số chẵn nằm trong khoảng 1 → N đó. -->
<?php
    $var = rand(1,100);
    echo $var;
    echo "</br>";
    echo "So chan tu 1 -> 100: ";
    for ($i = 1; $i < 100; $i++) {
        if ($i %2== 0) {
            echo $i;
            echo " ";
        }
    }
?>