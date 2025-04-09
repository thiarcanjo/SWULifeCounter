<?php
namespace SQL\Entity;
use \SQL\Entity\Model;
use \SQL\DAO\AspectDAO;
use \PDO;
use \JsonSerializable;

/**
 * Classe referência a tabela promotion no DB
 */
class Aspect extends Model implements \JsonSerializable 
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
      $this->path_class = "\SQL\Entity\Aspect";
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
      $this->dao = new AspectDAO();
   }

   /**
    * SET Aspect
    * @param Aspect $Aspect
    */
   public function set(Aspect $Aspect)
   {
      if(!empty($Aspect->code)) $this->code = $Aspect->code;
      if(!empty($Aspect->name)) $this->name = $Aspect->name;
      if(!empty($Aspect->img)) $this->img   = $Aspect->img;
   }

   /**
    * GET Code
    * @param string $code
    * @return string
    */
   public function getCode($code = null)
   {
      if($code) return substr($code,0,1);
      else return substr($this->code,0,1);
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
            $aspect = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(is_array($aspect)){
               $Aspect = new Aspect($aspect);

               if($ajax) return $Aspect->jsonSerialize();
               else return $Aspect;
            }
            else return false;
         }
         else{
            return false;
         }
      }
      catch(\PDOException $e) {
         error_log("ERROR on search for Aspect: " . $e->getMessage());
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
