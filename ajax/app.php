<?php
require_once __DIR__.'/../UTILS/autoload.php';
use \SQL\Entity\Premier;
use \SQL\Entity\Aspect;
use \SQL\Entity\Card;
use \SQL\Entity\Collection;
use \UTILS\Session;
use \UTILS\ENV;

// LOAD GLOBAL VARS
ENV::load(__DIR__);

//AJAX response for APP

    // AJAX response for APP
    if(isset($_GET['player'])){
        if(Session::start()){
            // PREMIER Object
            if($premier_id = Session::getPremierID()){
                $Premier = new Premier(['premier_id' => $premier_id]);
                $objPremier = $Premier->getById($Premier->premier_id);
                
                if($objPremier instanceof Premier) $Premier->set($objPremier);
                
                if($Premier instanceof Premier){
                    if(isset($_GET['base']) && isset($_GET['leader'])){ // SET BASE and LEADER
                        if(isset($_GET['store']) && !empty($_GET['store'])) Session::setStore($_GET['store']);
                        else Session::setStore();
                        $Premier->setPlayer($_GET['player'], $_GET['base'], $_GET['leader'], $_GET['playerName']);
                        

                        if ($Premier->save($objPremier)){
                            return true;
                        }
                        else{
                            $msg = "ERROR ON DB INSERT PROCESS";
                            if(!headers_sent()){
                                header("HTTP/1.1 400 Bad Request");
                            }
                            error_log($msg);
                            echo $msg;
                        }
                    }
                    elseif(isset($_GET['update']) && isset($_GET['value'])){ // UPDATE Live game
                        switch($_GET['update']){
                            case 'base_life':
                                if($Premier->updateGame($_GET['player'], (int) $_GET['value'])){ // UPDATE base_life
                                    return true;
                                }
                                else{
                                    $msg = "ERROR ON DB BASE LIFE UPDATE PROCESS";
                                    if(!headers_sent()){
                                        header("HTTP/1.1 400 Bad Request");
                                    }
                                    error_log($msg);
                                    echo $msg;
                                }
                                break;
                            case 'base':
                                if($Premier->updateGame($_GET['player'], null, $_GET['value'])){ // UPDATE base_epic
                                    return true;
                                }
                                else{
                                    $msg = "ERROR ON DB BASE EPIC ACTIN USED";
                                    if(!headers_sent()){
                                        header("HTTP/1.1 400 Bad Request");
                                    }
                                    error_log($msg);
                                    echo $msg;
                                }
                                break;
                            case 'leader':
                                if($Premier->updateGame($_GET['player'], null, null, $_GET['value'])){ // UPDATE leader_epic
                                    return true;
                                }
                                else{
                                    $msg = "ERROR ON DB BASE EPIC ACTIN USED";
                                    if(!headers_sent()){
                                        header("HTTP/1.1 400 Bad Request");
                                    }
                                    error_log($msg);
                                    echo $msg;
                                }
                                break;
                            case 'historic':
                                $oldHistoric = $Premier->getHistoric(); // GET old historic
                                $oldHistoric .= "<br>- Player 1 (".$Premier->playerName[0]."): " . $_GET['base1'] . "<br>- Player 2 (".$Premier->playerName[1]."): " . $_GET['base2'] . "<br> ----------";
                                if($Premier->updateGame($_GET['player'], null, null, null, $oldHistoric)){ // UPDATE historic
                                    return true;
                                }
                                else{
                                    $msg = "ERROR ON DB BASE EPIC ACTIN USED";
                                    if(!headers_sent()){
                                        header("HTTP/1.1 400 Bad Request");
                                    }
                                    error_log($msg);
                                    echo $msg;
                                }
                                break;
                            default:
                                $msg = "ERROR - NO OPTION FOR UPDATE";
                                if(!headers_sent()){
                                    header("HTTP/1.1 400 Bad Request");
                                }
                                error_log($msg);
                                echo $msg;
                        }
                    }
                    elseif(isset($_GET['historic'])){
                        $return = $Premier->getHistoric();
                        echo json_encode($return);
                    }
                    else{
                        $msg = "ERROR ON DB UPDATE PROCESS";
                        if(!headers_sent()){
                            header("HTTP/1.1 400 Bad Request");
                        }
                        error_log($msg);
                        echo $msg;
                    }
                }
                else{
                    $msg = "ERROR ON PREMIER OBJECT";
                    if(!headers_sent()){
                        header("HTTP/1.1 400 Bad Request");
                    }
                    error_log($msg);
                    echo $msg;
                }
            }
            else{
                $msg = "ERROR, Premier não encontrado na sessão";
                if(!headers_sent()){
                    header("HTTP/1.1 400 Bad Request");
                }
                error_log($msg);
                echo $msg;
            }
        }
        else{
            $msg = "ERROR, SESSION not initialized";
            if(!headers_sent()){
                header("HTTP/1.1 400 Bad Request");
            }
            error_log($msg);
            echo $msg;
        }
    }
    elseif(isset($_GET['card'])){
        $Card = new Card();
        if(!empty($_GET['type']) && ($_GET['type']=='base' || $_GET['type']=='leader')){
            $return = $Card->getAll($_GET['type']);

            echo json_encode($return);
        }
        else{
            $return = $Card->getByCode($_GET['card'],true);

            if($return){
                if (!empty($Card->Collection) && empty($Card->img)) {
                    $Card->img = "https://swudb.com/images/cards/".$Card->Collection->code."/".$Card->number.".png";
                    $collectionName = $Card->Collection->code;
                    $imageUrl = $Card->img;
                    $basePath = 'imgs/cards/';
                    $collectionPath = $basePath . $collectionName;
                    $ajaxPath = '../' . $collectionPath;
                    
                    // Garante que a pasta da coleção exista
                    if (!is_dir($ajaxPath)) {
                        mkdir($ajaxPath, 0755, true);
                    }

                    // Extrai o nome do arquivo da URL
                    $filename = basename(parse_url($imageUrl, PHP_URL_PATH));
                    $savePath = $ajaxPath . '/' . $filename;

                    // SAVE Card img on DB
                    $Card->img = $collectionPath. '/' . $filename;
                    $Card->save($Card);

                    // CHECK IF CARD IMAGE ALREADY EXISTS
                    if (!file_exists($savePath)) {
                        $imageContent = @file_get_contents($imageUrl);
                        if ($imageContent !== false) {
                            if (file_put_contents($savePath, $imageContent)) {
                                error_log("IMAGE SAVED: " . $savePath);
                            } else {
                                error_log("ERROR on SAVE CARD IMAGE: " . $savePath);
                            }
                        } else {
                            error_log("ERROR ON DOWNLOAD CARD IMAGE: " . $imageUrl);
                        }
                    } else {
                        error_log("CARD ALREADY SAVED: " . $Card->img);
                    }
                    
                    $return['img'] = $Card->img;
                }

                echo json_encode($return);
            }
            else echo json_encode(array('error' => 'ERROR ON GET CARD ROWS'));
        }
    }
    elseif(isset($_GET['sessionData'])){
        if(empty(Session::getPremierID())){
            if(Session::start()){
                error_log("AJAX SESSION ID NEW: ".Session::getPremierID());
                if(!empty(Session::getPremierID())) $SessionData['id'] = Session::getPremierID();
                if(!empty(Session::getStore())) $SessionData['store'] = Session::getStore();
            }
        }
        else{
            error_log("AJAX SESSION ID OLD: ".Session::getPremierID());
            if(!empty(Session::getPremierID())) $SessionData['id'] = Session::getPremierID();
            if(!empty(Session::getStore())) $SessionData['store'] = Session::getStore();    
        }

        echo json_encode($SessionData);
    }
    else{
        $msg = "AJAX SESSION no GETs";
        if(!headers_sent()){
            header("HTTP/1.1 400 Bad Request");
        }
        error_log($msg);
        echo $msg;
    }
?>