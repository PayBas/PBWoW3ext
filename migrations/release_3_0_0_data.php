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

class release_3_0_0_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\paybas\pbwow\migrations\release_3_0_0_schema');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'pbwow_populate_data'))),
		);
	}

	public function pbwow_populate_data()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'pbwow3_config'))
		{
			$sql = 'SELECT * FROM ' . $this->table_prefix . 'pbwow3_config';
			$result = $this->db->sql_query_limit($sql, 1);
			$row = $this->db->sql_fetchrow($result);

			if (!empty($row))
			{
				return;
			}
		} else {
			return;
		}

		$sql_ary = array(
			// Post styling
			array(
				'config_name' => 'blizz_enable',
				'config_value' => '1',
				'config_default' => '0',
			),
			array(
				'config_name' => 'blizz_ranks',
				'config_value' => '1',
				'config_default' => '0',
			),
			array(
				'config_name' => 'propass_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'propass_ranks',
				'config_value' => '',
				'config_default' => '',
			),
			array(
				'config_name' => 'mvp_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'mvp_ranks',
				'config_value' => '',
				'config_default' => '',
			),
			array(
				'config_name' => 'red_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'red_ranks',
				'config_value' => '',
				'config_default' => '',
			),

			// Ads
			array(
				'config_name' => 'ads_index_enable',
				'config_value' => '1',
				'config_default' => '1',
			),
			array(
				'config_name' => 'ads_index_code',
				'config_value' => '<a class="donate-button" href="http://pbwow.com/donate/"></a>',
				'config_default' => '<a class="donate-button" href="http://pbwow.com/donate/"></a>',
			),
			array(
				'config_name' => 'ads_top_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'ads_top_code',
				'config_value' => '',
				'config_default' => '',
			),
			array(
				'config_name' => 'ads_bottom_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'ads_bottom_code',
				'config_value' => '',
				'config_default' => '',
			),
			array(
				'config_name' => 'tracking_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'tracking_code',
				'config_value' => '',
				'config_default' => '',
			),

			// Global styling
			array(
				'config_name' => 'topbar_enable',
				'config_value' => '1',
				'config_default' => '1',
			),
			array(
				'config_name' => 'topbar_code',
				'config_value' => '<li class="you"><strong>Hi there! This is a welcome message</strong></li>
<li class="can link"><a href="http://pbwow.com/forum/">PBWoW</a></li>
<li class="name link"><a href="https://www.phpbb.com/">phpBB</a></li>
<li class="them link rightside"><a href="#">On the right</a></li>',
				'config_default' => '',
			),
			array(
				'config_name' => 'topbar_fixed',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'videobg_enable',
				'config_value' => '1',
				'config_default' => '1',
			),
			array(
				'config_name' => 'videobg_allpages',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'fixedbg',
				'config_value' => '0',
				'config_default' => '0',
			),

			// Logo
			array(
				'config_name' => 'logo_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'logo_src',
				'config_value' => 'images/logo.png',
				'config_default' => 'images/logo.png',
			),
			array(
				'config_name' => 'logo_size_width',
				'config_value' => '300',
				'config_default' => '300',
			),
			array(
				'config_name' => 'logo_size_height',
				'config_value' => '180',
				'config_default' => '180',
			),
			array(
				'config_name' => 'logo_margins',
				'config_value' => '10px 10px 25px 10px',
				'config_default' => '10px 10px 25px 10px',
			),

			// Tooltips
			array(
				'config_name' => 'wowtips_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'd3tips_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'zamtips_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'tooltips_region',
				'config_value' => '0',
				'config_default' => '0',
			),

			// Miscellaneous
			array(
				'config_name' => 'headerlinks_enable',
				'config_value' => '1',
				'config_default' => '1',
			),
			array(
				'config_name' => 'headerlinks_code',
				'config_value' => '<li class="icon-custom2 small-icon"><a href="http://www.phpbb.com/" target="_blank">phpBB</a></li>
<li class="icon-custom1 small-icon"><a href="http://pbwow.com/" target="_blank">PBWoW</a></li>
<li class="icon-dkp small-icon"><a href="http://bbdkp.com/" target="_blank">DKP</a></li>
<li class="icon-portal small-icon"><a href="https://www.phpbb.com/community/viewtopic.php?t=2210281" target="_blank">Portal</a></li>',
				'config_default' => '',
			),

			// Avatars
			array(
				'config_name' => 'avatars_enable',
				'config_value' => '1',
				'config_default' => '1',
			),
			array(
				'config_name' => 'avatars_path',
				'config_value' => 'images/avatars/gaming',
				'config_default' => 'images/avatars/gaming',
			),

			// Battle.net API
			array(
				'config_name' => 'bnetchars_enable',
				'config_value' => '0',
				'config_default' => '0',
			),
			array(
				'config_name' => 'bnetchars_cachetime',
				'config_value' => '86400',
				'config_default' => '86400',
			),
			array(
				'config_name' => 'bnetchars_timeout',
				'config_value' => '1',
				'config_default' => '1',
			),
		);
	
		$sql = $this->db->sql_multi_insert($this->table_prefix . 'pbwow3_config', $sql_ary);
		$this->sql_query($sql);
	}
}