<?php
require_once __DIR__.'/UTILS/autoload.php';
use \SQL\Entity\Premier;
use \SQL\Entity\Card;
use \UTILS\Session;
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);

if(isset($_GET['id'])){
    $Premier = new Premier(['premier_id' => $_GET['id']]);
    $Premier->set($Premier->getById($Premier->premier_id));

    // GET INFO PLAYER 1
    $Base1 = new Card();
    $aspects1 = array();
    try {
        $Base1 = $Base1->getByCode($Premier->base[0]);
        foreach($Base1->Aspects as $baseAspect){
            $aspects1[] = $baseAspect;
        }
    } catch (\PDOException $e) {
        error_log("Erro ao buscar BASE: " . $e->getMessage());
    }

    $Leader1 = new Card();
    try {
        $Leader1 = $Leader1->getByCode($Premier->leader[0]);
        foreach($Leader1->Aspects as $leaderAspect){
            $aspects1[] = $leaderAspect;
        }
    } catch (\PDOException $e) {
        error_log("Erro ao buscar LEADER: " . $e->getMessage());
    }

    // GET INFO PLAYER 2
    $Base2 = new Card();
    $aspects2 = array();
    try {
        $Base2 = $Base2->getByCode($Premier->base[1]);
        foreach($Base2->Aspects as $baseAspect){
            $aspects2[] = $baseAspect;
        }
    } catch (\PDOException $e) {
        error_log("Erro ao buscar BASE: " . $e->getMessage());
    }

    $Leader2 = new Card();
    try {
        $Leader2 = $Leader2->getByCode($Premier->leader[1]);
        foreach($Leader2->Aspects as $leaderAspect){
            $aspects2[] = $leaderAspect;
        }
    } catch (\PDOException $e) {
        error_log("Erro ao buscar LEADER: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Permissions-Policy" content="screen-wake-lock=()">
    <link rel="icon" href="./imgs/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/vars.css">
    <link rel="stylesheet" href="./css/default.css">
    <link rel="stylesheet" href="./css/live.css">
    <link rel="stylesheet" href="./css/sizes.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/solid.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
    <title>SWU: Life Counter - LIVE GAMES</title>
</head>
<body>
    <main>
        <div id="<?=$Premier->premier_id;?>" class="game w10 h10">
            <div class="player_1 w10 h5">
                <div class="leader">
                    <div class="leader-img player_1_leader" style='background-image: url("<?=$Leader1->img;?>");'></div>
                    <div class="aspects"><?=printAspects($aspects1);?></div>
                </div>
                <div class="base-img player_1_base" style='background-image: url("<?=$Base1->img;?>");'></div>
                <div class="base-life">
                    <div class="player_1_life life"><?=$Premier->life[0];?></div>
                </div>
            </div>
            <div class="player_2 w10 h5">
                <div class="leader">
                    <div class="leader-img player_2_leader" style='background-image: url("<?=$Leader2->img;?>");'></div>
                    <div class="aspects"><?=printAspects($aspects2);?></div>
                </div>
                <div class="base-img player_2_base" style='background-image: url("<?=$Base2->img;?>");'></div>
                <div class="base-life">
                    <div class="player_2_life life"><?=$Premier->life[1];?></div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./js/default.js"></script>
    <script src="./js/bd.js"></script>
    <script src="./js/live.js"></script>
</body>

<?php

function printAspects(array $aspects){
    $return = '';
    
    foreach($aspects as $aspect){
        $return .= '<div class="aspects-img" ';
        if($aspect->img === null) $return .= 'style="background-image: none;">';
        else $return .= 'style="background-image: url(\''.$aspect->img.'\');"></div>';
    }

    return $return;
}
?>