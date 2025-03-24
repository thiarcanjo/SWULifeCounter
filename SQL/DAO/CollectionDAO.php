<?php
namespace SQL\DAO;
use \SQL\Entity\Collection;
use \SQL\DAO\DAO;
use \PDO;

class CollectionDAO
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
      $this->table = 'collection';

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

   /**
    * INSERT Collection on DB
    * @param  Collection $entity
    * @return boolean
    */
   public function insert(Collection $entity)
   {
      $values['code']   = $entity->code;
      $values['name']   = $entity->name;
      $values['img']    = $entity->img;

      try {
         $this->dao->beginTransaction();
         $this->setTable();
         $this->dao->insert($values);
         $this->dao->commit();
         return true;
      }
      catch (\PDOException $e) {
         error_log("INSERT ERROR Collection: " . $e->getMessage());
         return false;
      }
   }

   /**
    * UPDATE Collection on DB
    * @param  Collection $entity
    * @return boolean
    */
   public function update(Collection $entity)
   {
      $values['name']   = $entity->name;
      $values['img']    = $entity->img;

      $where = 'code LIKE "'.$entity->getCode().'"';

      try {
         $this->dao->beginTransaction();
         $this->setTable();
         $this->dao->update($where, $values);
         $this->dao->commit();
         return true;
      }
      catch (\PDOException $e) {
         error_log("UPDATE ERROR Collection: " . $e->getMessage());
         return false;
      }
   }

   /**
    * DELETE a Collection from DB
    * @param Collection $entity
    * @return boolean
    */
   public function delete(Collection $entity)
   {
      $where = 'code LIKE "'.$entity->getCode().'"';
      
      try {
         $this->dao->beginTransaction();
         $this->setTable();
         $this->dao->delete($where);
         $this->dao->commit();
         return true;
      }
      catch (\PDOException $e) {
         error_log("UPDATE ERROR Collection: " . $e->getMessage());
         return false;
      }
   }
}
?>
