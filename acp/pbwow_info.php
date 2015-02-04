<?php
/**
 *
 * @package PBWoW Extension
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace paybas\pbwow\acp;

class pbwow_info
{
	function module()
	{
		return array(
			'filename' => '\paybas\pbwow\acp\pbwow_module',
			'title'    => 'ACP_PBWOW3_CATEGORY',
			'modes'    => array(
				'overview' => array('title' => 'ACP_PBWOW3_OVERVIEW', 'auth' => 'ext_paybas/pbwow && acl_a_board', 'cat' => array('ACP_PBWOW3_CATEGORY')),
				'config'   => array('title' => 'ACP_PBWOW3_CONFIG', 'auth' => 'ext_paybas/pbwow && acl_a_board', 'cat' => array('ACP_PBWOW3_CATEGORY')),
			),
		);
	}
}
