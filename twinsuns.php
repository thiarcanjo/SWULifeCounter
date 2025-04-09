<?php
require_once __DIR__.'/UTILS/autoload.php';
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);
define('URL', getenv('URL'));
define('APP_NAME', getenv('APP_NAME'));
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
    <link rel="stylesheet" href="./css/twinsuns.css">
    <link rel="stylesheet" href="./css/counter.css">
    <link rel="stylesheet" href="./css/sizes.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/solid.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
    <title><?=APP_NAME;?> - Twinsuns</title>
</head>
<body>
    <main>
        <div class="top-menu w10">
            <div class="go-home w2" onclick="goHome();">
                <span class="fa fa-home"></span><span>BEGIN</span>
            </div>
            <div class="clock w6"><span class="fa fa-clock"></span><div id="clock"></div></div>
        </div>
        <div class="main-container">
            <div class="row w10 h5 rot">
                <div id="player_3" class="player_div w5 h10">
                    <div class="number"><p>3</p></div>
                    <div class="row w10 h8">
                        <div class="leader_data w2 h10"></div>
                        <div class="count w6 h10"></div>
                    </div>
                    <div class="row w10 h2">
                        <div class="base_data w8 h10"></div>
                        <div id="token_player_3" class="token w2 h10"></div>
                    </div>
                </div>
                <div id="player_4" class="player_div w5 h10">
                    <div class="number"><p>4</p></div>
                    <div class="row w10 h8">
                        <div class="count w6 h10"></div>
                        <div class="leader_data w2 h10"></div>
                    </div>
                    <div class="row w10 h2">
                        <div id="token_player_4" class="token w2 h10"></div>
                        <div class="base_data w8 h10"></div>
                    </div>
                </div>
            </div>
            <div class="row w10 h5">
                <div id="player_1" class="player_div w5 h10">
                    <div class="number"><p>1</p></div>
                    <div class="row w10 h8">
                        <div class="leader_data w2 h10"></div>
                        <div class="count w6 h10"></div>
                    </div>
                    <div class="row w10 h2">
                        <div class="base_data w8 h10"></div>
                        <div id="token_player_1" class="token w2 h10"></div>
                    </div>
                </div>
                <div id="player_2" class="player_div w5 h10">
                    <div class="number"><p>2</p></div>
                    <div class="row w10 h8">
                        <div class="count w6 h10"></div>
                        <div class="leader_data w2 h10"></div>
                    </div>
                    <div class="row w10 h2">
                        <div id="token_player_2" class="token w2 h10"></div>
                        <div class="base_data w8 h10"></div>
                    </div>
                </div>
            </div>
            <div class="ts_buttons" id="ts_buttons">
                <span class="btn clear" href="#" onclick="clearTokens();">
                    <i class="fa fa-redo fa-2x"></i>
                </span>
                <button class="btn btn-blast" onclick="getToken(this);">
                    <img src="./imgs/tokens/blast.png" alt="Deal 1 damage to enemy bases">
                </button>
                <button class="btn btn-plan" onclick="getToken(this);">
                    <img src="./imgs/tokens/plan.png" alt="Draw a card">
                </button>
                <button class="btn btn-initiative" onclick="getToken(this);">
                    <img src="./imgs/tokens/initiative.png" alt="Take initiative">
                </button>
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
    <script src="./js/twinsuns.js"></script>
    <script src="./js/clock.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>