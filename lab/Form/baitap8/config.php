<?php

$fullname = $_POST['fullname'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$gender = $_POST['gender'] ?? '';
$country = $_POST['country'] ?? '';
$study = $_POST['study'] ?? [];
$note = $_POST['note'] ?? '';

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Config</title>
</head>

<body>

<?php

echo "Bạn đã nhập thành công, dưới đây là những thông tin bạn đã nhập:";
echo "<br>";

echo "Họ tên: " . $fullname;
echo "<br>";

echo "Address: " . $address;
echo "<br>";

echo "Phone: " . $phone;
echo "<br>";

echo "Gender: " . $gender;
echo "<br>";

echo "Country: " . $country;
echo "<br>";

echo "Study: ";

if (!empty($study)) {

    foreach ($study as $item) {
        echo $item . ", ";
    }

}

echo "<br>";

echo "Note: " . $note;

?>

<br><br>

<a href="form.html">
    Quay về
</a>

</body>
</html>