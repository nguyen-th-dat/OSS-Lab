<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập truy vấn SQL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h2 {
            color: #0759a5;
        }

        .sql {
            background-color: #f5f5f5;
            padding: 10px;
            overflow-x: auto;
        }
    </style>
</head>

<body>

    <?php
    // Ket noi CSDL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quanly_ban_sua";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Ket noi that bai: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8mb4");

    // Danh sach cac cau truy van
    $cau_truy_van = [
        1 => [
            "Liệt kê danh sách hãng sữa",
            "SELECT Ten_hang_sua, Dia_chi, Dien_thoai
         FROM hang_sua"
        ],

        2 => [
            "Liệt kê khách hàng, sắp xếp tên tăng dần",
            "SELECT Ten_khach_hang, Dia_chi, Dien_thoai
         FROM khach_hang
         ORDER BY Ten_khach_hang ASC"
        ],

        3 => [
            "Liệt kê khách hàng, nam trước nữ sau",
            "SELECT Ten_khach_hang, Phai, Dia_chi, Dien_thoai
         FROM khach_hang
         ORDER BY Phai DESC"
        ],

        4 => [
            "Liệt kê sữa, tên tăng dần và đơn giá giảm dần",
            "SELECT Ten_sua, Trong_luong, Don_gia
         FROM sua
         ORDER BY Ten_sua ASC, Don_gia DESC"
        ],

        5 => [
            "Liệt kê sữa có tên bắt đầu bằng chữ S",
            "SELECT Ten_sua, Trong_luong, Don_gia, TP_Dinh_Duong
         FROM sua
         WHERE Ten_sua LIKE 'S%'"
        ],

        6 => [
            "Liệt kê hãng sữa có mã kết thúc bằng M",
            "SELECT Ma_hang_sua, Ten_hang_sua, Dia_chi, Dien_thoai
         FROM hang_sua
         WHERE Ma_hang_sua LIKE '%M'"
        ],

        7 => [
            "Liệt kê sữa có tên chứa từ grow",
            "SELECT *
         FROM sua
         WHERE Ten_sua LIKE '%grow%'"
        ],

        8 => [
            "Liệt kê sữa có đơn giá lớn hơn 100000",
            "SELECT Ten_sua, Don_gia, Trong_luong
         FROM sua
         WHERE Don_gia > 100000
         ORDER BY Ten_sua DESC"
        ],

        9 => [
            "Liệt kê sữa loại SC của hãng VNM",
            "SELECT Ten_sua, TP_Dinh_Duong, Loi_ich
         FROM sua
         WHERE Ma_loai_sua = 'SC'
           AND Ma_hang_sua = 'VNM'
         ORDER BY Ten_sua ASC"
        ],

        10 => [
            "Liệt kê sữa nặng từ 900g hoặc thuộc hãng DS",
            "SELECT *
         FROM sua
         WHERE Trong_luong >= 900
            OR Ma_hang_sua = 'DS'"
        ],

        11 => [
            "Liệt kê sữa có đơn giá từ 100000 đến 150000",
            "SELECT *
         FROM sua
         WHERE Don_gia BETWEEN 100000 AND 150000"
        ],

        12 => [
            "Liệt kê sữa của hãng DM, DL, DS nặng từ 800g",
            "SELECT *
         FROM sua
         WHERE Ma_hang_sua IN ('DM', 'DL', 'DS')
           AND Trong_luong >= 800
         ORDER BY Trong_luong ASC"
        ],

        13 => [
            "Liệt kê sữa loại SD hoặc có giá không quá 12000",
            "SELECT *
         FROM sua
         WHERE Ma_loai_sua = 'SD'
            OR Don_gia <= 12000"
        ],

        14 => [
            "Liệt kê khách hàng nam có họ tên bắt đầu bằng N",
            "SELECT *
         FROM khach_hang
         WHERE Phai = 0
           AND Ten_khach_hang LIKE 'N%'"
        ],

        15 => [
            "Liệt kê tên hãng sữa có mã không chứa ký tự M",
            "SELECT Ten_hang_sua
         FROM hang_sua
         WHERE Ma_hang_sua NOT LIKE '%M%'"
        ],

        16 => [
            "Liệt kê sữa có thành phần chứa canxi và vitamin",
            "SELECT Ten_sua, TP_Dinh_Duong
         FROM sua
         WHERE TP_Dinh_Duong LIKE '%canxi%'
           AND TP_Dinh_Duong LIKE '%vitamin%'"
        ],

        17 => [
            "Liệt kê sữa nặng 180g, 200g hoặc 900g",
            "SELECT *
         FROM sua
         WHERE Trong_luong IN (180, 200, 900)"
        ],

        18 => [
            "Liệt kê sữa không nặng 400g, 800g hoặc 900g",
            "SELECT *
         FROM sua
         WHERE Trong_luong NOT IN (400, 800, 900)"
        ],

        19 => [
            "Liệt kê 10 sữa có đơn giá cao nhất",
            "SELECT Ten_sua, Don_gia, TP_Dinh_Duong
         FROM sua
         ORDER BY Don_gia DESC
         LIMIT 10"
        ],

        20 => [
            "Liệt kê 3 sữa nặng nhất của hãng Vinamilk",
            "SELECT Ten_sua, Trong_luong
         FROM sua
         WHERE Ma_hang_sua = 'VNM'
         ORDER BY Trong_luong DESC
         LIMIT 3"
        ],

        21 => [
            "Liệt kê sữa của hãng Vinamilk, đơn giá giảm dần",
            "SELECT Ten_sua, Loi_ich, Don_gia
         FROM sua
         WHERE Ma_hang_sua = 'VNM'
         ORDER BY Don_gia DESC"
        ],

        22 => [
            "Liệt kê sữa của hãng Abbott, trọng lượng tăng dần",
            "SELECT Ten_sua, Trong_luong, Loi_ich
         FROM sua
         WHERE Ma_hang_sua = 'AB'
         ORDER BY Trong_luong ASC"
        ]
    ];

    // Ham in ket qua truy van
    function inKetQua($conn, $sql)
    {
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "<p style='color:red'>Loi SQL: "
                . mysqli_error($conn) . "</p>";
            return;
        }

        if (mysqli_num_rows($result) == 0) {
            echo "<p>Khong co du lieu.</p>";
            mysqli_free_result($result);
            return;
        }

        $numfields = mysqli_num_fields($result);

        echo "<div style='overflow-x:auto'>";
        echo "<table>";
        echo "<tr>";

        for ($i = 0; $i < $numfields; $i++) {
            $field = mysqli_fetch_field_direct($result, $i);
            echo "<th>" . $field->name . "</th>";
        }

        echo "</tr>";

        while ($row = mysqli_fetch_row($result)) {
            echo "<tr>";

            for ($i = 0; $i < $numfields; $i++) {
                echo "<td>" . $row[$i] . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
        echo "</div><br>";

        mysqli_free_result($result);
    }

    function inKetQua2($conn, $sql)
    {
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
            return;
        }

        if (mysqli_num_rows($result) != 0) {
            while ($row = mysqli_fetch_row($result)) {
                var_dump($row);
                echo "<br>";
            }
        }

        mysqli_free_result($result);
    }

    // In lan luot 22 cau truy van
    foreach ($cau_truy_van as $stt => $bai) {
        echo "<h2>Câu $stt: " . $bai[0] . "</h2>";

        echo "<pre class='sql'>" . $bai[1] . "</pre>";

        inKetQua($conn, $bai[1]);

        echo "<hr>";
    }

    mysqli_close($conn);
    ?>

</body>

</html>