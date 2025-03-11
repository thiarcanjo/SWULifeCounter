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

   /**
   * Construtor
   * @param array $vars
   */
   public function __construct($vars = [])
   {
      $this->dao = new PremierDAO();

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
      }

      if($Premier = Session::getPremier()){
         $this->premier_id = $Premier->premier_id;
         $this->set($this->getById($this->premier_id));
      }
      elseif(!($this->premier_id) && !(Session::getPremier())) $this->setPremierID();
   }

   /**
    * Seta variaveis
    */
    public function set(Premier $Premier)
    {
       $this->premier_id    = $Premier->premier_id ?? '';
       $this->base          = $Premier->base ?? array('','');
       $this->leader        = $Premier->leader ?? array('','');
       $this->life          = $Premier->life ?? array(0,0);
       $this->base_epic     = $Premier->base_epic ?? array(false,false);
       $this->leader_epic   = $Premier->leader_epic ?? array(false,false);
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
            break;
         case "player_2":
            $this->base[1] = $base;
            $this->leader[1] = $leader;
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
         $stmt = $this->dao->select($where)->fetchObject(self::class);
         if($stmt instanceof Premier){
            error_log("\n----FOUNDED----\n");
            return $Premier;
         }
         else{
            error_log("\n----NOT FOUNDED----\n");
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
   public function save()
   {
      $objPremier = self::getById($this->premier_id);
      if(!($objPremier instanceof Premier))
      {
         self::setPremierID();
         $this->dao->insert($this);
         return true;
      }
      else
      {
         return $this->dao->update($this);
      }
   }

   /**
    * UPDATE life
    */
   public function updateGame($player,$base_life = null,$base_epic = null,$leader_epic = null)
   {
      switch($player)
      {
         case "player_1":
            if($base_life) $this->base_life[0] = $base_life;
            if($base_epic) $this->base_epic[0] = $base_epic;
            if($leader_epic) $this->leader_epic[0] = $leader_epic;
            break;
         case "player_2":
            if($base_life) $this->base_life[1] = $base_life;
            if($base_epic) $this->base_epic[1] = $base_epic;
            if($leader_epic) $this->leader_epic[1] = $leader_epic;
            break;
      }

      $objPremier = self::getById($this->premier_id);
      if($objPremier instanceof Premier) return $this->dao->update($this);
      else return false;
   }

   /**
    * DELETE
    * @param integer $id
    */
   public function delete()
   {
      return $this->dao->delete($this->premier_id);
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
         'leader_epic'  => $this->leader_epic
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
