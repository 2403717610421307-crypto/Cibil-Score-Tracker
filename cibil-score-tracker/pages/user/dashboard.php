<?php
require_once '../../config.php';

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'user') {
    header("location: login.php");
    exit;
}

// Fetch tips from DB
$tips_stmt = $pdo->query("SELECT tip_text FROM tips");
$tips = $tips_stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch score history from DB
$history_stmt = $pdo->prepare("SELECT score, fetched_at AS date FROM score_history WHERE user_id = :user_id ORDER BY fetched_at DESC");
$history_stmt->execute(['user_id' => $_SESSION["id"]]);
$history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);

// Process goal form (simple, store in session for demo; in real, add goals table)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['goal'])) {
    $_SESSION['goal'] = $_POST['goal']; // Simulated
    header("location: dashboard.php");
    exit;
}

// Process profile update (update DB)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['email'])) {
    $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $_POST['name'], 'email' => $_POST['email'], 'id' => $_SESSION["id"]]);
    $_SESSION["username"] = $_POST['name'];
    header("location: dashboard.php");
    exit;
}

// Simulated progress (hardcoded 70%)
$progress = 70;
$goal = isset($_SESSION['goal']) ? $_SESSION['goal'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CIBIL Score Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen font-['Inter']">
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 shadow-lg sticky top-0 z-10 backdrop-blur-md bg-opacity-80">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="../../assets/img/1.png" alt="Logo" class="h-10 mr-3">
                <h1 class="text-3xl font-bold tracking-tight">CIBIL Score Tracker</h1>
            </div>
            <nav>
                <ul class="flex space-x-8">
                    <li><a href="../../index.php" class="hover:text-indigo-200 transition">Home</a></li>
                    <li><a href="dashboard.php" class="hover:text-indigo-200 transition">Dashboard</a></li>
                    <li><a href="../../logout.php" class="hover:text-indigo-200 transition">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <h2 class="text-4xl font-bold mb-8 text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Fetch CIBIL Score -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Fetch CIBIL Score</h3>
                <button id="fetchScoreBtn" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 mb-4">Fetch Score</button>
                <p class="text-5xl font-bold text-gray-800" id="score">--</p>
            </div>

            <!-- Manage Profile & Settings -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Manage Profile & Settings</h3>
                <form method="post" class="space-y-4">
                    <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($_SESSION["username"]); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50">
                    <!-- <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_SESSION["email"]); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50"> -->
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Save</button>
                </form>
            </div>

            <!-- View Tips for Improvement -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Tips for Improvement</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-600">
                    <?php foreach ($tips as $tip): ?>
                        <li><?php echo htmlspecialchars($tip); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Track Goal Progress -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Track Goal Progress</h3>
                <progress value="<?php echo $progress; ?>" max="100" class="w-full h-4 mb-2 rounded bg-indigo-200"></progress>
                <p class="text-gray-600"><?php echo $progress; ?>% towards goal</p>
            </div>

            <!-- Set Credit Goals -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Set Credit Goals</h3>
                <form method="post" class="space-y-4">
                    <input type="text" name="goal" placeholder="Goal (e.g., Reach 750)" value="<?php echo htmlspecialchars($goal); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white bg-opacity-50">
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Save</button>
                </form>
            </div>

            <!-- Generate Recommendations -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Generate Recommendations</h3>
                <button id="recBtn" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 mb-4">Generate</button>
                <p id="recs" class="italic text-gray-600">--</p>
            </div>

            <!-- Analyze Credit Behavior -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow transform hover:scale-105">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Analyze Credit Behavior</h3>
                <div class="h-40 bg-gray-100 rounded flex items-center justify-center text-gray-500">Chart Placeholder</div>
            </div>

            <!-- View Score History -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow col-span-1 md:col-span-2 lg:col-span-3">
                <h3 class="text-xl font-semibold mb-4 text-indigo-600">Score History</h3>
                <button id="historyBtn" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 mb-4">Add Sample Score</button>
                <table id="scoreHistory" class="w-full border-collapse">
                    <thead>
                        <tr class="bg-indigo-100">
                            <th class="p-3 text-left text-indigo-600">Date</th>
                            <th class="p-3 text-left text-indigo-600">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $row): ?>
                            <tr>
                                <td class="p-3 border border-indigo-100"><?php echo htmlspecialchars($row['date']); ?></td>
                                <td class="p-3 border border-indigo-100"><?php echo htmlspecialchars($row['score']); ?></td>
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