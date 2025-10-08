<?php
require_once '../../config.php';

session_start();

// Check if the admin is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] === 'admin') {
    header("location: admin-dashboard.php");
    exit;
}

// Use the same login logic as user, but this page is for admin (can merge, but kept separate per original design)
$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password_hash, role FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash']) && $user['role'] === 'admin') {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user['id'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["role"] = $user['role'];
            header("location: admin-dashboard.php");
            exit;
        } else {
            $login_err = "Invalid username or password, or not an admin.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CIBIL Score Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen flex items-center justify-center font-['Inter']">
    <div class="max-w-md w-full bg-white bg-opacity-80 backdrop-blur-md p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Admin Sign In</h2>
        <span class="text-red-500 text-sm"><?php echo $login_err; ?></span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-6">
            <div class="relative">
                <label class="block text-gray-700 mb-2" for="username">Username</label>
                <input type="text" name="username" id="username" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50 <?php echo (!empty($username_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter username">
                <span class="text-red-500 text-sm"><?php echo $username_err; ?></span>
            </div>
            <div class="relative">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50 <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter password">
                <span class="text-red-500 text-sm"><?php echo $password_err; ?></span>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Login</button>
        </form>
    </div>
    <script src="../../assets/js/script.js"></script>
</body>
</html>