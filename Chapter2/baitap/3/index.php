<!-- Viết 1 trang web nhận một giá trị ngẫu nhiên là số tự nhiên N có giá trị trong [−100; 100]. Sau đó kiểm tra N có là số dương không? Nếu thỏa thì:
- In ra các ước số của N.
- Viết hàm kiểm tra xem N có phải là số nguyên tố không?
- Tính tổng các số nguyên tố < N.
- Kiểm tra N có là số chính phương? -->

<?php
$N = rand(-100, 100);
// $N = 25;
echo "N = $N";
echo "</br>";
if ($N >= 0) {
    echo "$N la so duong";
    echo "</br>";

    // cac uoc so cua N
    echo "Cac uoc cua $N la: ";

    for ($i = 1; $i <= $N; $i++) {
        if ($N % $i == 0) {
            echo $i;
            echo" ";
        }
    }

    echo "<br>";

    // Ham kiem tra so nguyen to
    function laSoNguyenTo($n)
    {
        if ($n < 2) {
            return false;
        }

        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i == 0) {
                return false;
            }
        }

        return true;
    }


    //Kiem tra so nguyen to 
    if (laSoNguyenTo($N)) {
        echo "$N la so nguyen to\n";
    } else {
        echo "$N khong phai la so nguyen to\n";
    }

    echo "</br>";


    //Tinh tong cac so nguyen to < N
    $tong = 0;

    echo "Cac so nguyen to < $N: ";
    for ($i = 2; $i < $N; $i++) {
        if (laSoNguyenTo($i)) {
            echo $i;
            echo " ";
            $tong += $i;
        }
    }

    echo "có tổng bằng $tong";
    echo "</br>";


    //Kiem tra N co phai so chinh phuong
    function laSoChinhPhuong($n)
    {
        if ($n < 0) {
            return false;
        }

        for ($i = 0; $i * $i <= $n; $i++) {
            if ($i * $i == $n) {
                return true;
            }
        }

        return false;
    }

    if (laSoChinhPhuong($N)) {
        echo "$N la so chinh phuong";
    } else {
        echo "$N khong phai la so chinh phuong";
    }

} else {
    echo "$N khong phai la so duong";
    echo "</br>";
}


?>