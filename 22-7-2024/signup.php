<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
            text-align: left;
        }
        h1 {
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .section {
            display: flex;
            justify-content: space-between;
        }
        .section input {
            width: 23%;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }

    </style>
    <script>
        function validateForm() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const mobilePattern = /^\d{10}$/;
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            const email = document.getElementById('email').value;
            const mobile = document.getElementById('mobile').value;
            const firstName = document.getElementById('firstName').value;
            const middleName = document.getElementById('middleName').value;
            const lastName = document.getElementById('lastName').value;
            const familyName = document.getElementById('familyName').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }
            if (!mobilePattern.test(mobile)) {
                alert('Please enter a 10-digit mobile number.');
                return false;
            }
            if (!firstName || !middleName || !lastName || !familyName) {
                alert('Please enter your full name.');
                return false;
            }
            if (!passwordPattern.test(password)) {
                alert('Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters, with no spaces.');
                return false;
            }
            if (password !== confirmPassword) {
                alert('Password and confirmation password do not match.');
                return false;
            }
            return true;
        }
    </script>
</head>
<?php
 $conn = new mysqli("localhost", "root", "", "user_management_system");

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 echo "Connected successfully";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $familyName = $_POST['familyName'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (empty($email) || empty($mobile) || empty($firstName) || empty($middleName) || empty($lastName) || empty($familyName) || empty($password) || empty($role)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (!preg_match($email_regex, $email)) {
        echo "<script>alert('Invalid email format.');</script>";
    } else {
       
        $imageType = $_FILES['image']['type'];
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $created_at = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO users (email, mobile, first_name, middle_name, last_name, family_name, password,  imageType, imageData, created_at) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $email, $mobile, $firstName, $middleName, $lastName, $familyName, $password,  $imageType, $imageData, $created_at);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form onsubmit="return validateForm()" method="post" action="signup.php" enctype="multipart/form-data">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" pattern="\d{10}" required>

            <label>Full Name:</label>
            <div class="section">
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="middleName" name="middleName" placeholder="Middle Name" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                <input type="text" id="familyName" name="familyName" placeholder="Family Name" required>
            </div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>

