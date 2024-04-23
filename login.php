<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
   
</head>

<body>
<noscript>
        <div style="text-align: center; padding: 20px; background-color: #850de7; color: white;">
            JavaScript must be enabled to use this website. Please enable JavaScript in your browser settings.
        </div>
    </noscript>
<?php
$conn = mysqli_connect('localhost','root','','mp') or die('connection failed');
$username = $_POST['uname'];
$hashedPassword = $_POST['hashedPassword'];

$conn = new mysqli('localhost','root','','mp');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
}

else { 
    $stmt = $conn->prepare("select * from user where uname = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute(); 
    $stmt_result = $stmt->get_result();

    $data = $stmt_result->fetch_assoc();

    if ($data && $data['password'] == $hashedPassword) {
        
        $i = $data['i'];
        $Yi_db = $data['Yi'];
        $Zi_db = $data['Zi'];

        $j = $i - 1;
        $concatenated_string = $username . $hashedPassword . $j;
        $X = hash('sha256', $concatenated_string);
        $Xj = hash('sha256', $X);
        $Yj = hash('sha256', $Xj);

        $concatenated_string2 = $username . $hashedPassword . $i;
        $Xb = hash('sha256', $concatenated_string2);
        $Xi = hash('sha256', $Xb);
        $hash_Xi= hash('sha256', $Xi);
        $concatenated_string3 = $Xj . $hash_Xi;
        $Zj = hash('sha256', $concatenated_string3);

        if($Yj == $Yi_db && $Zj == $Zi_db){
            echo "<b><h2 style='color: green;'><br><br><br><br><br><br><center>Click on the button to generate OTP</center></h2></b>";
            
            $recipientEmail = $data['email'];
            echo "<br><br><center><button onclick='generateOTP()'>Send OTP</button></center>";
            // Add a <div> element to display the OTP
            echo "<div id='otpDisplay'></div>";

            $concatenated_string_final = $username . $hashedPassword . $i;
            $X_final = hash('sha256', $concatenated_string_final);
            $Xi_final = hash('sha256', $X_final);
            $Yi_final = hash('sha256', $Xi_final);
            
            $i2=$i+1;
            $concatenated_string2_final = $username . $hashedPassword . $i2;
            $X2_final = hash('sha256', $concatenated_string2_final);
            $Xi2_final = hash('sha256', $X2_final);
            $hash_Xi2_final= hash('sha256', $Xi2_final);
            $concatenated_string3_final = $Xi_final . $hash_Xi2_final;
            $Zi_final = hash('sha256', $concatenated_string3_final);

            $stmt2 = $conn->prepare("UPDATE user SET i = i + 1 where uname = ? ");
            $stmt2->bind_param("s", $username);
            $stmt2->execute();

            $stmt3 = $conn->prepare("UPDATE user SET Yi = ?, Zi = ? WHERE uname = ?");
            $stmt3->bind_param("sss", $Yi_final, $Zi_final, $username);
            $stmt3->execute();
        } else {
            echo "<b><h2 style='color: red;'><br><br><center>Yi and/or Zi values don't match</center></h2></b>";
        }
    } else {
        echo "<h2 style='color: red;'><br><br><center>Invalid Username or password</center></h2>";
    }
}
?>

<script>
// Function to generate OTP and send it via email
function generateOTP() {
    // Define length of OTP
    var otpLength = 6;
    // Define possible characters for OTP
    var chars = "0123456789";
    var otp = "";

    // Generate OTP randomly
    for (var i = 0; i < otpLength; i++) {
        otp += chars[Math.floor(Math.random() * chars.length)];
    }

    // Display generated OTP
    //document.getElementById("otpDisplay").innerText = "Generated OTP: " + otp;

    // Get recipient email from PHP (embedded in the HTML)
    var recipientEmail = "<?php echo $recipientEmail; ?>";

    // Initialize EmailJS with your service ID
    emailjs.init("xjlpX8wIpY2wCjTdW");

    // Send OTP via email using EmailJS
    var templateParams = {
        to_email: recipientEmail,
        otp: otp
    };

    emailjs.send("service_kappnq8", "template_b04oc8k", templateParams)
        .then(function(response) {
            console.log("Email sent:", response);
            // Optionally, display a message indicating that the OTP has been sent
            alert("OTP has been sent to your email address.");
        }, function(error) {
            console.error("Email failed to send:", error);
            // Optionally, display an error message if sending fails
            alert("Failed to send OTP. Please try again later.");
        });
}
</script>
</body>
</html>
