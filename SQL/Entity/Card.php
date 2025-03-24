<?php
namespace SQL\Entity;
use \SQL\Entity\Model;
use \SQL\Entity\Collection;
use \SQL\Entity\Aspect;
use \SQL\DAO\CardDAO;
use \SQL\DAO\CardAspectDAO;
use \PDO;
use \JsonSerializable;

/**
 * Classe referência a tabela promotion no DB
 */
class Card extends Model implements \JsonSerializable 
{
   public $code;
   public $Collection;
   public $number;
   public $type;
   public $Aspects = array();
   public $name;
   public $life;
   public $epic;
   public $img;

   /**
   * Construtor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
      $this->path_class = "\SQL\Card";
      $this->setDAO();

      if(!empty($vars))
      {
         $this->code = $vars['code'][0];
         $this->Collection = new Collection();
         $this->Collection = $this->Collection->getByCode($vars['code'][1]);
         $this->number = $vars['number'];
         $this->type = $vars['type'];
         $this->getCardAspect(); // FIX GET ASPECTS
         $this->name = $vars['name'][0];
         $this->life = $vars['life'] ?? null;
         $this->epic = $vars['epic'] ?? false;
         $this->img  = $vars['img'][0] ?? null;
      }
   }

   /**
    * GET Aspects on this card
    */
   private function getCardAspect(){
      $CardAspect = new CardAspectDAO();
      $where = 'Card LIKE "'.$this->getCode().'"';
      if($return = $CardAspect->select($where)){
         $i = 0;
         foreach($return as $card_aspect){
            $this->Aspects[$i] = new Aspect();
            $this->Aspects[$i] = $this->Aspects[$i]->getByCode($card_aspect['Aspect']);
            $i++;
         }
      }
      else error_log("\n ERRO ON GET CARD ASPECTS");
   }

   /**
    * SET this DAO Object
    */
   private function setDAO(){
      $this->dao = new CardDAO();
   }

   /**
    * SET Card
    * @param Card $Card
    */
   public function set(Card $Card)
   {
      if(!empty($Card->code))    $this->code = $Card->code;
      if(!empty($Card->Collection) && ($Card->Collection instanceof Collection)) $this->Collection = $Card->Collection;
      if(!empty($Card->number))  $this->number  = $Card->number;
      if(!empty($Card->type))    $this->type    = $Card->type;
      if(!empty($Card->name))    $this->name    = $Card->name;
      if(!empty($Card->life))    $this->life    = $Card->life;
      if(!empty($Card->epic))    $this->epic    = $Card->epic;
      if(!empty($Card->img))     $this->img     = $Card->img;
   }

   /**
    * GET Code
    * @param string $code
    * @return string
    */
   public function getCode($code = null)
   {
      if($code) return substr($code,0,6);
      else return substr($this->code,0,6);
   }

   /**
    * SEARCH for code
    * @param string $code
    */
   public function getByCode($code,$ajax = false)
   {
      try {
         $where = 'c.code LIKE "'.$this->getCode($code).'"';
         if($stmt = $this->dao->select($where)){
            $card = $stmt->fetch(PDO::FETCH_NAMED);

            if(is_array($card)){
               $Card = new Card($card);

               if($ajax){
                  $this->set($Card);
                  return $Card->jsonSerialize();
               }
               else return $Card;
            }
            else return false;
         }
         else{
            return false;
         }
      }
      catch(\PDOException $e) {
         error_log("ERROR on search for Card: " . $e->getMessage());
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
         'Collection' => $this->Collection,
         'number' => $this->number,
         'type' => $this->type,
         'Aspects' => $this->Aspects,
         'name' => $this->name,
         'life' => $this->life,
         'epic' => $this->epic,
         'img' => $this->img
      ];
   }
}

?>
