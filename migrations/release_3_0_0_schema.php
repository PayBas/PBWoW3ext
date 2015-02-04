<?php
/**
 *
 * @package PBWoW Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paybas\pbwow\migrations;

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
