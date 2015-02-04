<?php
/**
 *
 * @package PBWoW Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paybas\pbwow\migrations;

class characters_3_0_0_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\paybas\pbwow\migrations\profile_fields_3_0_0');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'pbwow3_chars' => array(
					'COLUMNS' => array(
						'id' 				=> array('UINT', NULL, 'auto_increment'),
						'user_id' 			=> array('UINT', NULL),
						'updated'			=> array('BINT', 0),
						'tries'				=> array('TINT:3', 0),
						'game'				=> array('VCHAR', ''),
						'lastModified'		=> array('BINT', 0),
						'name'				=> array('VCHAR', ''),
						'realm'				=> array('VCHAR', ''),
						'battlegroup'		=> array('VCHAR', ''),
						'class'				=> array('TINT:3', 0),
						'race'				=> array('TINT:3', 0),
						'gender'			=> array('TINT:3', 0),
						'level'				=> array('TINT:3', 0),
						'achievementPoints'	=> array('UINT', 0),
						'URL'				=> array('VCHAR', ''),
						'avatar'			=> array('VCHAR', ''),
						'avatarURL'			=> array('VCHAR', ''),
						'calcClass'			=> array('VCHAR', ''),
						'totalHK'			=> array('UINT', 0),
						'guild'				=> array('VCHAR', ''),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'            => array(
						'user_id'    => array('INDEX', 'user_id'),
					),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'pbwow3_chars',
			),
		);
	}
}
