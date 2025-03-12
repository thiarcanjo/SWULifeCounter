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
        if (session_status() == 1) {
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
        if(!isset($_SESSION['premier_id'])){
            try {
                $Premier = new Premier();
                $_SESSION['premier_id'] = $Premier->premier_id;
                error_log("Premier ID criado e armazenado na sessão. ID da sessão: " . session_id() . ", premier_id: " . $_SESSION['premier_id']);
                return true;
            } catch (Exception $e) {
                error_log("Erro ao criar Premier: " . $e->getMessage());
                return false;
            }
        }
        else {
            error_log("Premier ID já existe na sessão. ID da sessão: " . session_id() . ", premier_id: " . $_SESSION['premier_id']);
            return true;
        }
    }

   /**
    * GET Premier ID
    */
    public static function getPremier()
    {
        self::init();
        if (isset($_SESSION['premier_id'])) {
            try {
                $Premier = new Premier($_SESSION['premier_id']); // Cria um novo Premier com o ID da sessão
                error_log("Premier criado com ID da sessão. ID da sessão: " . session_id() . ", premier_id: " . $_SESSION['premier_id']);
                return $Premier;
            } catch (Exception $e) {
                error_log("Erro ao criar Premier com ID da sessão: " . $e->getMessage());
                return false;
            }
        } else {
            error_log("Premier ID não encontrado na sessão. ID da sessão: " . session_id());
            return false;
        }
    }

    public static function close()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
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
            error_log("Sessão não iniciada.");
            return true;
        }
    }
}
?>