<?php
require_once __DIR__.'/UTILS/autoload.php';
use \SQL\Entity\Premier;
use \UTILS\Session;
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);
define('URL', getenv('URL'));
define('APP_NAME', getenv('APP_NAME'));

if(isset($_GET['session'])){
    if(!(Session::close())) header("HTTP/1.1 400 Bad Request");
}
elseif(Session::start()){// NO AJAX
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
    <link rel="stylesheet" href="./css/premier.css">
    <link rel="stylesheet" href="./css/counter.css">
    <link rel="stylesheet" href="./css/sizes.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/solid.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
    <title><?=APP_NAME;?> - Premier</title>
</head>
<body>
    <main>
        <div class="top-menu">
            <div class="go-home w2" onclick="goHome();">
                <span class="fa fa-home"></span><span>BEGIN</span>
            </div>
            <div class="clock w6"><span class="fa fa-clock"></span><div id="clock"></div></div>
            <div class="id w2" id="premier_id"><?= Session::getPremierID(); ?></div>
        </div>
        <div class="main-container">
            <div id="player_1" class="player_div">
                <div class="count w10"></div>
                <div class="leader_data"></div>
            </div>
            <div id="player_2" class="player_div">
                <div class="count w10"></div>
                <div class="leader_data"></div>
            </div>
            <div class="game-buttons">
                <span class="btn reset" href="#" onclick="resetScore();">
                    <i class="fa fa-redo"></i>
                </span>
            </div>
        </div>
    </main>
    <footer>
        <p>
            SWU Lifecounter is an unofficial fan site. All imagens and Text from CARDS and about Star Wars: Unlimited, including card images and aspect symbols, is copyright Fantasy Flight Publishing Inc and Lucasfilm Ltd.
            <br>
            All other content © 2025 - SWU: Life Counter - Developed by Arcanjo
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nosleep/0.12.0/NoSleep.min.js"></script>
    <script src="./js/default.js"></script>
    <script src="./js/counter.js"></script>
    <script src="./js/ajax.js"></script>
    <script src="./js/clock.js"></script>
    <?php
    if(isset($_GET['size'])) echo "<script>getWindowSize();</script>";
    ?>
</body>

<?php
}
?>