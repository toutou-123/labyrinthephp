<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <h1>Labyrinthe</h1>
    </header>


    <?php
    session_start();
    $boards = [
        [
            [1, 0, 2, 2, 2, 2, 2],
            [2, 0, 2, 0, 0, 0, 2],
            [2, 0, 2, 0, 2, 0, 2],
            [2, 0, 2, 0, 2, 0, 2],
            [2, 0, 2, 0, 2, 0, 2],
            [2, 0, 0, 0, 2, 0, 3],
            [2, 2, 2, 2, 2, 2, 2]
        ],
        [
            [1, 0, 2, 2, 2, 2, 2],
            [2, 0, 2, 0, 0, 0, 2],
            [2, 0, 2, 0, 2, 0, 2],
            [2, 0, 2, 3, 2, 0, 2],
            [2, 0, 2, 2, 2, 0, 2],
            [2, 0, 0, 0, 0, 0, 2],
            [2, 2, 2, 2, 2, 2, 2]
        ]
    ];
    if (!isset($_SESSION['board'])) {
        $_SESSION['board'] = $boards[rand(0, count($boards) - 1)];
    }
    $maze = $_SESSION['board'];


    if (!isset($_SESSION['pos'])) {
        $_SESSION['pos'] = [0, 0];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['reset'])) {
            session_destroy();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        if (isset($_POST['move']) && !isset($_SESSION['game_over'])) {
            $maze[0][0] = 0;

            switch ($_POST['move']) {
                case 'up':
                    if ($_SESSION['pos'][0] > 0 && $maze[$_SESSION['pos'][0] - 1][$_SESSION['pos'][1]] != 2) {
                        $_SESSION['pos'] = [$_SESSION['pos'][0] - 1, $_SESSION['pos'][1]];
                        if ($maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 3) {
                            echo ("<p> You win </p>");
                            $_SESSION['game_over'] = true;
                        }
                    }
                    $maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                    break;
                case 'down':

                    if ($_SESSION['pos'][0] < count($maze) - 1 && $maze[$_SESSION['pos'][0] + 1][$_SESSION['pos'][1]] != 2) {
                        $_SESSION['pos'] = [$_SESSION['pos'][0] + 1, $_SESSION['pos'][1]];
                        if ($maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 3) {
                            echo ("<p> You win </p>");
                            $_SESSION['game_over'] = true;
                        }
                    }

                    $maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                    break;
                case 'left':
                    if ($_SESSION['pos'][1] > 0 && $maze[$_SESSION['pos'][0]][$_SESSION['pos'][1] - 1] != 2) {
                        $_SESSION['pos'] = [$_SESSION['pos'][0], $_SESSION['pos'][1] - 1];
                        if ($maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 3) {
                            echo ("<p> You win </p>");
                            $_SESSION['game_over'] = true;
                        }
                    }
                    $maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                    break;
                case 'right':
                    if ($_SESSION['pos'][1] < count($maze[$_SESSION['pos'][0]]) - 1 && $maze[$_SESSION['pos'][0]][$_SESSION['pos'][1] + 1] != 2) {
                        $_SESSION['pos'] = [$_SESSION['pos'][0], $_SESSION['pos'][1] + 1];
                        if ($maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] == 3) {
                            echo ("<p> You win </p>");
                            $_SESSION['game_over'] = true;
                        }
                    }
                    $maze[$_SESSION['pos'][0]][$_SESSION['pos'][1]] = 1;
                    break;
                default:
                    # code...
                    break;
            }
            for ($i = 0; $i < count($maze); $i++) {
                for ($j = 0; $j < count($maze[$i]); $j++) {
                    if ($maze[$i][$j] == 2 && !($i == $_SESSION['pos'][0] && $j == $_SESSION['pos'][1] - 1) && !($i == $_SESSION['pos'][0] && $j == $_SESSION['pos'][1] + 1) && !($i == $_SESSION['pos'][0] - 1 && $j == $_SESSION['pos'][1]) && !($i == $_SESSION['pos'][0] + 1 && $j == $_SESSION['pos'][1])) {
                        $maze[$i][$j] = 4;
                    }
                    if ($maze[$i][$j] == 0 && !($i == $_SESSION['pos'][0] && $j == $_SESSION['pos'][1] - 1) && !($i == $_SESSION['pos'][0] && $j == $_SESSION['pos'][1] + 1) && !($i == $_SESSION['pos'][0] - 1 && $j == $_SESSION['pos'][1]) && !($i == $_SESSION['pos'][0] + 1 && $j == $_SESSION['pos'][1])) {
                        $maze[$i][$j] = 4;
                    }
                    if ($maze[$i][$j] == 3 && !($i == $_SESSION['pos'][0] && $j == $_SESSION['pos'][1] - 1) && !($i == $_SESSION['pos'][0] && $j == $_SESSION['pos'][1] + 1) && !($i == $_SESSION['pos'][0] - 1 && $j == $_SESSION['pos'][1]) && !($i == $_SESSION['pos'][0] + 1 && $j == $_SESSION['pos'][1])) {
                        $maze[$i][$j] = 4;
                    }
                }
            }
        }
    }

    ?>
    <form method="post" action="">
        <input type="submit" name="move" value="up">
        <input type="submit" name="move" value="down">
        <input type="submit" name="move" value="left">
        <input type="submit" name="move" value="right">
        <input type="submit" name="reset" value="reset">

    </form>
    <table>
        <?php
        $x = $_SESSION['pos'][0];
        $y = $_SESSION['pos'][1];
        foreach ($maze as $row) {
            echo ('<tr>');
            foreach ($row as $value) {
                if ($value == 0) {
                    echo ('<td><img src="./images/empty.png" alt="Empty"></td>');
                } elseif ($value == 1) {
                    echo ('<td><img src="./images/player.jpg" alt="Wall"></td>');
                } elseif ($value == 2) {
                    echo ('<td><img src="./images/wall2.jpg" alt="Visit"></td>');
                } elseif ($value == 3) {
                    echo ('<td><img src="./images/MickeyMouse.jpg" alt="End"></td>');
                } elseif ($value == 4) {
                    echo ('<td><img src="./images/smoke.png" alt="End"></td>');
                }
            }
            echo ('<tr>');
        }

        ?>
    </table>


</body>

</html>