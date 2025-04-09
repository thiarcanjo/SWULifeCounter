<?php
namespace SQL\Entity;
use \SQL\Entity\Model;
use \SQL\Entity\Store;
use \SQL\DAO\PremierDAO;
use \UTILS\Session;
use \PDO;

/**
 * Classe referência a tabela promotion no DB
 */
class Premier extends Model
{
   public $premier_id;
   public $base = array('','');
   public $leader = array('','');
   public $life = array(0,0);
   public $base_epic = array(false,false);
   public $leader_epic = array(false,false);
   public $datetime = null;
   public $Store = null;

   /**
   * Construtor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
      $this->path_class = "\SQL\Entity\Premier";
      $this->setDAO();

      if(!empty($vars))
      {
         $this->premier_id       = $vars['premier_id'] ?? null;
         $this->base[0]          = $vars['base_1'] ?? '';
         $this->base[1]          = $vars['base_2'] ?? '';
         $this->leader[0]        = $vars['leader_1'] ?? '';
         $this->leader[1]        = $vars['leader_2'] ?? '';
         $this->life[0]          = $vars['base_1_life'] ?? 0;
         $this->life[1]          = $vars['base_2_life'] ?? 0;
         $this->base_epic[0]     = $vars['base_1_epic'] ?? false;
         $this->base_epic[1]     = $vars['base_2_epic'] ?? false;
         $this->leader_epic[0]   = $vars['leader_1_epic'] ?? false;
         $this->leader_epic[1]   = $vars['leader_2_epic'] ?? false;
         $this->datetime         = $vars['datetime'] ?? date("Y-m-d H:i:s");
         if(isset($vars['Store']) && !empty($vars['Store'])) $this->Store = $this->setStore($vars['Store']);
         else $this->Store = null;
      }
      elseif($premier_id = Session::getPremierID()){
         $this->premier_id = $premier_id;
         if($Premier = $this->getById($this->premier_id)) $this->set($Premier);
      }
      elseif(!($this->premier_id) && !(Session::getPremierID())) $this->setPremierID();
   }

   private function setDAO(){
      $this->dao = new PremierDAO();
   }

   /**
    * Seta variaveis
    */
   public function set(Premier $Premier)
   {
       if(!empty($Premier->premier_id)) $this->premier_id         = $Premier->premier_id;
       if(!empty($Premier->base[0])) $this->base[0]               = $Premier->base[0];
       if(!empty($Premier->base[1])) $this->base[1]               = $Premier->base[1];
       if(!empty($Premier->leader[0])) $this->leader[0]           = $Premier->leader[0];
       if(!empty($Premier->leader[1])) $this->leader[1]           = $Premier->leader[1];
       if(!empty($Premier->life[0])) $this->life[0]               = $Premier->life[0];
       if(!empty($Premier->life[1])) $this->life[1]               = $Premier->life[1];
       if(!empty($Premier->base_epic[0])) $this->base_epic[0]     = $Premier->base_epic[0];
       if(!empty($Premier->base_epic[1])) $this->base_epic[1]     = $Premier->base_epic[1];
       if(!empty($Premier->leader_epic[0])) $this->leader_epic[0] = $Premier->leader_epic[0];
       if(!empty($Premier->leader_epic[1])) $this->leader_epic[1] = $Premier->leader_epic[1];
       if(!empty($Premier->datetime)) $this->datetime             = $Premier->datetime;
       if(!empty($Premier->Store)){
         if($Premier->Store instanceof Store) $this->Store = $Premier->Store;
         else $this->Store = $this->setStore($Premier->Store);
       }
   }

   /**
    * SET Store
    * @param string $store
    */
   public function setStore($store)
   {
      $Store = new Store();
      $Store = $Store->getByCode($store);

      return $Store;
   }

   /**
    * SET Player
    * @param string $player
    * @param string $base
    * @param string $leader
    */
   public function setPlayer($player,$base,$leader)
   {
      switch($player)
      {
         case "player_1":
            $this->base[0] = $base;
            $this->leader[0] = $leader;
            $this->life[0] = 0;
            $this->base_epic[0] = false;
            $this->leader_epic[0] = false;
            break;
         case "player_2":
            $this->base[1] = $base;
            $this->leader[1] = $leader;
            $this->life[1] = 0;
            $this->base_epic[1] = false;
            $this->leader_epic[1] = false;
            break;
      }

      if($store = Session::getStore()) $this->Store = $this->setStore($store);
      else $this->Store = null;
   }

   /**
    * CREATE A ID for this Premier game
    */
   private function setPremierID()
   {
      if(empty($this->premier_id))
      {
         $this->premier_id = $this->generatePremierID();
      }
   }

   /**
    * GET ID
    * @param string $premier_id
    * @return string
    */
   public function getID($premier_id = null)
   {
      if($premier_id) return substr($premier_id,0,6);
      else return substr($this->premier_id,0,6);
   }

   /**
    * SEARCH for ID
    * @param string $premier_id
    */
   public function getById($premier_id)
   {
      try {
         $where = 'p.premier_id LIKE "'.$this->getID($premier_id).'"';

         if($stmt = $this->dao->select($where)){            
            $premier = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(is_array($premier)){
               $Premier = new Premier($premier);
               return $Premier;
            }
            else return false;
         }
         else{
            return false;
         }
      }
      catch(\PDOException $e) {
         error_log("Erro ao buscar Premier por ID: " . $e->getMessage());
         return false;
      }
   }

   /**
    * UPDATE life
    */
   public function updateGame($player,int $base_life = null, $base_epic = null, $leader_epic = null)
   {
      if($player == "player_1") $id = 0;
      elseif($player == "player_2") $id = 1;
      if($base_life !== null) $this->life[$id] = $base_life;
      if($base_epic === "false" || $base_epic === "true")      $this->base_epic[$id]   = filter_var($base_epic, FILTER_VALIDATE_BOOLEAN);
      if($leader_epic === "false" || $leader_epic === "true")  $this->leader_epic[$id] = filter_var($leader_epic, FILTER_VALIDATE_BOOLEAN);

      $this->datetime = date("Y-m-d H:i:s");
      
      return $this->dao->update($this);
   }

   /**
    * GENERATE a random Premier ID if 6 length
    * @return string
    */
   public function generatePremierID() {
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charsLength = strlen($chars);
      $randow = '';
      for ($i = 0; $i < 6; $i++) {
          $randow .= $chars[rand(0, $charsLength - 1)];
      }
      return $randow;
  }

}
?>
