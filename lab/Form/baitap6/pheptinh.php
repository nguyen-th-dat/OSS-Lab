<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phép tính</title>

    <style>
        body {
            font-family: Arial;
        }

        table {
            margin: 50px auto;
        }

        .title {
            color: #4682B4;
            text-align: center;
            font-weight: bold;
        }

        .label {
            color: #4169E1;
            font-weight: bold;
        }

        .pheptinh {
            color: #CD5C5C;
            font-weight: bold;
        }
    </style>
</head>

<body>

<form action="ketquapheptinh.php" method="post">

    <table>

        <tr>
            <td colspan="2" class="title">
                PHÉP TÍNH TRÊN HAI SỐ
            </td>
        </tr>

        <tr>
            <td class="pheptinh">
                Chọn phép tính:
            </td>

            <td>
                <input type="radio" name="pheptinh" value="cong" checked>
                Cộng

                <input type="radio" name="pheptinh" value="tru">
                Trừ

                <input type="radio" name="pheptinh" value="nhan">
                Nhân

                <input type="radio" name="pheptinh" value="chia">
                Chia
            </td>
        </tr>

        <tr>
            <td class="label">
                Số thứ nhất:
            </td>

            <td>
                <input type="number"
                       name="so1"
                       step="any"
                       required>
            </td>
        </tr>

        <tr>
            <td class="label">
                Số thứ hai:
            </td>

            <td>
                <input type="number"
                       name="so2"
                       step="any"
                       required>
            </td>
        </tr>

        <tr>
            <td></td>

            <td>
                <input type="submit"
                       value="Tính">
            </td>
        </tr>

    </table>

</form>

</body>
</html>