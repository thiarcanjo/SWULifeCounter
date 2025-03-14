<?php
namespace SQL;
use \SQL\Model;
use \SQL\PremierDAO;
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

   /**
   * Construtor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
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
      $stmt = $this->dao->select($where, $order, $limit, $fields);
      $this->rows = $stmt->fetchAll(PDO::FETCH_CLASS,"\SQL\Premier");
      $stmt->closeCursor();
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
    * SEARCH for ID
    * @param string $premier_id
    */
   public function getById($premier_id)
   {
      try {
         $where = 'premier_id LIKE "'.substr($premier_id,0,6).'"';
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
    * INSERT/UPDATE
    */
   public function save($Premier = null)
   {
      if(!($Premier)) return $this->dao->insert($this);
      else return $this->dao->update($this);
   }

   /**
    * UPDATE life
    */
   public function updateGame($player,$base_life = null,$base_epic = null,$leader_epic = null)
   {
      switch($player)
      {
         case "player_1":
            if($base_life !== null && $base_life !== '')    $this->life[0]     = $base_life;
            if($base_epic !== null && $base_epic !== '')    $this->base_epic[0]     = $base_epic;
            if($leader_epic !== null && $leader_epic !== '') $this->leader_epic[0]  = $leader_epic;
            break;
         case "player_2":
            if($base_life !== null && $base_life !== '')    $this->life[1]     = $base_life;
            if($base_epic !== null && $base_epic !== '')    $this->base_epic[1]     = $base_epic;
            if($leader_epic !== null && $leader_epic !== '') $this->leader_epic[1]  = $leader_epic;
            break;
      }

      return $this->dao->update($this);
   }

   /**
    * DELETE
    * @param integer $id
    */
   public function delete()
   {
      return $this->dao->delete($this);
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
  
  /**
   * TRANSFORM to STRING for DEBUG
   * @return string
   */
  public function toString(){
      $vars = array(
         'premier_id'   => $this->premier_id,
         'base'         => $this->base,
         'leader'       => $this->leader,
         'life'         => $this->life,
         'base_epic'    => $this->base_epic,
         'leader_epic'  => $this->leader_epic,
         'datetime'     => $this->datetime
      );

      $return = "\n";
      foreach($vars as $key => $value){
         if(is_array($value)){
            $tmpValue = "";
            foreach($value as $id => $item){
               $tmpValue .= '['.$id.']'.$item.' ';
            }
            $value = $tmpValue;
         }
         $return .= "\t".$key.": ".$value."\n";
      }

      return $return;
  }

  public function __sleep() {
   error_log("Premier::__sleep() chamado. premier_id: " . $this->premier_id);
   return array('premier_id', 'player_1', 'player_2', /* outras propriedades */);
   }

   public function __wakeup() {
      error_log("Premier::__wakeup() chamado. premier_id: " . $this->premier_id);
   }
}

?>
