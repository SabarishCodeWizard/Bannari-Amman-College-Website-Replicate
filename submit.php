<?php

$fname = $_POST['fname'];
$uname = $_POST['uname'];
$email = $_POST['email'];
$pnum = $_POST['pnum'];
$pass = $_POST['pass'];
$cpass = $_POST['cpass'];
$city = $_POST['city'];
$state = $_POST['state'];

if (!empty($fname) && !empty($uname) && !empty($email) && !empty($pnum) && !empty($pass) && !empty($cpass) && !empty($city) && !empty($state)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "project amada ams";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT email FROM submit WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO submit (fname, uname, email, pnum, pass, cpass, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssissss", $fname, $uname, $email, $pnum, $pass, $cpass, $city, $state);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone has already registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>
