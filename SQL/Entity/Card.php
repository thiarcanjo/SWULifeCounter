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
      $this->path_class = "\SQL\Entity\Card";
      $this->setDAO();

      if(!empty($vars))
      {
         $this->code = (isset($vars['code'][0]))? $vars['code'][0] : $vars[0];
         $this->Collection = new Collection();
         $this->Collection = (isset($vars['code'][1]))? $this->Collection->getByCode($vars['code'][1]) : $this->Collection->getByCode($vars[8]);
         $this->number = (isset($vars['number']))? $vars['number'] : $vars[2];
         $this->type = (isset($vars['type']))? $vars['type'] : $vars[3];
         $this->getCardAspect(); // FIX GET ASPECTS
         $this->name = (isset($vars['name'][0]))? $vars['name'][0] : $vars[4];
         if(isset($vars['life']) || isset($vars[5])) $this->life = $vars['life']?? $vars[5];
         else $this->life = null;
         if(isset($vars['epic']) || isset($vars[6])) $this->epic = $vars['epic']?? $vars[6];
         else $this->epic = null;
         if(isset($vars['img'][0]) || isset($vars[7])) $this->img = $vars['img'][0]?? $vars[7];
         else $this->img = null;
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
    * RETURN ALL card with a especifc type
    * @param string $type
    * @return array
    */
   public function getAll($type){
      if(!empty($type)){
         $where = "type LIKE '".$type."'";
         $order = "c.name ASC";
         $stmt = $this->dao->select($where, $order);
         $this->rows = $stmt->fetchAll(PDO::FETCH_NUM);

         $return = array();
         foreach($this->rows as $card){
            $Card = new Card($card);
            $return[] = $Card;
         }

         return $return;
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
