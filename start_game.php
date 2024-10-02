<?php
session_start();

// Check if user is logged in (you can skip this if not required)
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// Determine the number of players (default to 4 players if not specified)
$num_players = isset($_GET['players']) && in_array($_GET['players'], [2, 4]) ? (int)$_GET['players'] : 4;

// Initialize game state if not already set
if (!isset($_SESSION['game_state'])) {
    $players = [];
    for ($i = 1; $i <= $num_players; $i++) {
        $players[] = ['id' => $i, 'position' => 0, 'name' => "Player $i"];
    }
    
    $_SESSION['game_state'] = [
        'players' => $players,
        'current_turn' => 0,
        'game_over' => false,
        'roll_result' => null,
    ];
}

// Redirect to the actual game logic
header("Location: ludo_board.php"); // Replace with your game board page

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Ludo Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 30px;
        }
        .player-select {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .player-option {
            width: 150px;
            height: 150px;
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .player-option:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Select Number of Players</h1>
    <div class="player-select">
        <a href="game.php?players=2" class="player-option">2 Players</a>
        <a href="game.php?players=4" class="player-option">4 Players</a>
    </div>
</div>

</body>
</html>
