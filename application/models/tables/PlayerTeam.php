<?php

/**
 * PlayerTeam
 *  
 * @author stas
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Reg2_Models_Tables_PlayerTeam extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'igrok_team';
	
	protected $_referenceMap    = array(
        'Team' => array(
            'columns'           => array('tid'),
            'refTableClass'     => 'Reg2_Models_Tables_Teams',
            'refColumns'        => array('tid')
        ),
        'Player' => array(
            'columns'           => array('uid'),
            'refTableClass'     => 'Reg2_Models_Tables_Players',
            'refColumns'        => array('uid')
        )
    );

}

