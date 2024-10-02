<?php
session_start();

// Retrieve the game state from the session
$players = $_SESSION['game_state']['players'];
$game_over = $_SESSION['game_state']['game_over'];
$roll_result = $_SESSION['game_state']['roll_result'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ludo Game Board</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Ludo Game - <?php echo count($players); ?> Players</h1>
    <div class="game-info">
        <?php foreach ($players as $player): ?>
            <p><?php echo $player['name'] . "'s position: " . $player['position']; ?></p>
        <?php endforeach; ?>
    </div>

    <!-- The Ludo board and other gameplay elements would go here -->

</div>

<!-- Include JavaScript -->
<script src="assets/script.js"></script>

</body>
</html>
