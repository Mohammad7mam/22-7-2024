<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
      function validateSignupForm() {
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm_password').value;
    let emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    let email = document.getElementById('email').value;
    let mobilePattern = /^\d{10}$/;
    let mobile = document.getElementById('mobile').value;

    if (!emailPattern.test(email)) {
        alert('Invalid email format');
        return false;
    }
    if (!mobilePattern.test(mobile)) {
        alert('Mobile number must be 10 digits');
        return false;
    }
    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return false;
    }
    if (password.length < 8) {
        alert('Password must be at least 8 characters long');
        return false;
    }
    return true;
}

function validateLoginForm() {
    let emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (!emailPattern.test(email)) {
        alert('Invalid email format');
        return false;
    }
    if (password.length < 8) {
        alert('Password must be at least 8 characters long');
        return false;
    }
    return true;
}

    </script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #666;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Form</h2>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
<?php
session_start();
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (empty($email) || empty($password)) {
        echo "<script>alert('Both fields are required.'); window.history.back();</script>";
    } elseif (!preg_match($email_regex, $email)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
    } else {
        $conn = new mysqli("localhost", "root", "", "my_new_databaase");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                header("Location: welcome.php");
                exit();
            } else {
                echo "<script>alert('Incorrect password.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('No user found with that email.'); window.history.back();</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>



































<!-- 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (empty($email) || empty($password)) {
        echo "<script>alert('Both fields are required.');</script>";
    } elseif (!preg_match($email_regex, $email)) {
        echo "<script>alert('Invalid email format.');</script>";
    } else {
        $conn = new mysqli("localhost", "root", "", "my_new_database");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                header("Location: welcome.php");
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('No user found with that email.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
-->
<!-- if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (empty($email) || empty($password)) {
        echo "<script>alert('Both fields are required.');</script>";
    } elseif (!preg_match($email_regex, $email)) {
        echo "<script>alert('Invalid email format.');</script>";
    } else {
        $conn = new mysqli("localhost", "root", "", "my_new_database");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                header("Location: welcome.php");
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('No user found with that email.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
 -->
