<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ludo_game";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// Fetch user game stats from the database
$user_id = $_SESSION['user_id'];

$sql_games_played = "SELECT COUNT(*) AS total_played FROM games WHERE user_id = $user_id";
$result_games_played = $conn->query($sql_games_played);
$total_played = $result_games_played->fetch_assoc()['total_played'];

$sql_games_won = "SELECT COUNT(*) AS total_won FROM games WHERE user_id = $user_id AND result = 'won'";
$result_games_won = $conn->query($sql_games_won);
$total_won = $result_games_won->fetch_assoc()['total_won'];

$total_lost = $total_played - $total_won;

$sql_recent_games = "SELECT created_at, result FROM games WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
$result_recent_games = $conn->query($sql_recent_games);
$recent_games = $result_recent_games->fetch_all(MYSQLI_ASSOC);

$conn->close(); // Close the connection once done

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ludo Game</title>
    <style>
        /* General reset and basic styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        /* Navbar styling */
        .navbar {
            background-color: #4CAF50;
            padding: 1rem;
            color: white;
            text-align: center;
            font-size: 24px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
        }

        /* Dashboard container */
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        /* Welcome message */
        .welcome {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Stats and info section */
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .stat-box {
            width: 30%;
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-box h2 {
            margin: 0;
            font-size: 36px;
        }

        .stat-box p {
            margin: 10px 0 0;
            font-size: 18px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .stat {
            background: #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            flex: 1;
            margin: 0 10px;
            text-align: center;
        }
        .recent-games {
            margin-top: 20px;
        }
        .game-list {
            list-style: none;
            padding: 0;
        }
        .game-list li {
            background: #e9e9e9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .start-game {
            text-align: center;
            margin-top: 20px;
        }
        .start-game button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .start-game button:hover {
            background-color: #0056b3;
        }

        /* Logout button */
        .logout {
            display: inline-block;
            background-color: #ff4b5c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .logout:hover {
            background-color: #d73c4a;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        Ludo Game Dashboard
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Main dashboard content -->
    <div class="container">
        <div class="welcome">
            Welcome, <?php echo $_SESSION['username']; ?>! 🎉
        </div>

        <!-- Stats section -->
        <div class="stats">
    <div class="stat-box">
        <h2><?php echo $total_played; ?></h2>
        <p>Games Played</p>
    </div>
    <div class="stat-box">
        <h2><?php echo $total_won; ?></h2>
        <p>Games Won</p>
    </div>
    <div class="stat-box">
        <h2><?php echo $total_lost; ?></h2>
        <p>Games Lost</p>
    </div>
</div>


<div class="recent-games">
        <h2>Your Recent Games</h2>
        <ul class="game-list">
            <?php if (count($recent_games) > 0): ?>
                <?php foreach ($recent_games as $game): ?>
                    <li><?php echo $game['created_at'] . " - Result: " . $game['result']; ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No recent games found.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="start-game">
        <h2>Ready to Play?</h2>
        <button onclick="location.href='start_game.php'">Start New Game</button> <!-- Link to start a new game -->
    </div>
</div>

        <!-- You can add more sections here as needed, such as Recent Matches, Leaderboard, etc. -->
    </div>

</body>
</html>
