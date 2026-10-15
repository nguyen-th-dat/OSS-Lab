<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bài tập 3</title>

    <style>
        table {
            width: 650px;
            margin: auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th {
            background-color: #a00078;
            color: white;
            font-size: 24px;
            font-style: italic;
            padding: 10px;
        }

        td {
            padding: 5px 10px;
        }

        .input-row {
            background-color: #f8d9f0;
        }

        input[type="number"] {
            width: 270px;
        }

        input[type="text"] {
            width: 340px;
            background-color: #f7a09c;
            border: 1px solid #ccc;
        }

        .result {
            width: 140px !important;
        }

        input[type="submit"] {
            width: 240px;
            padding: 6px;
            background-color: #fff19b;
            border: 1px solid #ccc;
        }

        .note {
            text-align: center;
        }
    </style>
</head>

<body>

    <?php


    if (isset($_POST['tinh'])) {
        $n = $_POST['n'];

        if ($n >= 1 && $n <= 1000) {
            $arr = [];
            $tong = 0;

            for ($i = 0; $i < $n; $i++) {
                $arr[] = rand(0, 20);
            }

            $max = max($arr);
            $min = min($arr);
            $tong = array_sum($arr);
        }
    }
    ?>

    <form method="post">
        <table border="1">
            <tr>
                <th colspan="2">PHÁT SINH MẢNG VÀ TÍNH TOÁN</th>
            </tr>

            <tr class="input-row">
                <td>Nhập số phần tử:</td>
                <td>
                    <input type="text" 
                    name="n"
                        value="<?php if (isset($n)) echo "$n"; ?>" 
                        required>
                </td>
            </tr>

            <tr class="input-row">
                <td></td>
                <td>
                    <input type="submit" name="tinh"
                        value="Phát sinh và tính toán">
                </td>
            </tr>

            <tr>
                <td>Mảng:</td>
                <td>
                    <input type="text"
                        value="<?php echo implode(' ', $arr); ?>"
                        readonly>
                </td>
            </tr>

            <tr>
                <td>GTLN (MAX) trong mảng:</td>
                <td>
                    <input type="text" class="result"
                        value="<?php echo $max; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td>TTNN (MIN) trong mảng:</td>
                <td>
                    <input type="text" class="result"
                        value="<?php echo $min; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td>Tổng mảng:</td>
                <td>
                    <input type="text" class="result"
                        value="<?php echo $tong; ?>" readonly>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="note">
                    <b style="color: red;">Ghi chú:</b>
                    Các phần tử trong mảng sẽ có giá trị từ 0 đến 20
                </td>
            </tr>
        </table>
    </form>

</body>

</html>