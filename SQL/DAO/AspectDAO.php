<?php
namespace SQL\DAO;
use \SQL\Entity\Aspect;
use \SQL\DAO\DAO;
use \PDO;

class AspectDAO
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
      $this->table = 'aspect';

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
    * INSERT Aspect on DB
    * @param  Aspect $entity
    * @return boolean
    */
   public function insert(Aspect $entity)
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
         error_log("INSERT ERROR Aspect: " . $e->getMessage());
         return false;
      }
   }

   /**
    * UPDATE Aspect on DB
    * @param  Aspect $entity
    * @return boolean
    */
   public function update(Aspect $entity)
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
         error_log("UPDATE ERROR Aspect: " . $e->getMessage());
         return false;
      }
   }

   /**
    * DELETE a Aspect from DB
    * @param Aspect $entity
    * @return boolean
    */
   public function delete(Aspect $entity)
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
         error_log("UPDATE ERROR Aspect: " . $e->getMessage());
         return false;
      }
   }
}
?>
