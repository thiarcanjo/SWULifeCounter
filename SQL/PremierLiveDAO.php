<?php
namespace SQL;
use \SQL\PremierLive;
use \SQL\DAO;
use \PDO;

class PremierLiveDAO
{
   /**
    * Classe DAO
    */
   protected $dao;

   /**
   * Inicializa a conexão com BD e tabela promotion
   */
   public function __construct()
   {
      $this->dao = DAO::getInstance();
      $this->dao->setTable('LiveView');
   }

  /**
   * Retorna dados do BD
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
  public function select($where = null, $order = null, $limit = null, $fields = '*')
  {
     return $this->dao->select($where, $order, $limit, $fields);
  }
}
?>
