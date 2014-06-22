<?php

/**
*
* @package PBWoW Extension
* @copyright (c) 2014 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace paybas\pbwow\core;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
    exit;
}

class pbwow
{

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;
	
	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\db\tools */
	protected $db_tools;

	/** @var \phpbb\profilefields\manager */
	protected $profilefields_manager;

	/** @var \phpbb\template\template */
	protected $template;
	
	/** @var \phpbb\user */
	protected $user;
	
	/** @var string phpBB root path */
	protected $root_path;
	
	/** @var string PHP extension */
	protected $phpEx;

	protected $pbwow_config_table;
	protected $pbwow_chars_table;
	protected $pbwow_config;

	protected $ranks;

	public function __construct(\phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\db\driver\driver $db, \phpbb\db\tools $db_tools, \phpbb\profilefields\manager $profilefields_manager, \phpbb\template\template $template, \phpbb\user $user, $root_path, $phpEx, $pbwow_config_table, $pbwow_chars_table)
	{
		$this->config = $config;
		$this->cache = $cache;
		$this->db = $db;
		$this->db_tools = $db_tools;
		$this->profilefields_manager = $profilefields_manager;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
		
		$this->pbwow_config_table = $pbwow_config_table;
		$this->pbwow_chars_table = $pbwow_chars_table;
		$this->get_pbwow_config();
	}


	/**
	* Assign global template vars, based on the ACP config of the extension
	*/
	public function global_style_append($event)
	{		
		$pbwow_config = $this->pbwow_config;
		
		if(isset($pbwow_config) && is_array($pbwow_config))
		{
			extract($pbwow_config);
		} else {
			return;
		}

		$tpl_vars = array();
		$body_class = ' pbwow-on';

		// Add the style name to the body class
		$style_id = $this->template->get_user_style();
		$body_class .= isset($style_id[0]) ? ' ' . $style_id[0] : '';

		// Logo
		if($logo_enable && isset($logo_src) && isset($logo_size_width) && isset($logo_size_height) && $logo_size_width > 1 && $logo_size_height > 1)
		{
			$tpl_vars += array(
				'S_PBLOGO' => true,
				'PBLOGO_SRC' => html_entity_decode($logo_src),
				'PBLOGO_WIDTH' => $logo_size_width,
				'PBLOGO_HEIGHT' => $logo_size_height,
				'PBLOGO_WIDTH_MOB' => floor(($logo_size_width * 0.8)),
				'PBLOGO_HEIGHT_MOB' => floor(($logo_size_height * 0.8)),
				'PBLOGO_MARGINS' => $logo_margins,
			);
			if(isset($logo_margins) && strlen($logo_margins) > 0)
			{
				$tpl_vars += array(
					'PBLOGO_MARGINS' => $logo_margins,
				);
			}
		}

		// Top-bar
		if($topbar_enable && isset($topbar_code))
		{
			$tpl_vars += array(
				'TOPBAR_CODE' => html_entity_decode($topbar_code),
			);
			$body_class .= ' topbar';

			if($topbar_fixed)
			{
				$tpl_vars += array(
					'S_TOPBAR_FIXED' => true,
				);
				$body_class .= ' topbar-fixed';
			}
		}

		// Video BG
		if($videobg_enable)
		{
			$tpl_vars += array(
				'S_VIDEOBG' => true,
			);
			$body_class .= ' videobg';

			if($videobg_allpages)
			{
				$tpl_vars += array(
					'S_VIDEOBG_ALL' => true,
				);
				$body_class .= ' videobg-all';
			}
		}

		if($fixedbg)
		{
			$tpl_vars += array(
				'S_FIXEDBG' => true,
			);
			$body_class .= ' fixedbg';

			if($topbar_enable && !$topbar_fixed)
			{
				// if we don't do this, scrolling down will look weird
				$body_class .= ' topbar-fixed';
			}
		}

		// Assign vars
		$tpl_vars += array(
			'HEADERLINKS_CODE' 	=> ($headerlinks_enable && isset($headerlinks_code)) ? html_entity_decode($headerlinks_code) : false,

			'WOWTIPS_SCRIPT' 	=> (isset($wowtips_enable) && $wowtips_enable) ? true : false,
			'D3TIPS_SCRIPT' 	=> (isset($d3tips_enable) && $d3tips_enable) ? true : false,
			'ZAMTIPS_SCRIPT' 	=> (isset($zamtips_enable) && $zamtips_enable) ? true : false,
			'TTIPS_REGION'		=> (isset($tooltips_region) && $tooltips_region > 0) ? 'eu' : 'us',

			'ADS_INDEX_CODE' 	=> ($ads_index_enable && isset($ads_index_code)) ? html_entity_decode($ads_index_code) : false,
			'ADS_TOP_CODE' 		=> ($ads_top_enable && isset($ads_top_code)) ? html_entity_decode($ads_top_code) : false,
			'ADS_BOTTOM_CODE' 	=> ($ads_bottom_enable && isset($ads_bottom_code)) ? html_entity_decode($ads_bottom_code) : false,
			'TRACKING_CODE' 	=> ($tracking_enable && isset($tracking_code)) ? html_entity_decode($tracking_code) : false,
		);

		$this->template->assign_vars($tpl_vars);
		$this->template->append_var('BODY_CLASS', $body_class);
	}

	/**
	* Processes the users's profile-field data as soon as it is grabbed from the DB.
	* It will use the profile-field data to try to grab info from the Battle.net API.
	*
	* @var	int|array	$user_ids		Single user id or an array of ids 
	* @var	array		$field_data		Array with profile fields data
	*
	* @return	array	$field_data		Array with modified profile fields data
	*/
	public function process_pf_grab($user_ids, $field_data)
	{
		$pbwow_config = $this->pbwow_config;
		
		if(isset($pbwow_config['bnetchars_enable']) && $pbwow_config['bnetchars_enable'])
		{
			$cachelife = isset($pbwow_config['bnetchars_cachetime']) ? intval($pbwow_config['bnetchars_cachetime']) : 86400;
			$apitimeout = isset($pbwow_config['bnetchars_timeout']) ? intval($pbwow_config['bnetchars_timeout']) : 1;

			// Get all the characters of the requested users
			$sql = 'SELECT * 
				FROM ' . $this->pbwow_chars_table . ' 
				WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
			$result = $this->db->sql_query($sql);

			$char_data = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$char_data[$row['user_id']] = $row;
			}
			$this->db->sql_freeresult($result);

			// For each requested user, we will do some magic
			foreach($user_ids as $user_id)
			{
				$bnet_h = (isset($field_data[$user_id]['pf_pb_bnet_host'])) ? $field_data[$user_id]['pf_pb_bnet_host'] -1 : 0; // 1 == none, so -1 for all
				$bnet_r = (isset($field_data[$user_id]['pf_pb_bnet_realm'])) ? $field_data[$user_id]['pf_pb_bnet_realm'] : '';
				$bnet_n = (isset($field_data[$user_id]['pf_pb_bnet_name'])) ? $field_data[$user_id]['pf_pb_bnet_name'] : '';
		
				if($bnet_h && $bnet_r && $bnet_n)
				{
					$callAPI = FALSE;
	
					// Determine if the API should be called, based on cache TTL, # of tries, and character change
					if(isset($char_data[$user_id]))
					{
						$age = time() - $char_data[$user_id]['updated'];
	
						switch($char_data[$user_id]["tries"])
						{
							case 0: break;
							case 1: $callAPI = ($age > 60) ? TRUE : FALSE ; break;
							case 2: $callAPI = ($age > 600) ? TRUE : FALSE ; break;
							case 3: $callAPI = ($age > ($cachelife / 24)) ? TRUE : FALSE ; break;
							case 4: $callAPI = ($age > ($cachelife / 4)) ? TRUE : FALSE ; break;
							default: break; // More than 4 tries > just wait for TTL
						}
	
						if($age > $cachelife)
						{
							$callAPI = TRUE;
						}
						
						if($bnet_n !== $char_data[$user_id]['name'])
						{
							$callAPI = TRUE;
						}
					}
					else
					{
						$callAPI = TRUE;
					}
		
					if($callAPI == TRUE)
					{
						// CPF values haven't been assigned yet, so have to do it manually
						$loc = FALSE;
						switch($bnet_h)
						{
							case 1: $bnet_h = "us.battle.net"; $loc = "us"; break;
							case 2: $bnet_h = "eu.battle.net"; $loc = "eu"; break;
							case 3: $bnet_h = "kr.battle.net"; $loc = "kr"; break;
							case 4: $bnet_h = "tw.battle.net"; $loc = "tw"; break;
							case 5: $bnet_h = "www.battlenet.com.cn"; $loc = "cn"; break;
							default: $bnet_h = "us.battle.net"; $loc = "us"; break;
						}
						
						// Sanitize
						$bnet_r = strtolower($bnet_r);
						$bnet_r = str_replace("'", "", $bnet_r);
						$bnet_r = str_replace(" ", "-", $bnet_r);
						$bnet_n = str_replace(" ", "-", $bnet_n);
		
						// Get API data (should use CURL instead, but I'll do it later)
						$URL = "http://" . $bnet_h . "/api/wow/character/" . $bnet_r . "/" . $bnet_n . "?fields=guild";
						//var_dump($URL);
						$context = stream_context_create(array('http'=>
							array('timeout' => $apitimeout)
						));
						$response = @file_get_contents($URL, false, $context);

						if($response === FALSE)
						{
							// If the API data cannot be retrieved, register the number of tries to prevent flooding
							if(isset($char_data[$user_id]) && $char_data[$user_id]['tries'] < 10)
							{
								$sql_ary = array(
									'user_id'	=> $user_id,
									'updated'	=> time(),
									'tries'		=> $char_data[$user_id]['tries'] + 1,
									'name'		=> $bnet_n,
									'realm'		=> $bnet_r,
									'url'		=> "Battle.net API error",
								);
								$sql = 'UPDATE ' . $this->pbwow_chars_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
									WHERE user_id = ' . $user_id;
								$this->db->sql_query($sql);
							} 
							else 
							{
								$sql_ary = array(
									'user_id'	=> $user_id,
									'updated'	=> time(),
									'tries'		=> 1,
									'name'		=> $bnet_n,
									'realm'		=> $bnet_r,
									'url'		=> "Battle.net API error",
								);
								$sql = 'INSERT INTO ' . $this->pbwow_chars_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
								$this->db->sql_query($sql);
							}

							$field_data[$user_id]['pf_pb_bnet_url'] = "Battle.net API error";
						} 
						else 
						{
							$data = json_decode($response, TRUE);
							
							// Sometimes the Battle.net API does give a valid response, but no valid data
							if(!isset($data['name']))
							{
								return $field_data;
							}
							
							// Set avatar path
							$avatar = (!empty($data['thumbnail'])) ? $data['thumbnail'] : '';
							if($avatar)
							{
								$avatarURL = "http://" . $bnet_h . "/static-render/" . $loc . "/" . $avatar;
								//$avatarIMG = @file_get_contents($IMGURL);
							}
							
							// Conform Blizzard's race ID numbers to PBWoW, so the CPF will work correctly
							$data_race = $data['race'];
							switch($data_race)
							{
								case 22: $data_race = 12; break;
								case 24:
								case 25:
								case 26: $data_race = 13; break;
								//default: $data_race; break;
							}
							$data_race += 1;
							$data_class = $data['class'] + 1;
							$data_gender = $data['gender'] + 2;
							$data_guild = (isset($data['guild']) && is_array($data['guild'])) ? $data['guild']['name'] : "";
							$data_level = $data['level'];
							$bnetURL = "http://" . $bnet_h . "/wow/character/" . $bnet_r . "/" . $bnet_n . "/simple";
							
							// Insert into character DB table
							$sql_ary = array(
								'user_id'			=> $user_id,
								'updated'			=> time(),
								'tries'				=> 0,
								'game'				=> "wow",
								'lastModified'		=> $data['lastModified'],
								'name'				=> $data['name'],
								'realm'				=> $data['realm'],
								'battlegroup'		=> $data['battlegroup'],
								'class'				=> $data_class,
								'race'				=> $data_race,
								'gender'			=> $data_gender,
								'level'				=> $data_level,
								'achievementPoints'	=> $data['achievementPoints'],
								'URL'				=> $bnetURL,
								'avatar'			=> $avatar,
								'avatarURL'			=> $avatarURL,
								'calcClass'			=> $data['calcClass'],
								'totalHK'			=> $data['totalHonorableKills'],
								'guild'				=> $data_guild,
							);
		
							if(isset($char_data[$user_id]))
							{
								$sql = 'UPDATE ' . $this->pbwow_chars_table . '
									SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
									WHERE user_id = ' . $user_id;
							}
							else
							{
								$sql = 'INSERT INTO ' . $this->pbwow_chars_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
							}
							$this->db->sql_query($sql);
							
							// Merge with rest of CPF values
							$field_data[$user_id]['pf_pb_wow_guild']	= $data_guild;
							//$field_data[$user_id]['pf_pb_wow_pbrealm'] = $data['realm'];
							$field_data[$user_id]['pf_pb_wow_class']	= $data_class;
							$field_data[$user_id]['pf_pb_wow_race']		= $data_race;
							$field_data[$user_id]['pf_pb_wow_gender']	= $data_gender;
							$field_data[$user_id]['pf_pb_wow_level']	= $data_level;
							$field_data[$user_id]['pf_pb_bnet_url']		= $bnetURL;
							$field_data[$user_id]['pf_pb_bnet_avatar']	= $avatarURL;
						}
					} 
					elseif($char_data[$user_id]['avatarURL']) // No API call needed, just use the current data
					{
						// Merge with rest of CPF values
						$field_data[$user_id]['pf_pb_wow_guild']	= $char_data[$user_id]['guild'];
						//$field_data[$user_id]['pf_pbrealm']		= $char_data[$user_id]['realm'];
						$field_data[$user_id]['pf_pb_wow_class']	= $char_data[$user_id]['class'];
						$field_data[$user_id]['pf_pb_wow_race']		= $char_data[$user_id]['race'];
						$field_data[$user_id]['pf_pb_wow_gender']	= $char_data[$user_id]['gender'];
						$field_data[$user_id]['pf_pb_wow_level']	= $char_data[$user_id]['level'];
						$field_data[$user_id]['pf_pb_bnet_url']		= $char_data[$user_id]['URL'];
						$field_data[$user_id]['pf_pb_bnet_avatar']	= $char_data[$user_id]['avatarURL'];
					}
					else  // No API call, but also no current (complete) data
					{
						$field_data[$user_id]['pf_pb_wow_guild']	= $char_data[$user_id]['guild'];
						$field_data[$user_id]['pf_pb_bnet_url']		= $char_data[$user_id]['URL'];
					}
				}
			}
		}
		return $field_data;
	}

	/**
	* Processes the users's profile-field data and generates an avatar (when available).
	* It also tries to determine the faction of a gaming character, based on the data.
	*
	* @var		array	profile_row		Array with users profile field data 
	* @var		array	tpl_fields		Array with template data fields
	*
	* @return	array	$tpl_fields		Array with modified template data fields
	*/
	public function process_pf_show($profile_row, $tpl_fields)
	{
		$avatars_enable = $this->pbwow_config['avatars_enable'];
		$avatars_path = !empty($this->pbwow_config['avatars_path']) ? $this->root_path . $this->pbwow_config['avatars_path'] . '/' : false;

		if(empty($profile_row))
		{
			return $tpl_fields;
		}
		
		if($avatars_enable && $avatars_path)
		{
			$wow_r = isset($tpl_fields['row']['PROFILE_PB_WOW_RACE_VALUE_RAW']) ? $profile_row['pb_wow_race']['value'] - 1 : NULL; // Get the WoW race ID
			$wow_c = isset($tpl_fields['row']['PROFILE_PB_WOW_CLASS_VALUE_RAW']) ? $profile_row['pb_wow_class']['value'] - 1 : NULL; // Get the WoW class ID
			$wow_g = isset($tpl_fields['row']['PROFILE_PB_WOW_GENDER_VALUE_RAW']) ? $profile_row['pb_wow_gender']['value'] - 1 : NULL; // Get the WoW gender ID
			$wow_l = isset($tpl_fields['row']['PROFILE_PB_WOW_LEVEL_VALUE_RAW']) ? $profile_row['pb_wow_level']['value'] - 1 : NULL; // Get the WoW level
			$d3_c = isset($tpl_fields['row']['PROFILE_PB_DIABLO_CLASS_VALUE_RAW']) ? $profile_row['pb_diablo_class']['value'] - 1 : NULL; // Get the Diablo class ID
			$d3_f = isset($tpl_fields['row']['PROFILE_PB_DIABLO_FOLLOWER_VALUE_RAW']) ? $profile_row['pb_diablo_follower']['value'] - 1 : NULL; // Get the Diablo class ID
			$d3_g = isset($tpl_fields['row']['PROFILE_PB_DIABLO_GENDER_VALUE_RAW']) ? $profile_row['pb_diablo_gender']['value'] - 1 : NULL; // Get the Diablo gender ID
			$ws_r = isset($tpl_fields['row']['PROFILE_PB_WILDSTAR_RACE_VALUE_RAW']) ? $profile_row['pb_wildstar_race']['value'] - 1 : NULL; // Get the Wildstar race ID
			$ws_c = isset($tpl_fields['row']['PROFILE_PB_WILDSTAR_CLASS_VALUE_RAW']) ? $profile_row['pb_wildstar_class']['value'] - 1 : NULL; // Get the Wildstar class ID
			$ws_g = isset($tpl_fields['row']['PROFILE_PB_WILDSTAR_GENDER_VALUE_RAW']) ? $profile_row['pb_wildstar_gender']['value'] - 1 : NULL; // Get the Wildstar class ID
			//$bneth = (isset($tpl_fields['row']['PROFILE_PBBNETHOST_VALUE'])) ? $tpl_fields['row']['PROFILE_PBBNETHOST_VALUE'] : NULL; // Get the Battle.net host
			//$bnetr = (isset($tpl_fields['row']['PROFILE_PBBNETREALM_VALUE'])) ? $tpl_fields['row']['PROFILE_PBBNETREALM_VALUE'] : NULL; // Get the Battle.net realm
			//$bnet_n = (isset($tpl_fields['row']['PROFILE_PBBNETNAME_VALUE'])) ? $tpl_fields['row']['PROFILE_PBBNETNAME_VALUE'] : NULL; // Get the Battle.net character name
			$bnet_u = isset($tpl_fields['row']['PROFILE_PB_BNET_URL_VALUE']) ? $profile_row['pb_bnet_url']['value'] : NULL; // Get the Battle.net avatar
			$bnet_a = isset($tpl_fields['row']['PROFILE_PB_BNET_AVATAR_VALUE']) ? $profile_row['pb_bnet_avatar']['value'] : NULL; // Get the Battle.net avatar
			
			// I know it looks silly, but we need this to fix icon classes in templates
			if($wow_r > 0) { $tpl_fields['row']['PROFILE_PB_WOW_RACE_VALUE_RAW'] = $wow_r; }
			if($wow_r > 0) { $tpl_fields['row']['PROFILE_PB_WOW_CLASS_VALUE_RAW'] = $wow_c; }
			if($wow_g > 0) { $tpl_fields['row']['PROFILE_PB_WOW_GENDER_VALUE_RAW'] = $wow_g; }
			if($d3_c > 0) { $tpl_fields['row']['PROFILE_PB_DIABLO_CLASS_VALUE_RAW'] = $d3_c; }
			if($d3_f > 0) { $tpl_fields['row']['PROFILE_PB_DIABLO_FOLLOWER_VALUE_RAW'] = $d3_f; }
			if($d3_g > 0) { $tpl_fields['row']['PROFILE_PB_DIABLO_GENDER_VALUE_RAW'] = $d3_g; }
			if($ws_r > 0) { $tpl_fields['row']['PROFILE_PB_WILDSTAR_RACE_VALUE_RAW'] = $ws_r; }
			if($ws_c > 0) { $tpl_fields['row']['PROFILE_PB_WILDSTAR_CLASS_VALUE_RAW'] = $ws_c; }
			if($ws_g > 0) { $tpl_fields['row']['PROFILE_PB_WILDSTAR_GENDER_VALUE_RAW'] = $ws_g; }

			$avatar = $path = '';
			$faction = 0;
			$valid = false; // determines whether a specific profile field combination is valid (for the game)
			$avail = false; // determines whether an avatar image is available for the profile field combination


			/* Battle.net API */
			//if($bneth !== NULL && $bnet_r !== NULL && $bnet_n !== NULL && $user_id !== 0 && $bnet_a !== NULL) {
			if($bnet_a !== NULL)
			{
				if(isset($wow_r))
				{
					$faction = (in_array($wow_r, array(1,3,4,7,11,12))) ? 1 : 2;
				}
				
				$width = 84;
				$height = 84;
	
				$avatars_path = '';
				$avatar = $bnet_a;
			}
	
			/* WoW without Battle.net */
			elseif($wow_r !== NULL)
			{
				/* Remapping options */
				// $R = $wow_r;
				// $wow_r = ($R == 1) ? 4 : $wow_r; // first item in CPF (with "none" = 0), map to race 4 (Night Elf)
				// $wow_r = ($R == 2) ? 9 : $wow_r; // second item in CPF, map to race 9 (Goblin)
				// $wow_r = ($R == 3) ? 12 : $wow_r; // third item in CPF, map to race 12 (Worgen)
				// $wow_r = ($R == 4) ? 2 : $wow_r; // fourth item in CPF, map to race 2 (Orc)
				// etc. etc.
				
				// $C = $wow_c;
				// $wow_c = ($C == 1) ? 1 : $wow_c; // first item in CPF (with "none" = 0), map to class 1 (Warrior)
				// $wow_c = ($C == 2) ? 4 : $wow_c; // second item in CPF, map to class 4 (Rogue)
				// $wow_c = ($C == 3) ? 6 : $wow_c; // third item in CPF, map to class 6 (Death Knight)
				// etc. etc.
				
				/* For reference 
				wow_r = 1 > Human
				wow_r = 2 > Orc
				wow_r = 3 > Dwarf
				wow_r = 4 > Night Elf
				wow_r = 5 > Undead
				wow_r = 6 > Tauren
				wow_r = 7 > Gnome
				wow_r = 8 > Troll
				wow_r = 9 > Goblin
				wow_r = 10 > Blood Elf
				wow_r = 11 > Draenei
				wow_r = 12 > Worgen
				wow_r = 13 > Pandaren
				
				wow_c = 1 > Warrior
				wow_c = 2 > Paladin
				wow_c = 3 > Hunter
				wow_c = 4 > Rogue
				wow_c = 5 > Priest
				wow_c = 6 > Death Knight
				wow_c = 7 > Shaman
				wow_c = 8 > Mage
				wow_c = 9 > Warlock
				wow_c = 10 > Monk
				wow_c = 11 > Druid
				*/

				$faction = 3; // Set faction to neutral, until we can determine correct faction
				switch($wow_r)
				{
					case 1: // Human
						$valid = (in_array($wow_c, array(1,2,3,4,5,6,8,9,10))) ? true : false;
						$avail = (in_array($wow_c, array(1,2,4,5,6,8,9))) ? true : false;
						$faction = 1;
					break;
					
					case 2: // Orc
						$valid = (in_array($wow_c, array(1,3,4,6,7,8,9,10))) ? true : false;
						$avail = (in_array($wow_c, array(1,3,4,6,7,9))) ? true : false;
						$faction = 2;
					break;
					
					case 3: // Dwarf
						$valid = (in_array($wow_c, array(1,2,3,4,5,6,7,8,9,10))) ? true : false;
						$avail = (in_array($wow_c, array(1,2,3,4,5,6))) ? true : false;
						$faction = 1;
					break;
					
					case 4: // Night Elf
						$valid = (in_array($wow_c, array(1,3,4,5,6,8,10,11))) ? true : false;
						$avail = (in_array($wow_c, array(1,3,4,5,6,11))) ? true : false;
						$faction = 1;
					break;
					
					case 5: // Undead
						$valid = (in_array($wow_c, array(1,3,4,5,6,8,9,10))) ? true : false;
						$avail = (in_array($wow_c, array(1,4,5,6,8,9))) ? true : false;
						$faction = 2;
					break;
					
					case 6: // Tauren
						$valid = (in_array($wow_c, array(1,2,3,5,6,7,10,11))) ? true : false;
						$avail = (in_array($wow_c, array(1,3,6,7,11))) ? true : false;
						$faction = 2;
					break;
					
					case 7: // Gnome
						$valid = (in_array($wow_c, array(1,4,5,6,8,9,10))) ? true : false;
						$avail = (in_array($wow_c, array(1,4,6,8,9))) ? true : false;
						$faction = 1;
					break;
					
					case 8:  // Troll
						$valid = (in_array($wow_c, array(1,3,4,5,6,7,8,9,10,11))) ? true : false;
						$avail = (in_array($wow_c, array(1,3,4,5,6,7,8))) ? true : false;
						$faction = 2;
					break;
	
					case 9: // Goblin
						$valid = (in_array($wow_c, array(1,3,4,5,6,7,8,9))) ? true : false;
						//$avail = (in_array($c, array())) ? true : false;
						$faction = 2;
					break;
					
					case 10:  // Blood Elf
						$valid = (in_array($wow_c, array(1,2,3,4,5,6,8,9,10))) ? true : false;
						$avail = (in_array($wow_c, array(2,3,4,5,6,8,9))) ? true : false;
						$faction = 2;
					break;
					
					case 11: // Draenei
						$valid = (in_array($wow_c, array(1,2,3,5,6,7,8,10))) ? true : false;
						$avail = (in_array($wow_c, array(1,2,3,5,6,7,8))) ? true : false;
						$faction = 1;
					break;
					
					case 12:  // Worgen
						$valid = (in_array($wow_c, array(1,3,4,5,6,8,9,11))) ? true : false;
						//$avail = (in_array($c, array())) ? true : false;
						$faction = 1;
					break;
					
					case 13: // Pandaren
						$valid = (in_array($wow_c, array(1,3,4,5,7,8,10))) ? true : false;
						//$avail = (in_array($c, array())) ? true : false;
						$faction = 3;
					break;
				}
				
				$wow_g = max(0, $wow_g-1); // 0 = none, 1 = male, 2 = female, but we need a 0/1 map
	
				if($valid && $avail)
				{
					if ($wow_l >= 80)
					{
						$path = 'wow/80';
					}					
					elseif ($wow_l >= 70)
					{
						$path = 'wow/70';
					}
					elseif ($wow_l >= 60)
					{
						$path = 'wow/60';
					}
					else {
						$path = 'wow/default';
					}
					
					$avatar = $path . '/' . $wow_g . '-' . $wow_r . '-' . $wow_c . '.gif';
					$width = 64;
					$height = 64;
				} 
				else {
					$avatar = 'wow/new/' . $wow_r . '-' . $wow_g . '.jpg';
					$width = 84;
					$height = 84;
				}
			}
			
			/* Diablo */
			elseif($d3_c !== NULL)
			{
				switch($d3_c)
				{
					case 1: // Barbarian
						$avatar = 'barbarian';
					break;
					case 2: // Demon Hunter
						$avatar = 'demonhunter';
					break;
					case 3: // Monk
						$avatar = 'monk';
					break;
					case 4: // Witch Doctor
						$avatar = 'witchdoctor';
					break;
					case 5: // Wizard
						$avatar = 'wizard';
					break;
					case 6: // Crusader
						$avatar = 'crusader';
					break;
				}

				$d3_g = (isset($d3_g) && $d3_g > 1) ? 'female' : 'male';
				$avatar = 'diablo/' . $avatar . '_' . $d3_g . '.png';
				$width = 64;
				$height = 64;
				$faction = 3;
			}
			
			/* Wildstar */
			elseif($ws_r !== NULL)
			{
	
				/* For reference 
				ws_r = 1 > Human
				ws_r = 2 > Cassian
				ws_r = 3 > Granok
				ws_r = 4 > Draken
				ws_r = 5 > Aurin
				ws_r = 6 > Chua
				ws_r = 7 > Mordesh
				ws_r = 8 > Mechari
				
				ws_c = 1 > Warrior
				ws_c = 2 > Esper
				ws_c = 3 > Spellslinger
				ws_c = 4 > Stalker
				ws_c = 5 > Medic
				ws_c = 6 > Engineer
				*/
	
				$faction = 3; // Set faction to neutral, until we can determine correct faction
				switch($ws_r)
				{
					case 1: // Human
						$valid = $avail = (in_array($ws_c, array(1,2,3,4,5,6))) ? true : false;
						$faction = 1;
					break;
					
					case 2: // Cassian
						$valid = $avail = (in_array($ws_c, array(1,2,3,4,5,6))) ? true : false;
						$faction = 2;
					break;
					
					case 3: // Granok
						$valid = $avail = (in_array($ws_c, array(1,5,6))) ? true : false;
						$faction = 1;
					break;
					
					case 4: // Draken
						$valid = $avail = (in_array($ws_c, array(1,3,4))) ? true : false;
						$faction = 2;
					break;
					
					case 5: // Aurin
						$valid = $avail = (in_array($ws_c, array(2,3,4))) ? true : false;
						$faction = 1;
					break;
					
					case 6: // Chua
						$valid = $avail = (in_array($ws_c, array(2,3,5,6))) ? true : false;
						$faction = 2;
					break;
					
					case 7: // Mordesh
						$valid = $avail = (in_array($ws_c, array(1,3,4,5,6))) ? true : false;
						$faction = 1;
					break;
					
					case 8:  // Mechari
						$valid = $avail = (in_array($ws_c, array(1,4,5,6))) ? true : false;
						$faction = 2;
					break;
				}
				
				$ws_g = max(0, $ws_g-1); // 0 = none, 1 = male, 2 = female, but we need a 0/1 map
	
				if($valid)
				{
					//$avatar = 'wildstar/' . $ws_r . '-' . $wsg . '-' . $ws_c . '.jpg'; // Valid
					$avatar = 'wildstar/' . $ws_r . '.jpg'; // Valid
				}
				else {
					$avatar = 'wildstar/' . $ws_r . '.jpg';  // Invalid, show generic race avatar
				}

				$width = 64;
				$height = 64;
			}
			
			// Add to template fields
			if($faction || $avatar)
			{
				$tpl_fields['row'] += array(
					'PROFILE_PBFACTION'			=> ($faction) ? $faction : false,
					'PROFILE_PBAVATAR'			=> '<img src="' . $avatars_path . $avatar . '" width="' . $width . '" height="' . $height . '" alt="" />',
				);
			}
		}

		return $tpl_fields;
	}

	/**
	* Determine if any special styling should be applied to a user's post/profile, based on his rank.
	*
	* @var		int		$rank		Integer of the user's rank_id 
	*
	* @return	string	$style		String with the special styling name
	*/
	public function get_rank_styling($rank)
	{
		$pbwow_config = $this->pbwow_config;
		
		$cfg_blizz_ranks = explode(',', $pbwow_config['blizz_ranks']);
		$cfg_propass_ranks = explode(',', $pbwow_config['propass_ranks']);
		$cfg_red_ranks = explode(',', $pbwow_config['red_ranks']);
		$cfg_mvp_ranks = explode(',', $pbwow_config['mvp_ranks']);
	
		$style = '';

		if(isset($cfg_blizz_ranks) && $pbwow_config['blizz_enable'] && in_array($rank, $cfg_blizz_ranks))
		{
			$style = 'blizz';
		}
		elseif(isset($cfg_mvp_ranks) && $pbwow_config['mvp_enable'] && in_array($rank, $cfg_mvp_ranks))
		{
			$style = 'mvp';
		}
		elseif(isset($cfg_propass_ranks) && $pbwow_config['propass_enable'] && in_array($rank, $cfg_propass_ranks))
		{
			$style = 'propass';
		}
		elseif(isset($cfg_red_ranks) && $pbwow_config['red_enable'] && in_array($rank, $cfg_red_ranks))
		{
			$style = 'red';
		}
		
		return $style;
	}


	public function global_style_append_after($event)
	{
		if($this->config['load_cpf_viewtopic'] && $this->config['allow_avatar'] && $this->user->data && $this->user->data['user_id'] != ANONYMOUS)
		{
			$user_data = $this->user->data;
			$user_id = $user_data['user_id'];

			if(isset($user_data['user_avatar']) && empty($user_data['user_avatar']))
			{
				$cp = $this->profilefields_manager->grab_profile_fields_data($user_id);
				$pf = $this->profilefields_manager->generate_profile_fields_template_data($cp[$user_id]);

				if(isset($pf['row']['PROFILE_PBAVATAR']) && !empty($pf['row']['PROFILE_PBAVATAR']))
				{
					$this->template->assign_vars(array(
						'CURRENT_USER_AVATAR' => $pf['row']['PROFILE_PBAVATAR'],
					));
				}
			}
		}
	}

	public function viewtopic_cache_guest($user_cache_data)
	{
		$user_cache_data += array(
			'posts_rank_title'			=> '',
			'posts_rank_image'			=> '',
			'posts_rank_image_src'		=> '',
			'user_special_styling'		=> '',
		);
		return $user_cache_data;
	}

	public function viewtopic_cache_user($user_cache_data, $poster_id, $row)
	{
		$this->get_user_rank_global(0, $row['user_posts'], $posts_rank_title, $posts_rank_image, $posts_rank_image_src);
		$user_special_styling = $this->get_rank_styling($row['user_rank']);

		$user_cache_data += array(
			'posts_rank_title'			=> isset($posts_rank_title) ? $posts_rank_title : '',
			'posts_rank_image'			=> isset($posts_rank_image) ? $posts_rank_image : '',
			'posts_rank_image_src'		=> isset($posts_rank_image_src) ? $posts_rank_image_src : '',
			'user_special_styling'		=> isset($user_special_styling) ? $user_special_styling : '',
		);
		return $user_cache_data;
	}

	public function viewtopic_modify_post($user_poster_data, $post_row, $cp_row)
	{
		if(empty($user_poster_data['avatar']) && isset($cp_row['row']['PROFILE_PBAVATAR']))
		{
			$post_row['POSTER_AVATAR'] = $cp_row['row']['PROFILE_PBAVATAR'];
		}
		
		$post_row += array(
			'POSTS_RANK_TITLE'		=> $user_poster_data['posts_rank_title'],
			'POSTS_RANK_IMG'		=> $user_poster_data['posts_rank_image'],
			'POSTS_RANK_IMG_SRC'	=> $user_poster_data['posts_rank_image_src'],
			'USER_SPECIAL_STYLING'	=> $user_poster_data['user_special_styling'],
		);
		
		return $post_row;
	}


	public function memberlist_view_profile($member, $profile_fields)
	{
		if(isset($profile_fields['row']['PROFILE_PBAVATAR']))
		{
			$member['pbavatar'] = $profile_fields['row']['PROFILE_PBAVATAR'];
		}

		return $member;
	}

	public function memberlist_prepare_profile($data, $template_data)
	{
		$this->get_user_rank_global(0, $data['user_posts'], $posts_rank_title, $posts_rank_image, $posts_rank_image_src);
		$user_special_styling = $this->get_rank_styling($data['user_rank']);

		if(empty($data['user_avatar']) && isset($data['pbavatar']))
		{
			$template_data['AVATAR_IMG'] = $data['pbavatar'];
		}

		$template_data += array(
			'POSTS_RANK_TITLE'		=> isset($posts_rank_title) ? $posts_rank_title : '',
			'POSTS_RANK_IMG'		=> isset($posts_rank_image) ? $posts_rank_image : '',
			'POSTS_RANK_IMG_SRC'	=> isset($posts_rank_image_src) ? $posts_rank_image_src : '',
			'USER_SPECIAL_STYLING'	=> isset($user_special_styling) ? $user_special_styling : '',
		);

		return $template_data;
	}


	public function search_modify_tpl_ary($row, $tpl_ary, $show_results)
	{
		$this->get_user_rank_global($row['user_rank'], $row['user_posts'], $rank_title, $rank_image, $rank_image_src);
		$this->get_user_rank_global(0, $row['user_posts'], $posts_rank_title, $posts_rank_image, $posts_rank_image_src);
		$user_special_styling = $this->get_rank_styling($row['user_rank']);

		$tpl_ary += array(
			'USER_SPECIAL_STYLING'	=> isset($user_special_styling) ? $user_special_styling : '',
		);

		return $tpl_ary;
	}


	/**
	* Modify the topic preview display output, by inserting the custom avatar
	* if no "normal" avatar is specified (and if a CPF avatar-generated is available).
	*
	* @var	array	rowset	Array with topics data (in topic_id => topic_data format)
	*/
	public function topic_preview_modify_row($rowset)
	{
		$tp_enabled = (!empty($this->config['topic_preview_limit']) && !empty($this->user->data['user_topic_preview'])) ? true : false;
		$tp_avatars = (!empty($this->config['topic_preview_avatars']) && $this->config['allow_avatar'] && $this->user->optionget('viewavatars')) ? true : false;
		$tp_last_post = (!empty($this->config['topic_preview_last_post'])) ? true : false;

		// Only proceed if we want to display avatars and the CPF-generated avatars feature is enabled
		if ($tp_enabled && $tp_avatars && $this->config['load_cpf_viewtopic'] && $this->pbwow_config['avatars_enable'])
		{
			$user_ids = array();

			// Get all the user_ids that we want to query
			foreach ($rowset as $topic)
			{
				if (!$topic['fp_avatar'])
				{
					$user_ids[] = $topic['topic_poster'];
				}
				if ($tp_last_post && !$topic['lp_avatar'])
				{
					$user_ids[] = $topic['topic_last_poster_id'];
				}
			}

			$user_ids = array_unique($user_ids);
			$pf_avatars = array();

			// Get the profile data of the specified users
			$pf_data = $this->profilefields_manager->grab_profile_fields_data($user_ids);

			if (!empty($pf_data))
			{
				// Process the profile data and get an array of all users that have a CPF-generated avatar
				foreach ($pf_data as $user_id => $pf_row)
				{
					$pf_values = $this->profilefields_manager->generate_profile_fields_template_data($pf_row);

					if (isset($pf_values['row']['PROFILE_PBAVATAR']))
					{
						$pf_avatars[$user_id] = $pf_values['row']['PROFILE_PBAVATAR'];
					}
				}
			}

			// Merge the CPF-generated avatars into the topic rows
			foreach ($rowset as &$topic)
			{
				if (isset($pf_avatars[$topic['topic_poster']]))
				{
					$topic['fp_pbavatar'] = $pf_avatars[$topic['topic_poster']];
				}

				if (isset($pf_avatars[$topic['topic_last_poster_id']]))
				{
					$topic['lp_pbavatar'] = $pf_avatars[$topic['topic_last_poster_id']];
				}
			}
		}
		return $rowset;
	}

	/**
	* Modify the topic preview display output, by inserting the custom avatar
	* if no "normal" avatar is specified (and if a PBWoW avatar is available).
	*
	* @var array $row 		Row data
	* @var array $block		Template vars array
	* @var int $tp_avatars	Display avatars setting
	*/
	public function topic_preview_modify_display($row, $block, $tp_avatars)
	{
		if($tp_avatars && $this->pbwow_config['avatars_enable'])
		{
			if(empty($row['fp_avatar']) && isset($row['fp_pbavatar']))
			{
				$block['TOPIC_PREVIEW_FIRST_AVATAR'] = $row['fp_pbavatar'];
			}

			if(empty($row['lp_avatar']) && isset($row['lp_pbavatar']))
			{
				$block['TOPIC_PREVIEW_LAST_AVATAR'] = $row['lp_pbavatar'];
			}
		}
		return $block;
	}


	/**
	* This is a modified copy of the get_user_rank function, as found in functions_display.php
	* It has been put here so it can be called from any page, which is needed for some PBWoW
	* features. It also reduces the risk of undefined function errors.
	*
	* @param int $user_rank the current stored users rank id
	* @param int $user_posts the users number of posts
	* @param string &$rank_title the rank title will be stored here after execution
	* @param string &$rank_img the rank image as full img tag is stored here after execution
	* @param string &$rank_img_src the rank image source is stored here after execution
	*
	* Note: since we do not want to break backwards-compatibility, this function will only properly assign ranks to guests if you call it for them with user_posts == false
	*/
	public function get_user_rank_global($user_rank, $user_posts, &$rank_title, &$rank_img, &$rank_img_src)
	{
		$ranks = $this->ranks;
	
		if (empty($ranks))
		{
			$ranks = $this->ranks = $this->cache->obtain_ranks();
		}
	
		if (!empty($user_rank))
		{
			$rank_title = (isset($ranks['special'][$user_rank]['rank_title'])) ? $ranks['special'][$user_rank]['rank_title'] : '';
			$rank_img = (!empty($ranks['special'][$user_rank]['rank_image'])) ? '<img src="' . $this->root_path . $this->config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] . '" alt="' . $ranks['special'][$user_rank]['rank_title'] . '" title="' . $ranks['special'][$user_rank]['rank_title'] . '" />' : '';
			$rank_img_src = (!empty($ranks['special'][$user_rank]['rank_image'])) ? $this->root_path . $this->config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] : '';
		}
		else if ($user_posts !== false)
		{
			if (!empty($ranks['normal']))
			{
				foreach ($ranks['normal'] as $rank)
				{
					if ($user_posts >= $rank['rank_min'])
					{
						$rank_title = $rank['rank_title'];
						$rank_img = (!empty($rank['rank_image'])) ? '<img src="' . $this->root_path . $this->config['ranks_path'] . '/' . $rank['rank_image'] . '" alt="' . $rank['rank_title'] . '" title="' . $rank['rank_title'] . '" />' : '';
						$rank_img_src = (!empty($rank['rank_image'])) ? $this->root_path . $this->config['ranks_path'] . '/' . $rank['rank_image'] : '';
						break;
					}
				}
			}
		}
	}

	protected function get_pbwow_config()
	{
		if (($this->pbwow_config = $this->cache->get('pbwow_config')) != true)
		{
			$this->pbwow_config = array();

			if($this->db_tools->sql_table_exists($this->pbwow_config_table))
			{
				$sql = 'SELECT config_name, config_value FROM ' . $this->pbwow_config_table;
				$result = $this->db->sql_query($sql);
		
				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->pbwow_config[$row['config_name']] = $row['config_value'];
				}
				$this->db->sql_freeresult($result);

			}
			$this->cache->put('pbwow_config', $this->pbwow_config);
		}
	}

}
?>