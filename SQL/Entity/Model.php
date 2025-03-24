<?php
namespace SQL\Entity;

/**
* Classe abstrata Modelo para entidades do DB
*/
abstract class Model
{
  /**
   * Objeto DAO para acesso ao BD
   */
  protected $dao;

  /**
   * FETCH Class path
   */
  protected $path_class;

  /**
   * Linhas retornadas do BD
   */
  public array $rows;
  
  /**
   * RETURN number of rows
   * @return integer
   */
  public function countRows()
  {
    $stmt = $this->dao->select();
    $rowsCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsCount ?? 0;
  }

   /**
    * GET All results on DB
    * @param  string $where
    * @param  string $order
    * @param  string $limit
    * @param  string $fields
    */
  public function getAllRows($where = null, $order = null, $limit = null, $fields = '*')
  {
    try{
      $stmt = $this->dao->select($where, $order, $limit, $fields);
      $this->rows = $stmt->fetchAll(PDO::FETCH_CLASS,$this->path_class);
    }
    catch(\PDOException $e) {
      error_log("ERROR on get all rows: " . $e->getMessage());
      return false;
    }
  }

   /**
    * INSERT/UPDATE
    * @param Object $object
    */
  public function save($object = null)
  {
    if(!($object)) return $this->dao->insert($this);
    else return $this->dao->update($this);
  }

   /**
    * DELETE this Object
    */
  public function delete()
  {
    return $this->dao->delete($this);
  }
}
?>
