<?php
namespace SQL\Entity;
use \SQL\Entity\Model;
use \SQL\DAO\CollectionDAO;
use \PDO;
use \JsonSerializable;

/**
 * Classe referência a tabela promotion no DB
 */
class Collection extends Model implements \JsonSerializable 
{
   public $code;
   public $name;
   public $img;

   /**
   * Construtor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
      $this->path_class = "\SQL\Collection";
      $this->setDAO();

      if(!empty($vars))
      {
         $this->code = $vars['code'];
         $this->name = $vars['name'];
         $this->img  = $vars['img'] ?? null;
      }
   }

   /**
    * SET this DAO Object
    */
   private function setDAO(){
      $this->dao = new CollectionDAO();
   }

   /**
    * SET Collection
    * @param Collection $Collection
    */
   public function set(Collection $Collection)
   {
      if(!empty($Collection->code)) $this->code = $Collection->code;
      if(!empty($Collection->name)) $this->name = $Collection->name;
      if(!empty($Collection->img)) $this->img   = $Collection->img;
   }

   /**
    * GET Code
    * @param string $code
    * @return string
    */
   public function getCode($code = null)
   {
      if($code) return substr($code,0,3);
      else return substr($this->code,0,3);
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
            $collection = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(is_array($collection)){
               $Collection = new Collection($collection);
               
               if($ajax) return $Collection->jsonSerialize();
               else return $Collection;
            }
            else return false;
         }
         else{
            return false;
         }
      }
      catch(\PDOException $e) {
         error_log("ERROR on search for Collection: " . $e->getMessage());
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
         'img' => $this->img
      ];
   }
}

?>
