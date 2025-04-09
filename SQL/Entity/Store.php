<?php
namespace SQL\Entity;
use \SQL\Entity\Model;
use \SQL\DAO\StoreDAO;
use \PDO;
use \JsonSerializable;

/**
 * CLASS Store on DB
 */
class Store extends Model implements \JsonSerializable 
{
   public $code;
   public $name;
   public $city;

   /**
   * Constructor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
      $this->path_class = "\SQL\Entity\Store";
      $this->setDAO();

      if(!empty($vars))
      {
         $this->code = $vars['code'];
         $this->name = $vars['name'];
         $this->city = $vars['city'] ?? null;
      }
   }

   /**
    * SET this DAO Object
    */
   private function setDAO(){
      $this->dao = new StoreDAO();
   }

   /**
    * SET Store
    * @param Store $Store
    */
   public function set(Store $Store)
   {
      if(!empty($Store->code)) $this->code = $Store->code;
      if(!empty($Store->name)) $this->name = $Store->name;
      if(!empty($Store->city)) $this->city = $Store->city;
   }

   /**
    * GET Code
    * @param string $code
    * @return string
    */
   public function getCode($code = null)
   {
      if($code) return substr($code,0,10);
      else return substr($this->code,0,10);
   }

   /**
    * SEARCH for code
    * @param string $code
    */
   public function getByCode($code,$ajax = false)
   {
      try {
         $where = 'code LIKE "'.$this->getCode($code).'"';
         if($stmt = $this->dao->select($where)){            
            $store = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(is_array($store)){
               $Store = new Store($store);

               if($ajax) return $Store->jsonSerialize();
               else return $Store;
            }
            else return false;
         }
         else{
            return false;
         }
      }
      catch(\PDOException $e) {
         error_log("ERROR on search for Store: " . $e->getMessage());
         return false;
      }
   }

   /**
    * PRINT a json array to ajax
    *
    * @return array
    */
    public function jsonSerialize(): array {
      return [
         'code' => $this->code,
         'name' => $this->name,
         'city' => $this->city
      ];
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
                $this->rows[$i] = new Store($row);
                $i++;
             }
             return true;
          }
          else{
             return false;
          }
       }
       catch(\PDOException $e) {
          error_log("Erro ao buscar Stores: " . $e->getMessage());
          return false;
       }
    }
}

?>
