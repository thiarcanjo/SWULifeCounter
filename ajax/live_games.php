<?php
require_once __DIR__.'/../UTILS/autoload.php';
use \SQL\Entity\Premier;
use \SQL\Entity\PremierLive;
use \SQL\Entity\Store;
use \UTILS\Session;
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);

// AJAX response for LIVE GAMES
if(isset($_GET['store'])){
    if($Stores = new Store()){
        if($Stores->getAllRows()){
            $return = array();

            foreach($Stores->rows as $Store){
                $return[] = $Store;
            }
            echo json_encode($return);
        }
        else echo json_encode(array('error' => 'ERROR ON STORE List'));
    }
    else echo json_encode(array('error' => 'ERROR ON GET STORE ROWS'));
}
elseif(isset($_GET['list_games'])){
    if($PremierLive = new PremierLive()){
        if($PremierLive->getAllRows()){
            if($PremierLive->clearOldGames()) $PremierLive->getAllRows();
            
            if(!empty($_GET['list_games'])){
                $Store = new Store();
                $Store = $Store->getByCode($_GET['list_games']);
                if($Store){
                    $where = "Store LIKE '".$Store->code."'";
                    $PremierLive->getAllRows($where);
                }
            }
            $return = array();

            foreach($PremierLive->rows as $Premier){
                $return[] = $Premier;
            }
            echo json_encode($return);
        }
        else echo json_encode(array('error' => 'ERROR ON LIST'));
    }
    else echo json_encode(array('error' => 'ERROR ON GET ROWS'));
}
elseif (isset($_GET['update_lifes'])) {
    if ($PremierLive = new PremierLive()) {
        if ($PremierLive->getAllRows()) { // Ou um método específico para obter apenas as vidas
            $return = array();
            foreach ($PremierLive->rows as $Premier) {
                $return[] = array(
                    'premier_id' => $Premier->premier_id,
                    'life' => array($Premier->life[0], $Premier->life[1])
                );
            }
            echo json_encode($return);
        }
        else echo json_encode(array('error' => 'Erro ao obter vidas.'));
    }
    else echo json_encode(array('error' => 'Erro ao criar PremierLive.'));
}
elseif (isset($_GET['update_epics'])) {
    if ($PremierLive = new PremierLive()) {
        if ($PremierLive->getAllRows()) { // Ou um método específico para obter apenas as vidas
            $return = array();
            foreach ($PremierLive->rows as $Premier) {
                $return[] = array(
                    'premier_id' => $Premier->premier_id,
                    'base_epic' => array($Premier->base_epic[0], $Premier->base_epic[1]),
                    'leader_epic' => array($Premier->leader_epic[0], $Premier->leader_epic[1])
                );
            }
            echo json_encode($return);
        }
        else echo json_encode(array('error' => 'Erro ao obter EPICs.'));
    }
    else echo json_encode(array('error' => 'Erro ao criar PremierLive.'));
}
else{
    $msg = "AJAX SESSION no GETs";
    if(!headers_sent()){
        header("HTTP/1.1 400 Bad Request");
    }
    error_log($msg);
    echo json_encode(array('error' => $msg));
}
?>