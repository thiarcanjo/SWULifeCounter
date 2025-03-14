<?php
require_once __DIR__.'/UTILS/autoload.php';
use \SQL\Premier;
use \UTILS\Session;

// AJAX response
if(isset($_GET['player'])){
    if(Session::start()){
        // PREMIER Object
        if($premier_id = Session::getPremierID()){
            $Premier = new Premier(['premier_id' => $premier_id]);
            $objPremier = $Premier->getById($Premier->premier_id);
            if($objPremier instanceof Premier) $Premier->set($objPremier);
            
            if($Premier instanceof Premier){
                if(isset($_GET['base']) && isset($_GET['leader'])){ // SET BASE and LEADER
                    $Premier->setPlayer($_GET['player'], $_GET['base'], $_GET['leader']);
                    
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
                            if($Premier->updateGame($_GET['player'], (int) $_GET['value'])){ // UPDATE counter (base_life, leader_epic, base_epic)
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
                            if($Premier->updateGame($_GET['player'], null, $_GET['value'])){
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
                            if($Premier->updateGame($_GET['player'], null, null, $_GET['value'])){
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
else{
    $msg = "AJAX SESSION no GETs";
    if(!headers_sent()){
        header("HTTP/1.1 400 Bad Request");
    }
    error_log($msg);
    echo $msg;
}
?>