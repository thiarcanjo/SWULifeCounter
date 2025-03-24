<?php
namespace SQL\DAO;
use \SQL\Entity\Aspect;
use \SQL\Entity\Card;
use \SQL\DAO\DAO;
use \PDO;

class CardAspectDAO
{
   /**
    * Classe DAO
    */
   protected $dao;

   /**
    * DB Table
    */
    protected $table;

   /**
    * DB ForeignKeys
    */
    protected $foreignKeys = null;

   /**
    * Inicializa a conexão com BD e tabela promotion
    */
   public function __construct()
   {
      $this->dao = DAO::getInstance();
      $this->table = 'card_aspects';

      $this->setTable();
   }

   /**
    * FORCE a table and ForeginKeys to use
    */
   private function setTable(){
      $this->dao->setTable($this->table,$this->foreignKeys);
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
      $this->setTable();
      return $this->dao->select($where, $order, $limit, $fields);
   }
}
?>
