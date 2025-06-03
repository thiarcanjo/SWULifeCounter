<?php
namespace SQL\DAO;
use \SQL\Entity\Premier;
use \SQL\Entity\Store;
use \SQL\DAO\DAO;
use \PDO;

class PremierDAO
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
      $this->table = 'premier';
      $this->foreignKeys = ['store' => 'Store'];

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
    * Método responsável por inserir dados no banco
    * @param  Premier $entity
    * @return boolean
    */
   public function insert(Premier $entity)
   {
      $values['premier_id']    = $entity->premier_id;
      $values['player_1']      = $entity->playerName[0];
      $values['player_2']      = $entity->playerName[1];
      $values['base_1']        = $entity->base[0];
      $values['base_2']        = $entity->base[1];
      $values['leader_1']      = $entity->leader[0];
      $values['leader_2']      = $entity->leader[1];
      $values['base_1_life']   = $entity->life[0];
      $values['base_2_life']   = $entity->life[1];
      $values['base_1_epic']   = $entity->base_epic[0];
      $values['base_2_epic']   = $entity->base_epic[1];
      $values['leader_1_epic'] = $entity->leader_epic[0];
      $values['leader_2_epic'] = $entity->leader_epic[1];
      $values['historic']      = $entity->historic;
      $values['datetime']      = $entity->datetime;
      if($entity->Store instanceof Store) $values['Store'] = $entity->Store->code;
      else $values['Store'] = null;

      try {
         $this->dao->beginTransaction();
         $this->setTable();
         $this->dao->insert($values);
         $this->dao->commit();
         return true;
      }
      catch (\PDOException $e) {
         error_log("INSERT ERROR Premier: " . $e->getMessage());
         return false;
      }
   }

   /**
    * Método responsável por atualizar dados no banco
    * @param  Premier $entity
    * @return boolean
    */
   public function update(Premier $entity)
   {
      $values['player_1']      = $entity->playerName[0];
      $values['player_2']      = $entity->playerName[1];
      $values['base_1']        = $entity->base[0];
      $values['base_2']        = $entity->base[1];
      $values['leader_1']      = $entity->leader[0];
      $values['leader_2']      = $entity->leader[1];
      $values['base_1_life']   = $entity->life[0];
      $values['base_2_life']   = $entity->life[1];
      $values['base_1_epic']   = $entity->base_epic[0];
      $values['base_2_epic']   = $entity->base_epic[1];
      $values['leader_1_epic'] = $entity->leader_epic[0];
      $values['leader_2_epic'] = $entity->leader_epic[1];
      $values['historic']      = $entity->historic;
      $values['datetime']      = $entity->datetime;
      if($entity->Store instanceof Store) $values['Store'] = $entity->Store->code;
      else $values['Store'] = 'null';

      $where = 'premier_id LIKE "'.$entity->getID().'"';

      try {
         $this->dao->beginTransaction();
         $this->setTable();
         $this->dao->update($where, $values);
         $this->dao->commit();
         return true;
      }
      catch (\PDOException $e) {
         error_log("UPDATE ERROR Premier: " . $e->getMessage());
         return false;
      }
   }

   /**
    * DELETE a Premier game from DB
    * @param Premier $entity
    * @return boolean
    */
   public function delete(Premier $entity)
   {
      $where = 'premier_id LIKE "'.$entity->getID().'"';
      
      try {
         $this->dao->beginTransaction();
         $this->setTable();
         $this->dao->delete($where);
         $this->dao->commit();
         return true;
      }
      catch (\PDOException $e) {
         error_log("UPDATE ERROR Premier: " . $e->getMessage());
         return false;
      }
   }
}
?>
