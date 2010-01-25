<?php

/**
 * Data
 *  
 * @author stas
 * @version 
 */

class Reg2_Model_Data
{
	protected $_tables = array();
	const TURNIR = 50;
	const PENDING_TURNIR = -1;
	const MAX_PLAYERS = 18;

	public function __construct()
	{
		$this->_loader = new Zend_Loader_PluginLoader(array('Reg2_Models_Tables' => APPLICATION_PATH . '/models/tables'));
	}
	
	public function getMaxPlayers()
	{
		return self::MAX_PLAYERS;
	}
	
	/**
	 * Get registreted model instance
	 * 
	 * @returns Reg2_Model_Data
	 */
	static public function getModel()
	{
		return Bootstrap::get('model');
	} 
	
	/**
	 * Create Zend_Db_Table for given table
	 * 
	 * @param string $id
	 * @return Zend_Db_Table_Abstract
	 */
	protected function getTable($id)
	{
		if (! isset($this->_tables[$id])) {
			$class = $this->_loader->load($id);
            $this->_tables[$id] = new $class();
        }
        return $this->_tables[$id];
		
	}
	
    public function findTeam ($id)
    {
        $res = $this->getTable('Teams')->find($id);
        if (! empty($res)) {
            return $res->current();
        }
        // TODO: better handling for unknown ID
        throw new Exception("Unknown team ID!");
    }
    
    public function findTeamByEmail($email)
    {
        $table = $this->getTable('Teams');
        $select = $table->select()->where("list = ?", $email);
        return $table->fetchRow($select);
    }
    
    public function findTeamByName($name)
    {
        $table = $this->getTable('Teams');
        $select = $table->select()->where("imia = ?", $name);
        return $table->fetchRow($select);
    }
		
	public function addTeamData($values)
	{
		$players = $this->getTable('Players');
		$teams = $this->getTable('Teams');
		$player_team = $this->getTable('PlayerTeam');
		
		Zend_Registry::get('log')->info("Add pending team: '$values[name] $values[email]'");
		$tid = $teams->insert(array(
			"imia" => $values["name"],
			"turnir" => self::PENDING_TURNIR,
			"list" => $values["email"],
			"url" => $values["url"],
			"stamp" => time(),
		));
		$kap = 0;
		for($i=0;$i<self::MAX_PLAYERS;$i++) {
			if($values["pname$i"] == "") {
				continue;
			}
			$uid = $players->insert(array(
				"imia" => $values["pname$i"],
				"famil" => $values["pfamil$i"],
				"city" => $values["pcity$i"],
				"country" => $values["pcountry$i"],
				"sex" => $values["psex$i"],
				"born" => $values["pbirth$i"],
				"stamp" => time(),
			));
			$player_team->insert(array(
				"uid" => $uid,
				"tid" => $tid,
				"turnir" => self::PENDING_TURNIR,
				"stamp" => time(),
			));
			Zend_Registry::get('log')->info(sprintf("Add pending player %d: '%s %s'", 
				$uid, $values["pname$i"], $values["pfamil$i"]));
			if($i == 0) {
				$kap = $uid;
			}
		}
		if($kap) {
			$teams->update(array("kap" => $kap), "tid = $tid");
		}
		
		return true;
	}
	
	public function countPendingTeams()
	{
		$table = $this->getTable('Teams');
		$select = $table->select()
			->from($table->info('name'), array("teamcount" => 'COUNT(*)'))
			->where('turnir = ?', self::PENDING_TURNIR);
		$res = $table->fetchRow($select);
		Zend_Registry::get('log')->info("Select $select");
		if($res) {
			return $res->teamcount;
		}
		return 0;
	}
	
	public function getPendingTeams()
	{
		$table = $this->getTable('Teams');
		$select = $table->select()->where('turnir = ?', self::PENDING_TURNIR);
		return $table->fetchAll($select);
	}
	
	public function findPlayerByName($name, $famil)
	{
		Zend_Registry::get('log')->info("Get Player: '$name $famil'");
		$table = $this->getTable('Players');
        $select = $table->select()->where("imia = ?", $name)->where("famil = ?", $famil);
        return $table->fetchRow($select);
	}
}

