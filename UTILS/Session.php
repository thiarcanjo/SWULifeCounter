<?php
namespace UTILS;
use \SQL\Premier;

class Session
{
   /**
    * Inicia a SESSION
    */
   private static function init()
   {
        if (session_status() == 1) session_start();
   }

   /**
    * CREATE A Premier Game
    * @return Premier
    */
    public static function start()
    {
        self::init();
        if(!isset($_SESSION['premier_id'])){
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
    * GET Premier ID
    */
    public static function getPremierID()
    {
        if (isset($_SESSION['premier_id'])) {
            return $_SESSION['premier_id'];
        } else {
            error_log("Premier ID não encontrado na sessão. ID da sessão: " . session_id());
            return false;
        }
    }

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