<?php
namespace SQL\DAO;
use \PDO;

class DAO{
  /**
  * INSTANCIA com o BD
  */
  private static $instance = null;

  /**
  * Conexão com o BD
  */
  private $connection;

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
  public function __construct()
  {
    $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(){
    try{
      $dsn = "mysql:host=".$_ENV['DB_HOST'].':'.$_ENV['DB_PORT'].";dbname=".$_ENV['DB_NAME'];
      $this->connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    }
    catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  public static function getInstance(){
    if (self::$instance === null) self::$instance = new DAO();
    
    return self::$instance;
  }

  public function setTable($table, $foreignKeys = null){
    $this->table = $table;
    $this->foreignKeys = ($foreignKeys) ?? '';
  }

  /**
   * RETURN connection
   */
  public function getConnection(){
    return $this->connection;
  }

  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute($query,$params = []){
    try{
      if($this->connection){
        // error_log("\nMYSQL: ".$query." - PARAMS: ".implode(",",$params));
        $stmt = $this->connection->prepare($query);
        if($stmt->execute($params)){
          return $stmt;
        }
        else{
          error_log("Erro no INSERT: " . print_r($stmt->errorInfo(), true));
          return false;
        }
      }
      else{
        error_log("Erro: $this->connection é nula em execute().");
        return false;
      }
    }catch(\PDOException $e) {
      error_log("ERRO ON CONNECTION: " . $e->getMessage());
      die('ERROR: '.$e->getMessage());
    }
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
    try{
      $this->connection->beginTransaction();

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
          //$asFkTable = substr($table, 0,3);
          $fields .= ', '.$table.'.*';
          $fk_join .= ' LEFT JOIN '.$table.' ON '.$asTable.'.'.$fk.' = '.$table.'.code ';
        }
      }
      else $from = $this->table;

      //MONTA A QUERY
      $query = 'SELECT '.$fields.' FROM '.$from.' '.$fk_join.' '.$where.' '.$order.' '.$limit;
      
      //DEBUG
      if($debug) return $query;

      //EXECUTA A QUERY
      $stmt = $this->execute($query);

      if($stmt){
        $this->connection->commit();
        return $stmt;
      }
      else{
        error_log("DAO->select: Rollback da transação (stmt false)");
        $this->connection->rollBack();
        return false;
      }
    }
    catch(\PDOException $e){
      error_log("DAO->select: Rollback da transação (exceção): " . $e->getMessage());
      $this->connection->rollBack();
      error_log("MYSQL ERROR: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($values,$last_id = false){
    //DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    //MONTA A QUERY
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    //EXECUTA O INSERT
    $stmt = $this->execute($query,array_values($values));
    if($last_id) $id = $this->connection->lastInsertId();
    else $id = true;

    return $id;
  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    //REMOVE BLANKS
    foreach($values as $key => $val){
      if(is_string($val) && strcmp($val,'null')==0) $values[$key] = null;
      elseif($val === null || (is_string($val) && $val === '')) unset($values[$key]);
    }

    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    //EXECUTAR A QUERY
    $return = "\n";
    foreach($values as $key => $value){
       if(is_array($value)){
          $tmpValue = "";
          foreach($value as $id => $item){
             $tmpValue .= '['.$id.']'.$item.' ';
          }
          $value = $tmpValue;
       }
       $return .= "\t".$key.": ".$value."\n";
    }

    // error_log("\n UDPDATE VALUES:".$return);

    $stmt = $this->execute($query,array_values($values));

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

    //RETORNA SUCESSO
    return true;
  }

  public function beginTransaction() {
    $this->connection->beginTransaction();
  }

  public function commit() {
    $this->connection->commit();
  }

  public function rollBack() {
    $this->connection->rollBack();
  }
}
?>
