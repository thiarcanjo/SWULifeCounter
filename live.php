<?php
require_once __DIR__.'/UTILS/autoload.php';
use \SQL\Entity\Premier;
use \UTILS\Session;
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);

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
        <div class="store w10">
            <label for="store">
                <select id="store">
                    <option value="">SELECT A STORE IF YOU WISH</option>
                </select>
            </label>
        </div>
        <div id="list_games" class="w10">
            <table class="w10">
                <thead>
                    <tr>
                        <th rowspan="2">ID</th>
                        <th colspan="3">Player 1</th>
                        <th rowspan="2"> X </th>
                        <th colspan="3">Player 2</th>
                    </tr>
                    <tr>
                        <th>Base</th>
                        <th>Leader</th>
                        <th>Life</th>
                        <th>Life</th>
                        <th>Leader</th>
                        <th>Base</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
    <script src="./js/default.js"></script>
    <script src="./js/app.js"></script>
    <script src="./js/bd.js"></script>
    <script src="./js/live.js"></script>
</body>