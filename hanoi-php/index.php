<?php
session_start();
require_once './class/game.php';
require_once './class/game_exception.php';

function saveGame($game) {
    $_SESSION['game'] = serialize($game);
}

if(!isset($_SESSION['game'])) {
    $game = new Game();
    $game->init();
} else {
    $game = unserialize($_SESSION['game']);
}

$action = filter_input(INPUT_GET,'command');
if($action == null) $action = 'init';

$source = filter_input(INPUT_GET,'source');
$destination = filter_input(INPUT_GET,'destination');


$error = '';

try {
    switch($action) {
        case 'init':
            $game->init();    
            saveGame($game);    
            $buttonText = "source";
            $buttonName = "source";
            $nextAction = "source";
            break;
        case 'source':
            $buttonText = "destination";
            $buttonName = "destination";
            $nextAction = "destination";
            break;
        case 'destination':
            $buttonText = "source";
            $buttonName = "source";
            $nextAction = "source";
            if($source != null && $destination != null) {
                $game->move($source,$destination);
                saveGame($game);
            }
            $source = null;
            break;
    }
} 
catch(GameException $exp) {
    $error = $exp->getMessage();
}
catch(Exception $exp) {
    die("Error ".$exp->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Hanoi Towers</title>
</head>
<body>
    <div class="container">

        <?php if($game->isOver()):?>
        <div class="game-over">
            <h1>You did it !</h1>
            <p>Congratulations !</p>
        </div>
        <?php endif;?>

        <div class="tower-set">
        <?php
        for($tower=0;$tower<3;$tower++):
        ?>
            <div class="tower-form">
            <?php
                $game->getTower($tower)->draw();
                $enabled = ($game->getTower($tower)->isEmpty() && $nextAction=="source")?'disabled':'enabled';
            ?>
            <form action="#">
                <input type="hidden" name="command" value="<?php echo $nextAction;?>" />
                <?php if(!is_null($source)):?>
                <input type="hidden" name="source" value="<?php echo $source;?>" />
                <?php endif; ?>
                <button type="submit" 
                    name="<?php echo $buttonName;?>" 
                    value="<?php echo $tower+1;?>"
                    <?php echo $enabled;?>
                >
                    <?php echo $buttonText;?>
                </button>
            </form>
            </div>
        <?php
        endfor;
        ?>
        
        </div>
        
        <div class="panel">
            <h1>Hanoi towers</h1>
            <p>Movements : <?php echo $game->getTurn();?></p>
            <form action="#">
                <button type="submit" name="command" value="init">Reset</button>
            </form>
            <?php if($error != ""):?>
            <h2><?php echo $error;?>
            <?php endif;?>
        </div>        
    </div>    
</body>
</html>
