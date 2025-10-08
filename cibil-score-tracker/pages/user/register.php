<?php
require_once '../../config.php';

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => trim($_POST["username"])]);
        if ($stmt->rowCount() > 0) {
            $username_err = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => trim($_POST["email"])]);
        if ($stmt->rowCount() > 0) {
            $email_err = "This email is already taken.";
        } else {
            $email = trim($_POST["email"]);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, 'user')";
        $stmt = $pdo->prepare($sql);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if ($stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $password_hash])) {
            header("location: login.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CIBIL Score Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen flex items-center justify-center font-['Inter']">
    <div class="max-w-md w-full bg-white bg-opacity-80 backdrop-blur-md p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Create Your Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-6">
            <div class="relative">
                <label class="block text-gray-700 mb-2" for="username">Username</label>
                <input type="text" name="username" id="username" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50 <?php echo (!empty($username_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter username">
                <span class="text-red-500 text-sm"><?php echo $username_err; ?></span>
            </div>
            <div class="relative">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50 <?php echo (!empty($email_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter email">
                <span class="text-red-500 text-sm"><?php echo $email_err; ?></span>
            </div>
            <div class="relative">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50 <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter password">
                <span class="text-red-500 text-sm"><?php echo $password_err; ?></span>
            </div>
            <div class="relative">
                <label class="block text-gray-700 mb-2" for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50 <?php echo (!empty($confirm_password_err)) ? 'border-red-500' : ''; ?>" placeholder="Confirm password">
                <span class="text-red-500 text-sm"><?php echo $confirm_password_err; ?></span>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Register</button>
        </form>
        <p class="text-center mt-6 text-gray-600">Already have an account? <a href="login.php" class="text-indigo-600 hover:underline">Login</a></p>
    </div>
    <script src="../../assets/js/script.js"></script>
</body>
</html>