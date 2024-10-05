<?php 
$host = "localhost";
$uname = "root";
$pw = "";
$dbname = "simple_attendance_db";

try {
    $conn = new MySQLi($host, $uname, $pw, $dbname);
} catch(Exception $e) {
    echo "Database Connection Failed: <br>";
    print_r($e->getMessage());
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (firstname, lastname, username, password) VALUES ('$firstname', '$lastname', '$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo "Login successful";
                header("location: home.php");
            } else {
                echo "Invalid password";
            }
        } else {
            echo "No user found";
        }
    }
}
?>

<style>
    body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.card {
    display: flex;
    width: 800px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    overflow: hidden;
}

.signup, .signin {
    flex: 1;
    padding: 40px;
    transition: all 0.3s ease;
    background-color: #f7f7f7;
}

.signup:hover, .signin:hover {
    flex: 2;
}

.signup h2, .signin h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
}

.signup form, .signin form {
    display: none;
}

.signup:hover form, .signin:hover form {
    display: block;
}

.signup:hover .signin h2, .signin:hover .signup h2 {
    display: none;
}

.signup:hover .signin::before, .signin:hover .signup::before {
    content: "Welcome!";
    display: block;
    text-align: center;
    margin-top: 30px;
    font-size: 20px;
    color: #888;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="card">
        <div class="signup">
            <h2>Sign Up</h2>
            <form method="POST">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confpassword" placeholder="Confirm Password" required>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="signin">
            <h2>Sign In</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
