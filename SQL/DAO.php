<?php
namespace SQL;
use \PDO;

# DB
define("DB_HOST","thiagoarcanjo.com.br");
define("DB_USER","thiag803_swu");
define("DB_PASS","TEp%V#iF_@6T");
define("DB_NAME","thiag803_swumatchup");
define("DB_PORT","3306");

class DAO{
  /**
  * Conexão com o BD
  */
  public $connection;

  /**
   * Tabela do BD
   */
  private $table;

  /**
  * Chaves estrangeiras
  */
  private $foreignKeys;

  /**
  * Define a tabela e instancia e conexão
  * @param string $table
  * @param array $from (para tabelas com dependencias)
  */
   public function __construct($table, $foreignKeys = null)
   {
      $this->table = $table;
      $this->foreignKeys = ($foreignKeys) ?? '';
      $this->setConnection();
  }

   /**
   * Método responsável por criar uma conexão com o banco de dados
   */
   private function setConnection()
   {
      try
      {
         $dsn = "mysql:host=".DB_HOST.':'.DB_PORT.";dbname=".DB_NAME;
         $this->connection = new PDO($dsn, DB_USER, DB_PASS);
         $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      }catch(PDOException $e)
      {
         self::closeConnection();
         die('ERROR: '.$e->getMessage());
      }
   }

  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute($query,$params = []){
    try{
      error_log("\nMYSQL: ".$query);

      $stmt = $this->connection->prepare($query);
      $stmt->execute($params);

      return $stmt;
    }catch(PDOException $e){
      self::closeConnection();
      die('ERROR: '.$e->getMessage());
    }

  }

  /**
   * Fecha a conexão com o BD
   */
   private function closeConnection()
   {
      $this->connection = null;
      unset($this->connection);
   }

  /**
   * Método responsável por executar uma consulta no banco
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @param  string $from
   * @return PDOStatement
   */
  public function select($where = null, $order = null, $limit = null, $fields = '*',$debug = false){
    //DADOS DA QUERY
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    //VERIFICA se tem foreignKeys e formata o JOIN
    $fk_join = '';
    if(!empty($this->foreignKeys))
    {
      $asTable = substr($this->table, 0,1);
      $from = $this->table.' AS '.$asTable;
      $fields = $asTable.'.'.$fields;
      foreach($this->foreignKeys as $table=>$fk)
      {
         $asFkTable = substr($table, 0,1);
         $fields .= ', '.$asFkTable.'.*';
         $fk_join .= ' JOIN '.$table.' AS '.$asFkTable.' ON '.$asTable.'.'.$fk.' = '.$asFkTable.'.id ';
      }
    }
    else $from = $this->table;

    //MONTA A QUERY
    $query = 'SELECT '.$fields.' FROM '.$from.' '.$fk_join.' '.$where.' '.$order.' '.$limit;

    //DEBUG
    if($debug) return $query;

    //EXECUTA A QUERY
    $stmt = $this->execute($query);
    return $stmt;
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($values,$last_id = true){
    //DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    //MONTA A QUERY
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    //EXECUTA O INSERT
    $stmt = $this->execute($query,array_values($values));
    if($last_id) $id = $this->connection->lastInsertId();
    else $id = true;
    $stmt->closeCursor();

    return $id;
  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    //EXECUTAR A QUERY
    $stmt = $this->execute($query,array_values($values));
    $stmt->closeCursor();

    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where){
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECUTA A QUERY
    $stmt = $this->execute($query);
    $stmt->closeCursor();

    //RETORNA SUCESSO
    return true;
  }


}

?>
