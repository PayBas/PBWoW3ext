<?php

/**
*
* @package PBWoW Extension
* @copyright (c) 2014 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace paybas\pbwow\migrations;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
    exit;
}

class release_3_0_0_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\paybas\pbwow\migrations\release_3_0_0');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'pbwow3_config' => array(
					'COLUMNS' => array(
						'config_name'		=> array('VCHAR', ''),
						'config_value'		=> array('MTEXT', ''),
						'config_default'	=> array('MTEXT', ''),
					),
					'PRIMARY_KEY'	=> 'config_name',
				),
			),
		);
	}
	
	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'pbwow3_config',
			),
		);
	}
}