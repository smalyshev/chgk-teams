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
	const MAX_PLAYERS = 6;

	public function __construct()
	{
		$this->_loader = new Zend_Loader_PluginLoader(array('Reg2_Models_Tables' => APPLICATION_PATH . '/models/tables'));
	}
	
	/**
	 * Get registreted model instance
	 * 
	 * @returns Reg2_Model_Data
	 */
	static public function getModel()
	{
		return Zend_Registry::get('model');
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
		
		$tid = $teams->insert(array(
			"imia" => $values["name"],
			"turnir" => self::PENDING_TURNIR,
			"list" => $values["email"],
			"url" => $values["url"],
			"stamp" => time(),
		));
		$kap = 0;
		for($i=0;$i<self::MAX_PLAYERS;$i++) {
			if($values["players"]["pname$i"] == "") {
				continue;
			}
			$uid = $players->insert(array(
				"imia" => $values["players"]["pname$i"],
				"famil" => $values["players"]["pfamil$i"],
				"city" => $values["players"]["pcity$i"],
				"country" => $values["players"]["pcountry$i"],
				"sex" => $values["players"]["psex$i"],
				"born" => $values["players"]["pbirth$i"],
				"stamp" => time(),
			));
			$player_team->insert(array(
				"uid" => $uid,
				"tid" => $tid,
				"turnir" => self::PENDING_TURNIR,
				"stamp" => time(),
			));
			if($i == 0) {
				$kap = $uid;
			}
		}
		if($kap) {
			$teams->update(array("kap" => $kap), "tid = $tid");
		}
		
		return true;
	}
	
	public function findPlayerByName($name, $famil)
	{
		Zend_Registry::get('log')->info("Get Player: '$name $famil'");
		$table = $this->getTable('Players');
        $select = $table->select()->where("imia = ?", $name)->where("famil = ?", $famil);
        return $table->fetchRow($select);
	}
}

