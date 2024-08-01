<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "welcome";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if POST data is set and provide default values
        $fname = isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '';
        $lname = isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : '';
        $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
        $register = isset($_POST['register']) ? htmlspecialchars($_POST['register']) : '';
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

        // Validate phone number length
        if (strlen($phone) > 20) {
            $phone = substr($phone, 0, 20); // Truncate to fit column length
        }

    
        // Correct SQL statement
        $sql = "INSERT INTO login (fname, lname, phone, register, email) VALUES (:fname, :lname, :phone, :register, :email)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':register', $register);
        $stmt->bindParam(':email', $email);

        // Execute statement
        $stmt->execute();

        echo "<center><h2>Record inserted successfully</h2></center>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
