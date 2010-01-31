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
	const CODE_LEN = 8;

    public static $V  = array("a", "e", "i", "o", "u", "y");
    public static $VN = array("a", "e", "i", "o", "u", "y","2","3","4","5","6","7","8","9");
    public static $C  = array("b","c","d","f","g","h","j","k","m","n","p","q","r","s","t","u","v","w","x","z");
    public static $CN = array("b","c","d","f","g","h","j","k","m","n","p","q","r","s","t","u","v","w","x","z","2","3","4","5","6","7","8","9");
	public static $femnames = array(
"Александра" => 1,
"Алена" => 1,
"Алина" => 1,
"Алиса" => 1,
"Алла" => 1,
"Альмира" => 1,
"Анастасия" => 1,
"Анна" => 1,
"Арина" => 1,
"Белла" => 1,
"Валентина" => 1,
"Валерия" => 1,
"Василина" => 1,
"Вера" => 1,
"Вероника" => 1,
"Виктория" => 1,
"Веста" => 1,
"Вика" => 1,
"Виктория" => 1,
"Виолетта" => 1,
"Василиса" => 1,
"Влада" => 1,
"Галина" => 1,
"Гела" => 1,
"Гелена" => 1,
"Гульнара" => 1,
"Дарья" => 1,
"Диана" => 1,
"Дина" => 1,
"Динара" => 1,
"Евгения" => 1,
"Екатерина" => 1,
"Елена" => 1,
"Елизавета" => 1,
"Жанна" => 1,
"Инга" => 1,
"Инна" => 1,
"Ира" => 1,
"Ирина" => 1,
"Карина" => 1,
"Кира" => 1,
"Клавдия" => 1,
"Ксения" => 1,
"Кама" => 1,
"Лариса" => 1,
"Лейла" => 1,
"Лида" => 1,
"Лора" => 1,
"Любовь" => 1,
"Людмила" => 1,
"Майя" => 1,
"Марианна" => 1,
"Марина" => 1,
"Мария" => 1,
"Марьяна" => 1,
"Надежда" => 1,
"Наза" => 1,
"Настя" => 1,
"Наталия" => 1,
"Наталья" => 1,
"Оксана" => 1,
"Олеся" => 1,
"Ольга" => 1,
"Регина" => 1,
"Рената" => 1,
"Сабина" => 1,
"Саида" => 1,
"Света" => 1,
"Светлана" => 1,
"Tатьяна" => 1,
"Тина" => 1,
"Таня" => 1,
"Руслана" => 1,
"Тамара" => 1,
"Полина" => 1,
"Элеонора" => 1,
"Элла" => 1,
"Эльмира" => 1,
"Эльвира" => 1,
"Эльнур" => 1,
"Юлия" => 1,
"Яна" => 1,
	);
	
	public function __construct()
	{
		$this->_loader = new Zend_Loader_PluginLoader(array('Reg2_Models_Tables' => APPLICATION_PATH . '/models/tables'));
	}
	
	/**
	 * Get max number of playes
	 * 
	 * @return int
	 */
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
	
    /**
     * @param int  $id
     * @return Zend_Db_Table_Row
     */
    public function findTeam ($id)
    {
        $res = $this->getTable('Teams')->find($id);
        if (!empty($res) && $res->count() >0) {
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
        $select = $table->select()
        		->where("imia = ?", $name)
        		->where("turnir = ".self::TURNIR." OR turnir =".self::PENDING_TURNIR);
        return $table->fetchRow($select);
    }
		
    /**
     * Insert data for player into the DB
     * 
     * Also binds to the team
     * 
     * @param array $values
     * @param int $i index in the array
     * @param int $tid team id
     * @param int $turnir turnir id
     * @return int UID
     */
    protected function _addPlayerData($values, $i, $tid, $turnir)
    {
		$players = $this->getTable('Players');
		$player_team = $this->getTable('PlayerTeam');
    	
		$uid = $players->insert(array(
			"imia" => $values["pname$i"],
			"famil" => $values["pfamil$i"],
			"city" => $values["pcity$i"],
			"country" => $values["pcountry$i"],
			"sex" => $values["psex$i"],
			"born" => $values["pborn$i"],
			"email" => $values["pemail$i"],
			"stamp" => time(),
		));
		$player_team->insert(array(
			"uid" => $uid,
			"tid" => $tid,
			"turnir" => $turnir,
			"stamp" => time(),
		));
		Zend_Registry::get('log')->info(sprintf("Add pending player %d: '%s %s'", 
				$uid, $values["pname$i"], $values["pfamil$i"]));
		return $uid;
    }
    
    /**
     * Bind two player's records in the DB
     * 
     * Takes player $i in $values and makes it bind to newly specified PID
     * i.e. destroys new record and moves team binding and data to an old one
     * 
     * @param array $values
     * @param int $i
     */
    protected function _bindPlayers($values, $i)
    {
		$players = $this->getTable('Players');
		$player_team = $this->getTable('PlayerTeam');
		$teams = $this->getTable('Teams');

		// TODO: check that this player isn't registered with other team
		
		// NB: we move entries from newid to oldid
		$newid = (int)$values["oldpid$i"];
		$oldid = (int)$values["pid$i"];
		
		Zend_Registry::get('log')->info("Bind player $newid->$oldid");
		
		if($oldid == 0 || $newid == 0) {
			return;
		}
		
		$player_team->update(array("uid" => $oldid), "uid = $newid");
		$teams->update(array("kap" => $oldid), "kap = $newid");
		$players->delete("uid = $newid");
		
		// copy new values
		$data = array();
		$fields = array("city", "country", "sex", "email", "born");
		foreach($fields as $field) {
			if(!empty($values["p$field$i"])) {
				$data[$field] = $values["p$field$i"];
			}
		}
		if(count($data)) {
			$players->update($data, "uid = $oldid");
		}
    }
    
    public function deletePlayer($uid)
    {
    	$players = $this->getTable('Players');
    	$player_team = $this->getTable('PlayerTeam');
		Zend_Registry::get('log')->info("Delete player: $uid");
    	$players->delete("uid = ".(int)$uid);
    	$player_team->delete("uid = ".(int)$uid);
    } 
    
	/**
	 * Get team data from registration form
	 * 
	 * @param array $values
	 * @return bool
	 */
	public function addTeamData($values)
	{
		$teams = $this->getTable('Teams');
		
		Zend_Registry::get('log')->info("Add pending team: '$values[name] $values[email]'");
		$tid = $teams->insert(array(
			"imia" => $values["name"],
			"turnir" => self::PENDING_TURNIR,
			"list" => $values["contact"],
			"url" => $values["url"],
			"second_email" => $values["remail"],
			"regno" => $values["oldid"],
			"stamp" => time(),
		));
		$kap = 0;
		for($i=0;$i<self::MAX_PLAYERS;$i++) {
			if($values["pname$i"] == "") {
				continue;
			}
			$uid = $this->_addPlayerData($values, $i, $tid, self::PENDING_TURNIR);
			if($i == 0) {
				$kap = $uid;
			}
		}
		if($kap) {
			$teams->update(array("kap" => $kap), "tid = $tid");
		}
		
		return true;
	}
	
	public function saveTeamData($values)
	{
		$players = $this->getTable('Players');
		$teams = $this->getTable('Teams');
		$player_team = $this->getTable('PlayerTeam');
		
		$tid = (int)$values["tid"];
		Zend_Registry::get('log')->info("Editing team $tid: '$values[name]'");
		
		$team = $this->findTeam($tid);
		$team->imia = $values["name"];
		$team->list = $values["contact"];
		$team->url = $values["url"];
		$team->second_email = $values["remail"];
		$team->regno = $values["oldid"];
		$team->save();
				
		for($i=0;$i<self::MAX_PLAYERS;$i++) {
			if(empty($values["pname$i"])) {
				continue;
			}
			
			if(empty($values["oldpid$i"])) {
				$this->_addPlayerData($values, $i, $tid, $team->turnir);
			} else {
				if($values["pid$i"] != $values["oldpid$i"]) {
					if(!empty($values["pid$i"])) {
						// player id change
						$this->_bindPlayers($values, $i);
					} else {
						$this->deletePlayer($values["oldpid$i"]);
					}
				} else {
					// edit player data
					$players->update(array(
						"imia" => $values["pname$i"],
						"famil" => $values["pfamil$i"],
						"city" => $values["pcity$i"],
						"country" => $values["pcountry$i"],
						"sex" => $values["psex$i"],
						"born" => $values["pborn$i"],
						"email" => $values["pemail$i"],
					), "uid = ".(int)$values["pid$i"]);
				}
			}
		}			
		return true;
	}
	
	/**
	 * Get team data for populating form
	 * 
	 * @param int $tid
	 * @return array
	 */
	public function getTeamData($tid)
	{
		$players = $this->getTable('Players');
		$teams = $this->getTable('Teams');
		$player_team = $this->getTable('PlayerTeam');
		
		$team = $this->findTeam($tid);
		$values = array(
			"tid" => $tid,
			"name" => $team->imia,
			"url" => $team->url,
			"remail" => $team->second_email,
			"contact" => $team->list,
			"oldid" => $team->regno,
			"sezon2008" => $team->regno?'y':'n',
		);
		
		$players = $team->findManyToManyRowset($players, $player_team);
		$cnt=1;
		foreach($players as $player) {
			if($player->uid == $team->kap) {
				$i = 0;
			} else {
				$i = $cnt++;
			}
			$values["pid$i"] = $values["oldpid$i"] = $player->uid;
			$values["pname$i"] = $player->imia;
			$values["pfamil$i"] = $player->famil;
			$values["pcity$i"] = $player->city;
			$values["pcountry$i"] = $player->country;
			$values["psex$i"] = $player->sex;
			$values["pborn$i"] = $player->born;
			$values["pemail$i"] = $player->email;
		}
		return $values;
	}
	
	protected function _suggestCountry($city, $uid = 0)
	{
		$players = $this->getTable('Players');
		$select = $players->select()->distinct()->from($players, 'country')
				->where('city = ?', $city)->where('country <> \'\' AND country IS NOT NULL')
				->where("uid <> ?", $uid);
		$row = $players->fetchRow($select);
		if($row) {
			return $row->country;
		}
		return null;
	}
	
	protected function _suggestGender($name, $uid = 0)
	{
		if(isset(self::$femnames[$name])) {
			return 'f';
		}
		$players = $this->getTable('Players');
		$select = $players->select()->distinct()->from($players, 'sex')
				->where("imia = ?", $name)
				->where('sex <> \'\' AND sex IS NOT NULL')
				->where("uid <> ?", $uid);
		$rows = $players->fetchAll($select);
		if($rows->count() == 1) {
			$row = $rows->current();
			return $row->sex;
		}
		return null;
	}
	
	protected function _checkImFam($famil, $uid = 0)
	{
		$players = $this->getTable('Players');
		$select = $players->select()->from($players, array("cnt" => "count(*)"))
				->where("imia = ?", $famil)
				->where("uid <> ?", $uid);
		$row = $players->fetchRow($select);
		if($row && $row->cnt > 1) {
			return true;
		}
		return false;
	}
	
	/**
	 * Check data for errors and return array with error messages
	 * 
	 * @param array $values
	 * @return array
	 */
	public function checkTeamData($values)
	{
		$errors = array();
		// checks TODO:
		// team: if has regno, check name match
		// team: if has no regno, check if had same name
		// +player: check players with the same name
		// +player: check city, no country
		// +player: check switch im/fam
		// +player: check wrong gender
		$players = $this->getTable('Players');
		for($i=0;$i<self::MAX_PLAYERS;$i++) {
			if(empty($values["pname$i"]) || empty($values["oldpid$i"])) {
				continue;
			}
			
			// player: check players with the same name
			$select = $players->select()->where("imia = ?", $values["pname$i"])->where("famil = ?", $values["pfamil$i"]);
			$names = $players->fetchAll($select);
			foreach($names as $name_player) {
				if($name_player->uid == $values["oldpid$i"]) {
					continue;
				}
				$errors["p$i"][] = array(
					sprintf("Игрок с одинаковым именем: id=%d город=%s страна=%s", $name_player->uid, $name_player->city, $name_player->country),
					"SetFormField('pid$i', '{$name_player->uid}')");
			}
			// player: check city, no country
			if(!empty($values["pcity$i"])) {
				$suggest = $this->_suggestCountry($values["pcity$i"], $values["oldpid$i"]);
				if(empty($values["pcountry$i"]) && $suggest) {
					$errors["p$i"][] = array(
						"Страна не указана, предлагаю: $suggest",
						"SetFormField('pcountry$i', '$suggest')");
				} elseif($suggest && $suggest != $values["pcountry$i"]) {
					$errors["p$i"][] = array(
						"Страна не совпадает с другими записями, предлагаю: $suggest",
						"SetFormField('pcountry$i', '$suggest')");
				}
			}
			// player: check wrong gender
			if($values["psex$i"]) {
				$suggest =  $this->_suggestGender($values["pname$i"], $values["oldpid$i"]);
				if($suggest && $values["psex$i"] != $suggest) {
					$errors["p$i"][] = array(
						"Пол не совпадает с другими записями, предлагаю: $suggest",
						"SetFormField('psex$i', '$suggest')");
				}
			} else {
				$suggest =  $this->_suggestGender($values["pname$i"], $values["oldpid$i"]);
				if($suggest) {
					$errors["p$i"][] = array(
						"Пол не указан, предлагаю: $suggest",
						"SetFormField('psex$i', '$suggest')");
				}
			}
			// check swapped family name
			if($this->_checkImFam($values["pfamil$i"], $values["oldpid$i"])) {
				$errors["p$i"][] = array(
					sprintf("Фамилия: %s, имя: %s - подозреваю перепутаные имя и фамилию", $values["pfamil$i"], $values["pname$i"]),
					"SwapFormFields('pname$i', 'pfamil$i')");
			}
			
		}
		return $errors;
	}
	
	/**
	 * Confirm team in database
	 * 
	 * @param int $tid team
	 */
	public function confirmTeam($tid)
	{
		$teams = $this->getTable('Teams');
		$player_team = $this->getTable('PlayerTeam');
		
		$tid = (int)$tid;
		$teams->update(array("turnir" => self::TURNIR), "tid = $tid");
		$player_team->update(array("turnir" => self::TURNIR), "tid = $tid");
		// TODO: add team to IDs list in same_team
		return $true;
	}
	
	/**
	 * Find team contact address 
	 * 
	 * @param int $tid
	 */
	public function getTeamContact($tid)
	{
		$team = $this->findTeam($tid);
		return $team->list;
	}
	
	/**
	 * Get User record for team's captain
	 * 
	 * @param int $tid
	 */
	public function getTeamKap($tid)
	{
		$team = $this->findTeam($tid);
		return $this->findPlayer($team->kap);
	}
	
	/**
	 * Find how many teams are pending registration
	 */
	public function countPendingTeams()
	{
		$table = $this->getTable('Teams');
		$select = $table->select()
			->from($table, array("teamcount" => 'COUNT(*)'))
			->where('turnir = ?', self::PENDING_TURNIR);
		$res = $table->fetchRow($select);
		if($res) {
			return $res->teamcount;
		}
		return 0;
	}
	
	/**
	 * Get registered teams
	 */
	public function getTeams()
	{
		$table = $this->getTable('Teams');
		$select = $table->select()->where('turnir = ?', self::TURNIR);
		return $table->fetchAll($select);
	}
	
	/**
	 * Get teams pending registration
	 */
	public function getPendingTeams()
	{
		$table = $this->getTable('Teams');
		$select = $table->select()->where('turnir = ?', self::PENDING_TURNIR);
		return $table->fetchAll($select);
	}
	
    /**
     * @param int  $id
     * @return Zend_Db_Table_Row
     */
    public function findPlayer ($id)
    {
        $res = $this->getTable('Players')->find($id);
        if (! empty($res)) {
            return $res->current();
        }
        // TODO: better handling for unknown ID
        throw new Exception("Unknown player ID!");
    }
	
    
	/**
	 * Find player by first & last name
	 * 
	 * @param string $name
	 * @param string $famil
	 * @return Zend_Db_Table_Row
	 */
	public function findPlayerByName($name, $famil)
	{
		Zend_Registry::get('log')->info("Get Player: '$name $famil'");
		$table = $this->getTable('Players');
        $select = $table->select()->where("imia = ?", $name)->where("famil = ?", $famil);
        return $table->fetchRow($select);
	}
	
	/**
	 * Generate password
	 * 
	 * @return string
	 */
	protected function _generatePassword() 
	{
        for ($i=0; $i < self::CODE_LEN; $i = $i + 2) {
            // generate word with mix of vowels and consonants
            $consonant = self::$CN[array_rand(self::$CN)];
            $vowel     = self::$VN[array_rand(self::$VN)];
            $word     .= $consonant . $vowel;
        }

        if (strlen($word) > self::CODE_LEN) {
            $word = substr($word, 0, self::CODE_LEN);
        }
		return $word;
	}
	
	/**
	 * Create username or change password
	 * 
	 * @param string $mail
	 * @return string new password
	 */
	public function createUserPassword($mail, $tid)
	{
		$users = $this->getTable('Users');
		$oldusr = $users->find($mail);
		$pwd = $this->_generatePassword();
		if($oldusr) {
			if($oldusr->tid != $tid) {
				throw new Exception("Мейл $mail заргистрирован для другой команды!");
			}
			$oldusr->password = $pwd;
			$oldusr->save();
			Zend_Registry::get('log')->info("Saved password for: '$mail'");
		} else {
			$users->insert(array(
				"email" => $mail,
				"password" => $pwd,
				"tid" => $tid,
			));
			Zend_Registry::get('log')->info("Created password for: '$mail'");
		}
		
		return $pwd;
	}
}

