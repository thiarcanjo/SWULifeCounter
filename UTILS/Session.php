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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            error_log("Sessão iniciada em Session::init(). ID da sessão: " . session_id());
        } else {
            error_log("Sessão já iniciada em Session::init(). ID da sessão: " . session_id());
        }
   }

   /**
    * CREATE A Premier Game
    * @return Premier
    */
    public static function start()
    {
        self::init();
        error_log("Session::start() chamado. ID da sessão: " . session_id());
        if(!isset($_SESSION['premier'])){
            try {
                $Premier = new Premier();
                $_SESSION['premier'] = $Premier;
                error_log("Premier criado e armazenado na sessão.");
                return true;
            } catch (Exception $e) {
                error_log("Erro ao criar Premier: " . $e->getMessage());
                return false;
            }
        }
        else {
            error_log("Premier já existe na sessão.");
            return true;
        }
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
        self::init();
        error_log("Session::getPremier() chamado. ID da sessão: " . session_id());
        if (isset($_SESSION['premier'])) {
            error_log("Premier encontrado na sessão.");
            return $_SESSION['premier'];
        } else {
            error_log("Premier não encontrado na sessão.");
            return false;
        }
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