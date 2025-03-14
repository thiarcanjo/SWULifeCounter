<?php
require_once __DIR__.'/UTILS/autoload.php';
use \SQL\Premier;
use \SQL\PremierLive;
use \UTILS\Session;

// CLEAR OLD GAMES
if($PremierLive = new PremierLive()){
    if($PremierLive->getAllRows()){
        $return = array();
        $dataAtual = new DateTime(); // Obtém a data e hora atual como objeto DateTime
        $dataLimite = $dataAtual->modify('-3 hours'); // Subtrai 3 horas

        foreach($PremierLive->rows as $Premier){
            $dataPremier = new DateTime($Premier->datetime);
            if ($dataPremier < $dataLimite) {
                $premier_id = $Premier->premier_id;
                if($Premier->delete()) echo "<br>REGISTRO ".$premier_id." APAGADO.";
            }
        }
    }
}
?>