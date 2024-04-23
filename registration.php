<link rel="stylesheet" href="styles.css">
<?php
$conn = mysqli_connect('localhost', 'root', '', 'mp') or die('connection failed');

$username = $_POST['uname'];
$email = $_POST['email'];
//$hashedPassword2 = password_hash($hashedPassword, PASSWORD_DEFAULT);
$hashedPassword = $_POST['hashedPassword']; 
$i = rand(0, 1000);

$concatenated_string = $username . $hashedPassword . $i;
$X = hash('sha256', $concatenated_string);
$Xi = hash('sha256', $X);
$Yi = hash('sha256', $Xi);

$i2 = $i + 1;
$concatenated_string2 = $username . $hashedPassword . $i2;
$X2 = hash('sha256', $concatenated_string2);
$Xi2 = hash('sha256', $X2);
$hash_Xi2 = hash('sha256', $Xi2);
$concatenated_string3 = $Xi . $hash_Xi2;
$Zi = hash('sha256', $concatenated_string3);

if (empty($hashedPassword)) {
    echo "<b><h2 style='color: red;'><br><br><center>Password is required</center></h2></b>";

} elseif (empty($username)) {
    echo  "<b><h2 style='color: red;'><br><br><center>Username is required</center></h2></b>";
}
else {
    $conn = new mysqli('localhost', 'root', '', 'mp');
    if ($conn->connect_error) {
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);
    } else {
        $stmt = $conn->prepare("insert into user(uname, password, i, Yi, Zi, email) values(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", $username, $hashedPassword, $i2, $Yi, $Zi, $email);
        $execval = $stmt->execute();
        echo "<b><h2 style='color: green;'><br><br><center>Registration successful...</center></h2></b>";
        echo "<br><br><center><button onclick=\"window.location.href='index.html';\" >Login</button></center>";
        $stmt->close();
        $conn->close();
    }
}
?>
