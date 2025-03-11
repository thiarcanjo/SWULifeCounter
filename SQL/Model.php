<?php
namespace SQL;

/**
* Classe abstrata Modelo para entidades do DB
*/
abstract class Model
{
  /**
  * Objeto DAO para acesso ao BD
  */
  public $dao;

  /**
  * Linhas retornadas do BD
  */
  public array $rows;

  /**
  * Retorna a quantidade de linhas no banco
  * @return integer
  */
  public function countRows()
  {
     $stmt = $this->dao->select();
     $rowsCount = $stmt->rowCount();
     $stmt->closeCursor();
     return $rowsCount ?? 0;
  }

}
?>
