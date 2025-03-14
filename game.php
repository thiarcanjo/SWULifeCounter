<?php
require_once __DIR__.'/UTILS/autoload.php';
use \SQL\Premier;
use \UTILS\Session;

if(isset($_GET['id'])){
    $Premier = new Premier(['premier_id' => $_GET['id']]);
    $Premier->set($Premier->getById($Premier->premier_id));
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
                    <div class="leader-img player_1_leader" style='background-image: url("https://swudb.com/images/cards/<?=getCodeNumber($Premier->leader[0],0);?>/<?=getCodeNumber($Premier->leader[0],1);?>.png");'></div>
                </div>
                <div class="base-img player_1_base" style='background-image: url("https://swudb.com/images/cards/<?=getCodeNumber($Premier->base[0],0);?>/<?=getCodeNumber($Premier->base[0],1);?>.png");'></div>
                <div class="player_1_life life"><?=$Premier->life[0];?></div>
            </div>
            <div class="player_2 w10 h5" id="">
                <div class="leader">
                    <div class="leader-img player_2_leader" style='background-image: url("https://swudb.com/images/cards/<?=getCodeNumber($Premier->leader[1],0);?>/<?=getCodeNumber($Premier->leader[1],1);?>.png");'></div>
                </div>
                <div class="base-img player_2_base" style='background-image: url("https://swudb.com/images/cards/<?=getCodeNumber($Premier->base[1],0);?>/<?=getCodeNumber($Premier->base[1],1);?>.png");'></div>
                <div class="player_2_life life"><?=$Premier->life[1];?></div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./js/default.js"></script>
    <script src="./js/bd.js"></script>
    <script src="./js/live.js"></script>
</body>

<?php

function getCodeNumber($codeNumber,$id = null){
    $return = [];
    if (preg_match('/([A-Z]+)(\d+)/', $codeNumber, $matches)) {
        $return[] = $matches[1];
        $return[] = $matches[2];
    }

    if($id !== null) return $return[$id];
    else $return;
}
?>