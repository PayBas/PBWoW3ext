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

class release_3_0_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\paybas\pbwow\migrations\profile_fields_3_0_0');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'bump_pb_wow_level'))),
		);
	}

	public function revert_schema()
	{
		return array(
			array('custom', array(array($this, 'revert_pb_wow_level'))),
		);
	}

	public function bump_pb_wow_level()
	{
		$sql = 'UPDATE ' . PROFILE_FIELDS_TABLE . ' SET field_maxlen = 100 WHERE field_name = "pb_wow_level"';
		$this->db->sql_query($sql);
	}

	public function revert_pb_wow_level()
	{
		$sql = 'UPDATE ' . PROFILE_FIELDS_TABLE . ' SET field_maxlen = 90 WHERE field_name = "pb_wow_level"';
		$this->db->sql_query($sql);
	}
}
