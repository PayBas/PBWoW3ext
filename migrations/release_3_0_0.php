<?php
/**
 *
 * @package PBWoW Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paybas\pbwow\migrations;

class release_3_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['pbwow3_version']) && version_compare($this->config['pbwow3_version'], '3.0.0', '>=');
	}

	public function update_data()
	{
		return array(
			array('if', array(
				(isset($this->config['pbwow2_version'])),
				array('config.remove', array('pbwow2_version')),
			)),
			array('config.add', array('pbwow3_version', '3.0.0')),

			array('if', array(
				array('module.exists', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_OVERVIEW')),
				array('module.remove', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_OVERVIEW')),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_CONFIG')),
				array('module.remove', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_CONFIG')),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_POSTSTYLING')),
				array('module.remove', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_POSTSTYLING')),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_ADS')),
				array('module.remove', array('acp', 'ACP_PBWOW2_CATEGORY', 'ACP_PBWOW2_ADS')),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_PBWOW2_CATEGORY')),
				array('module.remove', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_PBWOW2_CATEGORY')),
			)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_PBWOW3_CATEGORY'
			)),

			array('module.add', array(
				'acp',
				'ACP_PBWOW3_CATEGORY',
				array(
					'module_basename'	=> '\paybas\pbwow\acp\pbwow_module',
					'modes'	=> array('overview', 'config'),
				),
			)),
		);
	}
}
