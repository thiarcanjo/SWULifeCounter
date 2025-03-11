<?php
namespace UTILS;
use \SQL\Premier;
use \SQL\PremierDAO;
use \SQL\Model;
use \SQL\DAO;

class Session
{
   /**
    * Inicia a SESSION
    */
   private static function init()
   {
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
        error_log("\nSESSION STARTED\n");
        return true;
    }
    else return false;
   }

   /**
    * CREATE A Premier Game
    * @return Premier
    */
   public static function start()
   {
        // INICIAR A SESSION
        self::init();

        if(!isset($_SESSION['premier'])){
            try {
                $Premier = new Premier();
                $_SESSION['premier'] = $Premier;
                return true;
            } catch (Exception $e) {
                error_log("Erro ao criar Premier: " . $e->getMessage());
                return false;
            }
        }
        else return false;
   }

   /**
    * GET Premier ID
    */
    public static function getPremierID()
    {
        // INICIAR A SESSION
        self::init();

        if(isset($_SESSION["premier"]) && ($_SESSION["premier"] instanceof Premier)) return $_SESSION['premier']->premier_id;
        else return false;
    }

    /**
     * SET Premier
     */
    public static function setPremier($Premier)
    {
        // INICIAR A SESSION
        self::init();

        $_SESSION['premier'] = $Premier;
    }

   /**
    * GET Premier
    */
    public static function getPremier()
    {
        // INICIAR A SESSION
        self::init();

        if(isset($_SESSION["premier"]) && ($_SESSION["premier"] instanceof Premier)) return $_SESSION['premier'];
        else return false;
    }

    public static function close()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            if (!headers_sent()) {
                if(session_destroy()){
                    unset($_SESSION['premier']);
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
            error_log("Sessão não iniciada.");
            return true;
        }
    }
}
?>