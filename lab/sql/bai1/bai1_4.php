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
            white-space: pre-wrap;
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
            "Cho biet tri gia trung binh cua cac hoa don, lam tron den hang nghin",
            "SELECT ROUND(AVG(Tri_gia), -3) AS Tri_gia_trung_binh
         FROM hoa_don"
        ],

        2 => [
            "Liet ke cac hoa don trong thang 7 nam 2007",
            "SELECT *
         FROM hoa_don
         WHERE DAY(Ngay_HD) > 0
           AND MONTH(Ngay_HD) = 7
           AND YEAR(Ngay_HD) = 2007"
        ],

        3 => [
            "Liet ke hoa don va so ngay tu ngay hoa don den ngay hien tai, sap xep giam dan",
            "SELECT *,
                DATEDIFF(CURDATE(), Ngay_HD) AS So_ngay
                FROM hoa_don
                ORDER BY So_ngay DESC"
        ],

        4 => [
            "Liet ke cac sua co ten dai khong qua 10 ky tu",
            "SELECT *
         FROM sua
         WHERE LENGTH(Ten_sua) <= 10"
        ],

        5 => [
            "Liet ke ten cac hang sua bang chu in hoa",
            "SELECT UPPER(Ten_hang_sua) AS Ten_hang_sua,
                Dia_chi,
                Dien_thoai
         FROM hang_sua"
        ],

        6 => [
            "Liet ke hoa don voi ngay theo dang Thu - ngay - thang - nam",
            "SELECT So_hoa_don,
                DATE_FORMAT(Ngay_HD, '%W - %d - %m - %Y') AS Ngay_hoa_don
         FROM hoa_don"
        ],

        7 => [
            "Liet ke sua duoc ban trong thang 8 nam 2007, kem trong luong va don gia",
            "SELECT DISTINCT
                s.Ten_sua,
                CONCAT(s.Trong_luong, 'gr') AS Trong_luong,
                CONCAT(FORMAT(s.Don_gia, 0), ' VNĐ') AS Don_gia
         FROM sua s
         JOIN ct_hoadon ct ON s.Ma_sua = ct.Ma_sua
         JOIN hoa_don hd ON ct.So_hoa_don = hd.So_hoa_don
         WHERE MONTH(hd.Ngay_HD) = 8
           AND YEAR(hd.Ngay_HD) = 2007"
        ],

        8 => [
            "Liet ke ma va ten khach hang, hien thi gioi tinh Nam hoac Nu",
            "SELECT CONCAT(Ma_khach_hang, ' - ', Ten_khach_hang) AS ma_ten_KH,
                IF(Phai = 0, 'Nam', 'Nu') AS Gioi_tinh
         FROM khach_hang"
        ],

        9 => [
            "Liet ke sua nang tu 400g den 500g va danh gia theo don gia",
            "SELECT Ten_sua,
                Trong_luong,
                Don_gia,
                IF(Don_gia < 100000,
                   'Sua gia trung binh',
                   IF(Don_gia > 100000,
                      'Sua gia cao',
                      'Gia 100000 VNĐ')) AS Danh_gia
         FROM sua
         WHERE Trong_luong BETWEEN 400 AND 500"
        ],

        10 => [
            "Liet ke hoa don voi thu trong tuan bang tieng Viet, sap xep ngay tang dan",
            "SELECT So_hoa_don,
                CONCAT(
                    CASE DAYOFWEEK(Ngay_HD)
                        WHEN 1 THEN 'Chu nhat'
                        WHEN 2 THEN 'Thu hai'
                        WHEN 3 THEN 'Thu ba'
                        WHEN 4 THEN 'Thu tu'
                        WHEN 5 THEN 'Thu nam'
                        WHEN 6 THEN 'Thu sau'
                        WHEN 7 THEN 'Thu bay'
                    END,
                    ' - ',
                    DAY(Ngay_HD), ' - ',
                    MONTH(Ngay_HD), ' - ',
                    YEAR(Ngay_HD)
                ) AS Ngay_hoa_don
         FROM hoa_don
         ORDER BY Ngay_HD ASC"
        ],

        11 => [
            "Dem so khach hang nam, nu va tong so khach hang",
            "SELECT SUM(IF(Phai = 0, 1, 0)) AS So_khach_hang_nam,
                SUM(IF(Phai = 1, 1, 0)) AS So_khach_hang_nu,
                COUNT(*) AS Tong_so_khach_hang
         FROM khach_hang"
        ]
    ];

    // Ham in ket qua truy van
    function inKetQua($conn, $sql)
    {
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "<p style='color:red'>Loi SQL: "
                . htmlspecialchars(mysqli_error($conn))
                . "</p>";
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
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }

        echo "</tr>";

        while ($row = mysqli_fetch_row($result)) {
            echo "<tr>";

            for ($i = 0; $i < $numfields; $i++) {
                echo "<td>" . htmlspecialchars((string)($row[$i] ?? 'NULL')) . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
        echo "</div><br>";

        mysqli_free_result($result);
    }

    // In lan luot 11 cau truy van
    foreach ($cau_truy_van as $stt => $bai) {
        echo "<h2>Cau $stt: " . htmlspecialchars($bai[0]) . "</h2>";

        echo "<pre class='sql'>"
            . htmlspecialchars($bai[1])
            . "</pre>";

        inKetQua($conn, $bai[1]);

        echo "<hr>";
    }

    mysqli_close($conn);
    ?>

</body>

</html>