<?php
require_once '../../config.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'admin') {
    header("location: admin-login.php");
    exit;
}

// Fetch users for management
$users_stmt = $pdo->query("SELECT id, username, email FROM users WHERE role = 'user'");
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch system reports (simple count)
$user_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$score_count = $pdo->query("SELECT COUNT(*) FROM score_history")->fetchColumn();

// Update tip
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_tip'])) {
    $sql = "INSERT INTO tips (tip_text) VALUES (:tip_text)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['tip_text' => $_POST['new_tip']]);
    header("location: admin-dashboard.php");
    exit;
}

// Delete user (from form)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_POST['delete_user_id']]);
    header("location: admin-dashboard.php");
    exit;
}

// Edit user (simulated, update username/email)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user_id']) && isset($_POST['new_username']) && isset($_POST['new_email'])) {
    $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $_POST['new_username'], 'email' => $_POST['new_email'], 'id' => $_POST['edit_user_id']]);
    header("location: admin-dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CIBIL Score Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen font-['Inter']">
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 shadow-lg sticky top-0 z-10 backdrop-blur-md bg-opacity-80">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../../assets/img/1.png" alt="Logo" class="h-10 mr-3">
                <h1 class="text-3xl font-bold tracking-tight">CIBIL Score Tracker - Admin</h1>
            </div>
            <nav>
                <ul class="flex space-x-8">
                    <li><a href="../../index.php" class="hover:text-indigo-200 transition">Home</a></li>
                    <li><a href="admin-dashboard.php" class="hover:text-indigo-200 transition">Admin Dashboard</a></li>
                    <li><a href="../../logout.php" class="hover:text-indigo-200 transition">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <h2 class="text-4xl font-bold mb-8 text-gray-800">Admin Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Manage Credit Score Data API -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Manage Credit Score Data API</h3>
                <button id="apiBtn" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Update API</button>
            </div>

            <!-- Update Tips & Recommendations -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Update Tips & Recommendations</h3>
                <form method="post" class="space-y-4">
                    <input type="text" name="new_tip" placeholder="New Tip" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50">
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Save</button>
                </form>
                <ul class="list-disc pl-5 mt-4 space-y-2 text-gray-600 tip-list">
                    <?php 
                    $tips_stmt = $pdo->query("SELECT tip_text FROM tips");
                    $tips = $tips_stmt->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($tips as $tip): ?>
                        <li><?php echo htmlspecialchars($tip); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- View System Reports -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow col-span-1 md:col-span-2">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">System Reports</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-indigo-100">
                            <th class="p-3 text-left text-indigo-600">Report</th>
                            <th class="p-3 text-left text-indigo-600">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="p-3 border border-indigo-100">Users</td><td class="p-3 border border-indigo-100"><?php echo $user_count; ?></td></tr>
                        <tr><td class="p-3 border border-indigo-100">Scores Fetched</td><td class="p-3 border border-indigo-100"><?php echo $score_count; ?></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Manage Users -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow col-span-1 md:col-span-2">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Manage Users</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-indigo-100">
                            <th class="p-3 text-left text-indigo-600">User</th>
                            <th class="p-3 text-left text-indigo-600">Email</th>
                            <th class="p-3 text-left text-indigo-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="p-3 border border-indigo-100"><?php echo htmlspecialchars($user['username']); ?></td>
                                <td class="p-3 border border-indigo-100"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="p-3 border border-indigo-100">
                                    <form method="post" class="inline">
                                        <input type="hidden" name="edit_user_id" value="<?php echo $user['id']; ?>">
                                        <input type="text" name="new_username" value="<?php echo htmlspecialchars($user['username']); ?>" class="p-1 border">
                                        <input type="text" name="new_email" value="<?php echo htmlspecialchars($user['email']); ?>" class="p-1 border">
                                        <button type="submit" class="text-indigo-600 hover:underline">Edit</button>
                                    </form> |
                                    <form method="post" class="inline">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="../../assets/js/script.js"></script>
</body>
</html>