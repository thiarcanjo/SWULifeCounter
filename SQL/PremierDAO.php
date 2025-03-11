<?php
namespace SQL;
use \SQL\Premier;
use \SQL\DAO;
use \PDO;

class PremierDAO
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
      $this->dao = new DAO('premier');
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

  /**
  * Método responsável por inserir dados no banco
  * @param  Premier $entity
  * @return boolean
   */
  public function insert(Premier $entity)
  {
     $values['premier_id']    = $entity->premier_id;
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

     return $this->dao->insert($values);
  }

  /**
  * Método responsável por atualizar dados no banco
  * @param  Premier $entity
  * @return boolean
   */
  public function update(Premier $entity)
  {
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

      $where = 'premier_id LIKE "'.$entity->premier_id.'"';

      return $this->dao->update($where, $values);
  }

   /**
   * Método responsável por excluir dados do banco
   * @param  integer $id
   * @return boolean
   */
   public function delete(int $id)
   {
      $where = 'premier_id LIKE "'.$entity->premier_id.'"';

      return $this->dao->delete($where);
   }
}
?>
