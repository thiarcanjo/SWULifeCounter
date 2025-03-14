<?php
namespace SQL;
use \SQL\Model;
use \SQL\Premier;
use \SQL\PremierLiveDAO;
use \PDO;

/**
 * Classe referência a tabela promotion no DB
 */
class PremierLive extends Model
{
   /**
   * Construtor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
      $this->setDAO();
   }

   private function setDAO(){
      $this->dao = new PremierLiveDAO();
   }

   /**
    * Busca todas os resultados do DB
    * @param  string $where
    * @param  string $order
    * @param  string $limit
    * @param  string $fields
    */
   public function getAllRows($where = null, $order = null, $limit = null, $fields = '*')
   {
      try{
         if($stmt = $this->dao->select($where, $order, $limit, $fields)){ 
            $this->rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $i=0;
            foreach($this->rows as $row){
               $this->rows[$i] = new Premier($row);
               $i++;
            }
            return true;
         }
         else{
            return false;
         }
      }
      catch(\PDOException $e) {
         error_log("Erro ao buscar PremierList: " . $e->getMessage());
         return false;
      }
   }
}
?>
