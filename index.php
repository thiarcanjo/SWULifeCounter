<?php
require_once __DIR__.'/UTILS/autoload.php';
use \UTILS\ENV;

define('BASEDIR', dirname(__FILE__).'/');

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
    <link rel="icon" href="./imgs/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/vars.css">
    <link rel="stylesheet" href="./css/default.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/solid.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
    <title><?=APP_NAME;?></title>
</head>
<body>
    <header>
        <div class="logo"></div>
        <h1><?=APP_NAME;?></h1>
    </header>
    <main>
        <div class="main-container">
            <div class="form-formatos">
                <form id="SelectBasesLeaders" method="get">
                    <div>
                        <h2>Choose a Format</h2>
                    </div>
                    <div class="formato-option">
                        <input type="radio" id="premier" name="formato" value="premier" onclick="callGame()">
                        <label for="premier">Premier</label>
                    </div>
                    <div class="formato-option">
                        <input type="radio" id="twinsuns" name="formato" value="twinsuns" onclick="callGame()">
                        <label for="twinsuns">TwinSuns</label>
                    </div>
                    <hr>
                    <div class="formato-option">
                        <label for="store">
                            <select id="store">
                                <option value="">SELECT A STORE IF YOU WISH</option>
                            </select>
                        </label>
                    </div>
                    <hr>
                    <div class="formato-option">
                        <a href="about.html" class="btn-link">HOW TO USE</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>
            SWU: Life Counter is an unofficial fan site. All imagens and Text from CARDS and all about Star Wars: Unlimited, including card images and aspect symbols, is copyright Fantasy Flight Publishing Inc and Lucasfilm Ltd.
            <br>
            All other content © 2025 - SWU: Life Counter - Developed by Arcanjo
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./js/default.js"></script>
    <script src="./js/bd.js"></script>
    <script src="./js/app.js"></script>
</body>
</html>