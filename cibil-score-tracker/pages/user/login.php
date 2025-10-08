<?php
require_once '../../config.php';

session_start();

// Check if the user is already logged in, if yes then redirect him to dashboard page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["role"] === 'admin') {
        header("location: ../../pages/admin/admin-dashboard.php");
    } else {
        header("location: dashboard.php");
    }
    exit;
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, email, password_hash, role FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Password is correct, so start a new session
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user['id'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["role"] = $user['role'];

            // Redirect user to dashboard page
            if ($_SESSION["role"] === 'admin') {
                header("location: ../../pages/admin/admin-dashboard.php");
            } else {
                header("location: dashboard.php");
            }
            exit;
        } else {
            // Password is not valid, display a generic error message
            $login_err = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CIBIL Score Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen flex items-center justify-center font-['Inter']">
    <div class="max-w-md w-full bg-white bg-opacity-80 backdrop-blur-md p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Sign In</h2>
        <span class="text-red-500 text-sm"><?php echo $login_err; ?></span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-6">
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
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Login</button>
        </form>
        <p class="text-center mt-6 text-gray-600">Don't have an account? <a href="register.php" class="text-indigo-600 hover:underline">Register</a></p>
    </div>
    <script src="../../assets/js/script.js"></script>
</body>
</html>