<?php

/**
*
* @package PBWoW Extension
* @copyright (c) 2014 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace paybas\pbwow\acp;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
    exit;
}

class pbwow_info
{
    function module()
    {
        return array(
            'filename'  => '\paybas\pbwow\acp\pbwow_module',
            'title'     => 'ACP_PBWOW3_CATEGORY',
            'version'   => '3.0.0',
            'modes'     => array(
				'overview'		=> array('title' => 'ACP_PBWOW3_OVERVIEW', 		'auth' => 'acl_a_board', 'cat' => array('ACP_PBWOW3_CATEGORY')),
				'config'		=> array('title' => 'ACP_PBWOW3_CONFIG', 		'auth' => 'acl_a_board', 'cat' => array('ACP_PBWOW3_CATEGORY')),
				'poststyling'	=> array('title' => 'ACP_PBWOW3_POSTSTYLING', 	'auth' => 'acl_a_board', 'cat' => array('ACP_PBWOW3_CATEGORY')),
				'ads'			=> array('title' => 'ACP_PBWOW3_ADS', 			'auth' => 'acl_a_board', 'cat' => array('ACP_PBWOW3_CATEGORY')),
            ),
        );
    }
}

?>