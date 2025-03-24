<?php
namespace SQL\Entity;
use \SQL\Entity\Model;
use \SQL\Entity\Premier;
use \SQL\DAO\PremierLiveDAO;
use \PDO;
use \DateTime;

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
         $order = "datetime DESC, Store ASC";
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

   /**
    * CLEAR Games with 30 minutes more no update
    * @return boolean
    */
   public function clearOldGames(){
      $dataAtual = new DateTime(); // DATE now
      $dataLimite = $dataAtual->modify('-30 minutes'); // BACK 30 minutes
      $return = false;
      
      foreach($this->rows as $Premier){
         $dataPremier = new DateTime($Premier->datetime);
         if ($dataPremier < $dataLimite) {
            $premier_id = $Premier->premier_id;
            if($Premier->delete()){
               error_log("\n GAME ".$premier_id." ERASED.");
               $return = true;
            }
         }
      }

      return $return;
   }
}
?>
