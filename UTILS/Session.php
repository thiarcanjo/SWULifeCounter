<?php
namespace UTILS;
use \SQL\Entity\Premier;
use \SQL\Entity\Store;

class Session
{
    /**
     * BEGIN a SESSION
     */
    private static function init()
    {
        if (session_status() == 1) session_start();
    }

    /**
     * CREATE A Premier Game
     * @return Premier
     */
    public static function start($live = false)
    {
        self::init();
        if(!isset($_SESSION['premier_id']) && !($live)){
            try {
                $Premier = new Premier();
                $_SESSION['premier_id'] = $Premier->premier_id;
                return true;
            } catch (Exception $e) {
                error_log("Erro ao criar Premier: " . $e->getMessage());
                return false;
            }
        }
        else {
            return true;
        }
    }

    /**
     * SET Store Game
     * 
     * @return boolean
     */
    public static function setStore($store = null)
    {
        self::init();
        if($store !== null){
            try {
                $Store = new Store();
                $Store = $Store->getByCode($store);
                $_SESSION['store'] = $Store->code;
                return true;
            } catch (Exception $e) {
                error_log("Erro ao setar Store: " . $e->getMessage());
                return false;
            }
        }
        else unset($_SESSION['store']);
    }

    /**
     * GET Store
     */
    public static function getStore()
    {
        if (isset($_SESSION['store'])) {
            return $_SESSION['store'];
        } else {
            return null;
        }
    }

    /**
     * GET Premier ID
     */
    public static function getPremierID()
    {
        if (isset($_SESSION['premier_id'])) {
            return $_SESSION['premier_id'];
        } else {
            return false;
        }
    }

    /**
     * CLOSE a SESSION
     */
    public static function close()
    {
        if (session_status() == 2) {
            if (!headers_sent()) {
                if(session_destroy()){
                    unset($_SESSION['premier_id']);
                    return true;
                }
                else{
                    error_log("ERROR ao destruir a sessão.");
                    return false;
                }
            }
            else{
                error_log("Headers já enviados, não é possível destruir a sessão.");
                return false;
            }
        }
        else{
            return true;
        }
    }
}
?>