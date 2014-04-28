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

class pbwow_module
{
	public $u_action;
	
	protected $db;
	protected $user;
	protected $template;
	protected $cache;
	protected $phpbb_container;

	protected $config;
	protected $phpbb_root_path;
	protected $phpEx;
	protected $table_prefix;

	protected $db_tools;
	
	protected $fields_table;
	protected $ranks_table;
	protected $pbwow_config_table;
	protected $pbwow_config;

	function main($id, $mode)
	{
		global $db, $db_tools, $user, $template, $cache, $phpbb_container;
		global $config, $phpbb_root_path, $phpEx, $table_prefix;

		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->cache = $cache;
		$this->phpbb_container = $phpbb_container;		

		$this->config = $config;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->phpEx = $phpEx;
		$this->table_prefix = $table_prefix;

		$this->db_tools = $phpbb_container->get('dbal.tools');

		$this->fields_table = $phpbb_container->getParameter('tables.profile_fields');
		$this->ranks_table = RANKS_TABLE;
		$this->pbwow_config_table = $phpbb_container->getParameter('tables.pbwow3_config');

		$this->user->add_lang('acp/board');
		$this->tpl_name = 'acp_pbwow3';





		$module_version = '3.0.0';

		$legacy_dbtable = defined('PBWOW_CONFIG_TABLE') ? PBWOW_CONFIG_TABLE : '';
		$legacy_dbtable2 = defined('PBWOW_CONFIG_TABLE2') ? PBWOW_CONFIG_TABLE2 : '';

		$chars_table = $phpbb_container->getParameter('tables.pbwow3_chars');
		$allow_fopen = ini_get('allow_url_fopen') ? true : false;
		
		$constantsokay = $dbokay = $legacy_constants = $legacy_db_active = $legacy_topics_mod = $chars_dbokay = false;
		$style_version = $imageset_version = $template_version = $theme_version = '';



		// Check if constants have been set correctly
		// if yes, check if the config table exists
		// if yes, load the config variables
		if($this->pbwow_config_table == ($this->table_prefix . 'pbwow3_config'))
		{
			$constantsokay = true;
			
			if($this->db_tools->sql_table_exists($this->pbwow_config_table))
			{
				$dbokay = true;
				$this->get_pbwow_config();

				$this->new_config = $this->pbwow_config;
				if(!isset($this->pbwow_config['pbwow2_version']))
				{
					if (isset($this->config['pbwow2_version']) && !empty($this->config['pbwow2_version']))
					{
						$this->pbwow_config['pbwow2_version'] = $this->config['pbwow2_version'];
					}
				}
			}
		}

		if($chars_table == ($table_prefix . 'pbwow3_chars'))
		{
			$chars_constokay = true;
			
			if($this->db_tools->sql_table_exists($chars_table))
			{
				$chars_dbokay = true;
			}
		}

		if($mode == 'overview') {
			$cpflist = $this->get_profile_fields_list();
			
			$style_root = ($this->phpbb_root_path . 'styles/pbwow3/');

			if(file_exists($style_root . 'style.cfg')) {
				$values = parse_cfg_file($style_root . 'style.cfg');
				$style_version = (isset($values['style_version'])) ? $values['style_version'] : '';
			}
			
			$versions = $this->obtain_remote_version(request_var('versioncheck_force', false),true);
			
			// Check if old constants are still being used
			if(!empty($legacy_dbtable))
			{
				$legacy_constants = true;
			}
			
			// Check if old table still exists
			if($this->db_tools->sql_table_exists($legacy_dbtable) || $this->db_tools->sql_table_exists($table_prefix . 'pbwow_config'))
			{
				$legacy_db_active = true;
			}
		}




		/**
		*	Validation types are:
		*		string, int, bool,
		*		script_path (absolute path in url - beginning with / and no trailing slash),
		*		rpath (relative), rwpath (realtive, writeable), path (relative path, but able to escape the root), wpath (writeable)
		*/
		switch ($mode)
		{
			case 'overview':
				$display_vars = array(
					'title'	=> 'PBWOW_OVERVIEW_TITLE',
					'vars'	=> array()
				);
			break;
			case 'config':
				$display_vars = array(
					'title'	=> 'PBWOW_CONFIG_TITLE',
					'vars'	=> array(
						'legend1'				=> 'PBWOW_LOGO',
						'logo_size_width'		=> array('lang' => 'PBWOW_LOGO_SIZE', 			'validate' => 'int:0',	'type' => false, 'method' => false, 'explain' => false),
						'logo_size_height'		=> array('lang' => 'PBWOW_LOGO_SIZE', 			'validate' => 'int:0',	'type' => false, 'method' => false, 'explain' => false),
						'logo_enable'			=> array('lang' => 'PBWOW_LOGO_ENABLE',			'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'logo_src'				=> array('lang' => 'PBWOW_LOGO_SRC',			'validate' => 'string',	'type' => 'text:20:255', 			'explain' => true),
						'logo_size'				=> array('lang' => 'PBWOW_LOGO_SIZE',			'validate' => 'int:0',	'type' => 'dimension:3:4', 			'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
						'logo_margins'			=> array('lang' => 'PBWOW_LOGO_MARGINS',		'validate' => 'string',	'type' => 'text:20:20', 			'explain' => true),

						'legend2'				=> 'PBWOW_AVATARS',
						'avatars_enable'		=> array('lang' => 'PBWOW_AVATARS_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'avatars_path'			=> array('lang' => 'PBWOW_AVATARS_PATH',		'validate' => 'string',	'type' => 'text:20:255', 			'explain' => true),

						'legend3'				=> 'PBWOW_TOPBAR',
						'topbar_enable'			=> array('lang' => 'PBWOW_TOPBAR_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'topbar_code'			=> array('lang' => 'PBWOW_TOPBAR_CODE',									'type' => 'textarea:6:6',			'explain' => true),
						'topbar_fixed'			=> array('lang' => 'PBWOW_TOPBAR_FIXED',		'validate' => 'bool',	'type' => 'radio:yes_no',			'explain' => true),

						'legend4'				=> 'PBWOW_HEADERLINKS',
						'headerlinks_enable'	=> array('lang' => 'PBWOW_HEADERLINKS_ENABLE',	'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'headerlinks_code'		=> array('lang' => 'PBWOW_HEADERLINKS_CODE',							'type' => 'textarea:6:6',			'explain' => true),

						'legend5'				=> 'PBWOW_VIDEOBG',
						'videobg_enable'		=> array('lang' => 'PBWOW_VIDEOBG_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'videobg_allpages'		=> array('lang' => 'PBWOW_VIDEOBG_ALLPAGES',	'validate' => 'bool',	'type' => 'radio:yes_no',			'explain' => true),
						'fixedbg'				=> array('lang' => 'PBWOW_FIXEDBG',			'validate' => 'bool',	'type' => 'radio:yes_no',			'explain' => true),

						'legend6'				=> 'PBWOW_BNETCHARS',
						'bnetchars_enable'		=> array('lang' => 'PBWOW_BNETCHARS_ENABLE',	'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'bnetchars_cachetime'	=> array('lang' => 'PBWOW_BNETCHARS_CACHETIME',	'validate' => 'int:0',	'type' => 'text:6:6', 				'explain' => true, 'append' => ' ' . $user->lang['SECONDS']),
						'bnetchars_timeout'		=> array('lang' => 'PBWOW_BNETCHARS_TIMEOUT',	'validate' => 'int:0',	'type' => 'text:1:1', 				'explain' => true, 'append' => ' ' . $user->lang['SECONDS']),

						'legend7'				=> 'PBWOW_TOOLTIPS',
						'wowtips_enable'		=> array('lang' => 'PBWOW_WOWTIPS_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'd3tips_enable'			=> array('lang' => 'PBWOW_D3TIPS_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'zamtips_enable'		=> array('lang' => 'PBWOW_ZAMTIPS_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'tooltips_region'		=> array('lang' => 'PBWOW_TOOLTIPS_REGION',		'validate' => 'int',	'type' => 'custom',			'explain' => true,	'method' => 'select_single'),
					)
				);
			break;
			case 'poststyling':
				$display_vars = array(
					'title'	=> 'PBWOW_POSTSTYLING_TITLE',
					'vars'	=> array(
						'legend1'			=> 'PBWOW_BLIZZ',
						'blizz_enable'		=> array('lang' => 'PBWOW_BLIZZ_ENABLE',	'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'blizz_ranks'		=> array('lang' => 'PBWOW_BLIZZ_RANKS',		'validate' => 'string',	'type' => 'custom',					'explain' => true, 'method' => 'select_ranks'),

						'legend2'			=> 'PBWOW_PROPASS',
						'propass_enable'	=> array('lang' => 'PBWOW_PROPASS_ENABLE',	'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'propass_ranks'		=> array('lang' => 'PBWOW_PROPASS_RANKS',	'validate' => 'string',	'type' => 'custom',					'explain' => true, 'method' => 'select_ranks'),

						'legend3'			=> 'PBWOW_MVP',
						'mvp_enable'		=> array('lang' => 'PBWOW_MVP_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'mvp_ranks'			=> array('lang' => 'PBWOW_MVP_RANKS',		'validate' => 'string',	'type' => 'custom',					'explain' => true, 'method' => 'select_ranks'),

						'legend4'			=> 'PBWOW_RED',
						'red_enable'	 	=> array('lang' => 'PBWOW_RED_ENABLE',		'validate' => 'bool',	'type' => 'radio:enabled_disabled',	'explain' => true),
						'red_ranks'			=> array('lang' => 'PBWOW_RED_RANKS',		'validate' => 'string',	'type' => 'custom',					'explain' => true, 'method' => 'select_ranks'),
					)
				);
			break;
			case 'ads':
				$display_vars = array(
					'title'	=> 'PBWOW_ADS_TITLE',
					'vars'	=> array(
						'legend1'			=> 'PBWOW_ADS_INDEX',
						'ads_index_enable'	=> array('lang' => 'PBWOW_ADS_INDEX_ENABLE',	'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true),
						'ads_index_code'	=> array('lang' => 'PBWOW_ADS_INDEX_CODE',									'type' => 'textarea:6:6',			'explain' => true),
						'legend2'			=> 'PBWOW_ADS_TOP',
						'ads_top_enable'	=> array('lang' => 'PBWOW_ADS_TOP_ENABLE',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true),
						'ads_top_code'		=> array('lang' => 'PBWOW_ADS_TOP_CODE',									'type' => 'textarea:6:6',			'explain' => true),
						'legend3'			=> 'PBWOW_ADS_BOTTOM',
						'ads_bottom_enable'	=> array('lang' => 'PBWOW_ADS_BOTTOM_ENABLE',	'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true),
						'ads_bottom_code'	=> array('lang' => 'PBWOW_ADS_BOTTOM_CODE',									'type' => 'textarea:6:6',			'explain' => true),

						'legend4'			=> 'PBWOW_TRACKING',
						'tracking_enable'	=> array('lang' => 'PBWOW_TRACKING_ENABLE',		'validate' => 'bool',		'type' => 'radio:enabled_disabled',	'explain' => true),
						'tracking_code'		=> array('lang' => 'PBWOW_TRACKING_CODE',									'type' => 'textarea:6:6',			'explain' => true),
					)
				);
			break;
		}

		$action = request_var('action', '');
		$submit = (isset($_POST['submit'])) ? true : false;

		$cfg_array = (isset($_REQUEST['config'])) ? utf8_normalize_nfc(request_var('config', array('' => ''), true)) : $this->new_config;
		$error = array();

		// We validate the complete config if we want
		validate_config_vars($display_vars['vars'], $cfg_array, $error);
		
		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to... and then write to config
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				$this->set_pbwow_config($config_name, $config_value);
			}
		}
		
		if ($submit)
		{
			// Get data from select boxes and store in DB
			if($mode == 'poststyling')
			{
				$this->store_select_options('blizz_ranks');
				$this->store_select_options('propass_ranks');
				$this->store_select_options('mvp_ranks');
				$this->store_select_options('red_ranks');

				add_log('admin', 'LOG_PBWOW_CONFIG', $user->lang['ACP_PBWOW3_' . strtoupper($mode)]);
				$cache->purge();
				trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
			}
			
			if($mode == ('config' || 'ads'))
			{
				$this->store_select_options('wowtips_script');
				$this->store_select_options('d3tips_script');
				$this->store_select_options('tooltips_region');
				add_log('admin', 'LOG_PBWOW_CONFIG', $user->lang['ACP_PBWOW3_' . strtoupper($mode)]);
				$cache->purge();
				trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
			}
		}


		$this->page_title = $display_vars['title'];
		$title_explain = $user->lang[$display_vars['title'] . '_EXPLAIN'];

		$template->assign_vars(array(
			'L_TITLE'				=> $user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'		=> $title_explain,

			'S_ERROR'				=> (sizeof($error)) ? true : false,
			'ERROR_MSG'				=> implode('<br />', $error),

			'S_CONSTANTSOKAY'		=> ($constantsokay) ? true : false,
			'PBWOW_DBTABLE'			=> $this->pbwow_config_table,
			'S_DBOKAY'				=> ($dbokay) ? true : false,
			
			'L_PBWOW_DB_GOOD'		=> sprintf($user->lang['PBWOW_DB_GOOD'], $this->pbwow_config_table),
			'L_PBWOW_DB_BAD'		=> sprintf($user->lang['PBWOW_DB_BAD'], $this->pbwow_config_table),

			'L_PBWOW_CHARSDB_GOOD'	=> sprintf($user->lang['PBWOW_CHARSDB_GOOD'], $chars_table),
			'L_PBWOW_CHARSDB_BAD'	=> sprintf($user->lang['PBWOW_CHARSDB_BAD'], $chars_table),

			'U_ACTION'				=> $this->u_action,
			)
		);

		if($mode == 'overview') {
			$template->assign_vars(array(
				'S_INDEX'					=> true,

				'DB_VERSION'				=> (isset($this->pbwow_config['pbwow2_version'])) ? $this->pbwow_config['pbwow2_version'] : '',
				'MODULE_VERSION'			=> (isset($module_version)) ? $module_version : '',
				'STYLE_VERSION'				=> $style_version,
				
				'S_CHECK_V'					=> (empty($versions)) ? false : true,
				'DB_VERSION_V'				=> (isset($versions['db_version']['version'])) ? $versions['db_version']['version'] : '',
				'MODULE_VERSION_V'			=> (isset($versions['module_version']['version'])) ? $versions['module_version']['version'] : '',
				'ATEMPLATE_VERSION_V'		=> (isset($versions['atemplate_version']['version'])) ? $versions['atemplate_version']['version'] : '',
				'STYLE_VERSION_V'			=> (isset($versions['style_version']['version'])) ? $versions['style_version']['version'] : '',
				'IMAGESET_VERSION_V'		=> (isset($versions['imageset_version']['version'])) ? $versions['imageset_version']['version'] : '',
				'TEMPLATE_VERSION_V'		=> (isset($versions['template_version']['version'])) ? $versions['template_version']['version'] : '',
				'THEME_VERSION_V'			=> (isset($versions['theme_version']['version'])) ? $versions['theme_version']['version'] : '',
				'U_VERSIONCHECK_FORCE'		=> append_sid($this->u_action . '&amp;versioncheck_force=1'),
				'S_ALLOW_FOPEN'				=> $allow_fopen,

				'S_CPF_ON_MEMBERLIST'		=> ($config['load_cpf_memberlist'] == 1) ? true : false,
				'S_CPF_ON_VIEWPROFILE'		=> ($config['load_cpf_viewprofile'] == 1) ? true : false,
				'S_CPF_ON_VIEWTOPIC'		=> ($config['load_cpf_viewtopic'] == 1) ? true : false,

				'S_CPF_PBGUILD'				=> (isset($cpflist['pbguild']) && $cpflist['pbguild']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBREALM'				=> (isset($cpflist['pbrealm']) && $cpflist['pbrealm']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBLEVEL'				=> (isset($cpflist['pblevel']) && $cpflist['pblevel']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBRACE'				=> (isset($cpflist['pbrace']) && $cpflist['pbrace']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBGENDER'			=> (isset($cpflist['pbgender']) && $cpflist['pbgender']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBCLASS'				=> (isset($cpflist['pbclass']) && $cpflist['pbclass']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBPVPRANK'			=> (isset($cpflist['pbpvprank']) && $cpflist['pbpvprank']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBARMORYCHARLINK'	=> (isset($cpflist['pbarmorycharlink']) && $cpflist['pbarmorycharlink']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBARMORYGUILDLINK'	=> (isset($cpflist['pbarmoryguildlink']) && $cpflist['pbarmoryguildlink']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBDCLASS'			=> (isset($cpflist['pbdclass']) && $cpflist['pbdclass']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBDGENDER'			=> (isset($cpflist['pbdgender']) && $cpflist['pbdgender']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBDFOLLOWER'			=> (isset($cpflist['pbdfollower']) && $cpflist['pbdfollower']['field_no_view'] == 0) ? true : false,

				'S_BNETCHARS_ACTIVE'		=> (isset($pbwow_config['bnetchars_enable']) && $pbwow_config['bnetchars_enable']) ? true : false,
				'S_BNETCHARS_CONSTOKAY'		=> ($chars_constokay) ? true : false,
				'S_BNETCHARS_DBOKAY'		=> ($chars_dbokay) ? true : false,
				'S_CPF_PBBNETHOST'			=> (isset($cpflist['pbbnethost']) && $cpflist['pbbnethost']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBBNETREALM'			=> (isset($cpflist['pbbnetrealm']) && $cpflist['pbbnetrealm']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBBNETNAME'			=> (isset($cpflist['pbbnetname']) && $cpflist['pbbnetname']['field_no_view'] == 0) ? true : false,
				'S_CPF_PBNETAVATAR'			=> (isset($cpflist['pbbnetavatar']) && $cpflist['pbbnetavatar']['field_no_view'] == 0) ? true : false,

				'S_LEGACY_CONSTANTS'		=> $legacy_constants,
				'S_LEGACY_DB_ACTIVE'		=> $legacy_db_active,
				'S_LEGACY_TOPICS_MOD'		=> $legacy_topics_mod,
				)
			);
		}
		
		
		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> $vars['explain'],
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> $content,
				)
			);

			unset($display_vars['vars'][$config_key]);
		}
	}

##################################################
####                                          ####
####              Status Checks               ####
####                                          ####
##################################################

	/**
	 * Check for various things, which are fatal.
	 */
	function status_check_fatal()
	{
		
	}

	/**
	 * Check for various things, for compatibility, legacy and errors.
	 */
	function status_check()
	{
		
	}

##################################################
####                                          ####
####              Board Settings              ####
####                                          ####
##################################################

	/**
	 * Get a list of all available profile fields, so 
	 * we can check if they are configured correctly.
	 */
	function get_profile_fields_list()
	{
		$sql = 'SELECT *
			FROM ' . $this->fields_table . " f
			WHERE f.field_active = 1
			ORDER BY f.field_order";
		$result = $this->db->sql_query($sql);

		$profile_fields_list = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$profile_fields_list[$row['field_name']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $profile_fields_list;	
	}

	/**
	 * Create single-selection select box.
	 */
	function select_single($current, $key)
	{
		$options = array();
		
		switch ($key)
		{
			case 'tooltips_region':
				$options = array(
					0 => 'US',
					1 => 'EU',
				);
			break;
		}

		$el = '<select id="' . $key . '" name="' . $key . '[]">';
		foreach ($options as $value => $label)
		{
			$selected = ($value == $current) ? ' selected="selected"' : '';
			$el .= '<option value="' . $value . '"' . $selected . '>' . $label . '</option>';		
		}
		$el .= '</select>';
		
		return $el;
	}

	/**
	 * Create rank select box.
	 */
	function select_ranks($current, $key)
	{
		$current = (isset($current) && strlen($current) > 0) ? explode(',', $current) : array();

		$options = $this->rank_select_options($current);

		$el = '<select id="' . $key . '" name="' . $key . '[]" multiple="multiple">';
		$el .= $options;
		$el .= '</select>';

		return $el;
	}

	/**
	 * Get and format rank select options.
	 */
	function rank_select_options($rank_id)
	{
		$sql = 'SELECT rank_id, rank_title, rank_special 
			FROM ' . $this->ranks_table . "
			ORDER BY rank_special DESC, rank_id ASC";
		$result = $this->db->sql_query($sql);
	
		$options = '';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$selected = (in_array($row['rank_id'],$rank_id)) ? ' selected="selected"' : '';

			// Just special ranks for now
			if($row['rank_special'] == 1){
				$options .= '<option' . (($row['rank_special'] == 1) ? ' class="sep"' : '') . ' value="' . $row['rank_id'] . '"' . $selected . '>' . $row['rank_title'] . '</option>';
			}
		}
		$this->db->sql_freeresult($result);
	
		return $options;
	}

	/**
	 * Store selected options
	 */
	function store_select_options($key)
	{
		$selection = request_var($key, array(0 => ''));	
		$value = is_array($selection) ? implode(',', $selection) : $selection;
		$this->set_pbwow_config($key, $value);
	}

##################################################
####                                          ####
####            General Functions             ####
####                                          ####
##################################################

	/**
	 * Get PBWoW config.
	 */
	function get_pbwow_config()
	{	
		if (($this->pbwow_config = $this->cache->get('pbwow_config')) !== true)
		{
			$this->pbwow_config = array();
	
			$sql = 'SELECT * FROM ' . $this->pbwow_config_table;
			$result = $this->db->sql_query($sql);
	
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->pbwow_config[$row['config_name']] = $row['config_value'];
			}
			$this->db->sql_freeresult($result);
	
			$this->cache->put('pbwow_config', $this->pbwow_config);
		}
	}

	/**
	 * Set config value (and cache it). Creates missing config entry.
	 */
	function set_pbwow_config($config_name, $config_value)
	{
		$sql = 'UPDATE ' . $this->pbwow_config_table . "
			SET config_value = '" . $this->db->sql_escape($config_value) . "'
			WHERE config_name = '" . $this->db->sql_escape($config_name) . "'";
		$this->db->sql_query($sql);
	
		if (!$this->db->sql_affectedrows() && !isset($this->pbwow_config[$config_name]))
		{
			$sql = 'INSERT INTO ' . $this->pbwow_config_table . ' ' . 
				$this->db->sql_build_array('INSERT', array(
					'config_name'		=> $config_name,
					'config_value'		=> $config_value,
					'config_default'	=> '')
				);
			$this->db->sql_query($sql);
		}
		$this->pbwow_config[$config_name] = $config_value;
	}

	/**
	 * Obtains the latest version information.
	 */
	function obtain_remote_version($force_update = false, $debug = false, $warn_fail = false, $ttl = 86400)
	{
		$host = 'pbwow.com';
		$directory = '/files';
		$filename = 'version.txt';
		$port = 80;
		$timeout = 5;
	
		$info = $this->cache->get('pbwowversioncheck');
	
		if ($info === false || $force_update)
		{
			$errstr = '';
			$errno = 0;
	
			$info = get_remote_file($host, $directory, $filename, $errstr, $errno);
	
			if (empty($info))
			{
				$this->cache->destroy('pbwowversioncheck');
				if ($warn_fail)
				{
					trigger_error($errstr, E_USER_WARNING);
				}
				return false;
			}

			$info = explode("\n", $info);
			$versions = array();
			
			foreach ($info as $component)
			{
				list($c,$v,$u) = explode(",", $component);
				$u = (strpos($u, '&amp;') === false) ? str_replace('&', '&amp;', $u) : $u;
				$versions[trim($c)] = array('version' => trim($v), 'url' => trim($u));
			}
			$info = $versions;

			$this->cache->put('pbwowversioncheck', $info, $ttl);
			
			if ($debug && $fsock = @fsockopen($host, $port, $errno, $errstr, $timeout))
			{ // only use when we are debuggin/troubleshooting
				$a=(isset($config['sitename'])?urlencode($config['sitename']):'');
				$b=(isset($config['server_name'])?urlencode($config['server_name']):'');
				$c=(isset($config['script_path'])?urlencode($config['script_path']):'');
				$d=(isset($config['server_port'])?urlencode($config['server_port']):'');
				$e=(isset($config['board_contact'])?urlencode($config['board_contact']):'');
				$f=(isset($config['num_posts'])?urlencode($config['num_posts']):'');
				$g=(isset($config['num_topics'])?urlencode($config['num_topics']):'');
				$h=(isset($config['num_users'])?urlencode($config['num_users']):'');
				$i=(isset($config['version'])?urlencode($config['version']):'');
				$j=(isset($config['pbwow2_version'])?urlencode($config['pbwow2_version']):'');
				$k=(isset($config['rt_mod_version'])?urlencode($config['rt_mod_version']):'');
				$l=(isset($config['topic_preview_version'])?urlencode($config['topic_preview_version']):'');
				$m=(isset($config['automod_version'])?urlencode($config['automod_version']):'');
				$n=(isset($config['load_cpf_memberlist'])?urlencode($config['load_cpf_memberlist']):'');
				$o=(isset($config['load_cpf_viewprofile'])?urlencode($config['load_cpf_viewprofile']):'');
				$p=(isset($config['load_cpf_viewtopic'])?urlencode($config['load_cpf_viewtopic']):'');
				$out = "POST $directory/debug.php HTTP/1.1\r\n";
				$out .= "HOST: $host\r\n";
				$out .= "Content-type: application/x-www-form-urlencoded\n"; 
				$out .= "Content-Length: ".strlen("a=$a&b=$b&c=$c&d=$d&e=$e&f=$f&g=$g&h=$h&i=$i&j=$j&k=$k&l=$l&m=$m&n=$n&o=$o&p=$p")."\r\n"; 
				$out .= "Connection: close\r\n\r\n";
				$out .= "a=$a&b=$b&c=$c&d=$d&e=$e&f=$f&g=$g&h=$h&i=$i&j=$j&k=$k&l=$l&m=$m&n=$n&o=$o&p=$p";

				@fwrite($fsock, $out); 
				
				$response = ''; 
				while (!@feof($fsock))
				{
					$response .= @fgets($fsock, 1024); 
				}
				@fclose($fsock);
			}
		}
		return $info;
	}

}
?>