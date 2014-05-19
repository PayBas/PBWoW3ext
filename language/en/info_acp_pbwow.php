<?php

/**
*
* @package PBWoW Extension
* @copyright (c) 2014 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	// Extension modules
	'ACP_PBWOW3_CATEGORY'		=> 'PBWoW 3',
	'ACP_PBWOW3_OVERVIEW'		=> 'Overview',
	'ACP_PBWOW3_CONFIG'			=> 'Configuration',
	'ACP_PBWOW3_POSTSTYLING'	=> 'Post Styling',
	'ACP_PBWOW3_ADS'			=> 'Advertisements',

	// Common
	'PBWOW_ACTIVE'				=> 'active',
	'PBWOW_INACTIVE'			=> 'inactive',
	'PBWOW_DETECTED'			=> 'detected',
	'PBWOW_NOT_DETECTED'		=> 'not detected',
	'PBWOW_OBSOLETE'			=> 'no longer used',

	'LOG_PBWOW_CONFIG'			=> '<strong>Altered PBWoW settings</strong><br />&raquo; %s',


	// OVERVIEW //

	'PBWOW_OVERVIEW_TITLE'				=> 'PBWoW Extension Overview',
	'PBWOW_OVERVIEW_TITLE_EXPLAIN'		=> 'Thank you for choosing PBWoW, hope you like it.',
	'ACP_PBWOW_INDEX_SETTINGS'			=> 'General information',

	'PBWOW_DB_CHECK'					=> 'PBWoW Database Check',
	'PBWOW_DB_GOOD'						=> 'PBWoW configuration table found (%s)',
	'PBWOW_DB_BAD'						=> 'No PBWoW configuration table found. Make sure that the table (%s) exists in your phpBB database.',
	'PBWOW_DB_BAD_EXPLAIN'				=> 'Run the PBWoW installation script included in the MOD package. This will create and populate the appropriate database table.',

	'PBWOW_VERSION_CHECK'				=> 'PBWoW Version Check',
	'PBWOW_LATEST_VERSION'				=> 'Latest version',
	'PBWOW_EXT_VERSION'					=> 'Extension version',
	'PBWOW_STYLE_VERSION'				=> 'Style version',
	'PBWOW_VERSION_ERROR'				=> 'Unable to determine version!',
	'PBWOW_CHECK_UPDATE'				=> 'Check <a href="http://pbwow.com/forum/index.php">PBWoW.com</a> to see if there are updates available.',

	'PBWOW_CPF_CHECK'					=> 'Custom Profile Fields Check',
	//'PBWOW_CPF_CREATE_LOCATION'			=> 'Create or enable this field via ACP > Users and Groups > Custom profile fields',
	'PBWOW_CPF_LOAD_LOCATION'			=> 'Enable this via ACP > General > Board Configuration > Board Features',
	'PBWOW_GAME_EXPLAIN'				=> 'The custom profile fields for this game are currently disabled.',

	'PBWOW_BNETCHARS'					=> 'Battle.net API character information functionality',
	'PBWOW_CHARSDB_GOOD'				=> 'PBWoW characters table found (%s)',
	'PBWOW_CHARSDB_BAD'					=> 'No PBWoW characters table found. Make sure that the table (%s) exists in your phpBB database.',
	'PBWOW_CHARSDB_BAD_EXPLAIN'			=> 'The required PBWoW 3 Battle.net Characters database table should have been installed automatically when you installed the PBWoW extension. Please uninstall it, delete the data, and try installing it again.',
	'PBWOW_CHARSCONSTANTS_BAD'			=> 'Constants not set! This means that the PBWoW 2 MOD was not applied correctly!',
	'PBWOW_CHARSCONSTANTS_BAD_EXPLAIN'	=> 'Try installing the MOD again, or manually add the following line to your includes/constants.php file:<br /><br />define(\'PBWOW2_CHARS_TABLE\', $table_prefix . \'pbwow2_chars\');',
	'PBWOW_FOPEN_BAD'					=> 'Your server does not allow &quot;file_get_contents&quot; (fopen). Check your php.ini file to set &quot;allow_url_fopen&quot;, or contact your server host.',

	'PBWOW_DONATE'						=> 'Donate to PBWoW',
	'PBWOW_DONATE_SHORT'				=> 'Make a donation to PBWoW',
	'PBWOW_DONATE_EXPLAIN'				=> 'PBWoW is 100% free. It is a hobby project that I am spending my time and money on, just for the fun of it. If you enjoy using PBWoW, please consider making a donation. I would really appreciate it. No strings attached.',


	// LEGACY CHECKS //

	'PBWOW_LEGACY_CHECK'				=> 'PBWoW Legacy Check',

	'PBWOW_LEGACY_CONSTANTS'			=> 'PBWoW Legacy Constants',
	'PBWOW_LEGACY_CONSTANTS_EXPLAIN'	=> 'If detected, this means that there are still (partial) MODs of PBWoW v1 or v2 active! This could potentially lead to errors. That is why we strongly urge you to uninstall any active (PBWoW) MODs before upgrading to the latest phpBB version. Either that, or install a clean phpBB version and use the database update function of the phpBB installer.',
	'PBWOW_LEGACY_DATABASE'				=> 'PBWoW Legacy Database(s)',
	'PBWOW_LEGACY_DATABASE_EXPLAIN'		=> 'The config table of PBWoW v1 or v2 is still active. This is no problem, since PBWoW 3 does not interact with it. But you can drop/delete the table if you want (and are no longer using it).',

	'PBWOW_LEGACY_NONE'					=> 'No obvious potentially problematic traces of older PBWoW versions were found. This is good.',


	// CONFIG //

	'PBWOW_CONFIG_TITLE'				=> 'PBWoW Configuration',
	'PBWOW_CONFIG_TITLE_EXPLAIN'		=> 'Here you can choose some options to customize your PBWoW installation.',

	'PBWOW_LOGO'						=> 'Custom Logo',
	'PBWOW_LOGO_ENABLE'					=> 'Enable your own custom logo image',
	'PBWOW_LOGO_ENABLE_EXPLAIN'			=> 'Using this will enable your own custom logo for all installed PBWoW styles (except the PBWoW master style).',
	'PBWOW_LOGO_SRC'					=> 'Image source path',
	'PBWOW_LOGO_SRC_EXPLAIN'			=> 'Image path under your phpBB root directory, e.g. <samp>images/logo.png</samp>.<br />I strongly advise you to use a PNG image with a transparent background.',
	'PBWOW_LOGO_SIZE'					=> 'Logo dimensions',
	'PBWOW_LOGO_SIZE_EXPLAIN'			=> 'Exact dimensions of your logo image (Width x Height in pixels).<br />Images of more than 350 x 200 are not advised (due to responsive layout).',
	'PBWOW_LOGO_MARGINS'				=> 'Logo margins',
	'PBWOW_LOGO_MARGINS_EXPLAIN'		=> 'Set the CSS margins of your logo. This will give more control over the positioning of your image. Use valid CSS markup, e.g. <samp>10px 5px 25px 0</samp>.',

	'PBWOW_AVATARS'						=> 'Gaming Avatars',
	'PBWOW_AVATARS_ENABLE'				=> 'Enable board-wide gaming avatars (and icons)',
	'PBWOW_AVATARS_ENABLE_EXPLAIN'		=> 'If enabled, your board will display a generated gaming avatar (based on profile field entries) if the user has no custom avatar configured.',
	'PBWOW_AVATARS_PATH'				=> 'Gaming avatars path',
	'PBWOW_AVATARS_PATH_EXPLAIN'		=> 'Path under your phpBB root directory where the gaming avatars are stored, e.g. <samp>images/avatars/gaming</samp>.<br />Character icons also require this path to be set.',

	'PBWOW_TOPBAR'						=> 'Top Header-Bar',
	'PBWOW_TOPBAR_ENABLE'				=> 'Enable the top header-bar',
	'PBWOW_TOPBAR_ENABLE_EXPLAIN'		=> 'By enabling this option, a 40px high customizable bar will be displayed at the top of each page.',
	'PBWOW_TOPBAR_CODE'					=> 'Top header-bar code',
	'PBWOW_TOPBAR_CODE_EXPLAIN'			=> 'Enter your code here. Use &lt;span&gt; or &lt;a class="cell"&gt; elements to seperate blocks with borders. To use icons, either use &lt;img&gt; blocks or define special CSS classes inside your custom.css stylesheet (better).',
	'PBWOW_TOPBAR_FIXED'				=> 'Fixed to top',
	'PBWOW_TOPBAR_FIXED_EXPLAIN'		=> 'Fixing the top header-bar to the top of the screen will keep it visible and locked in place, even when scrolling.<br />This does not apply to mobile devices. It will revert back to default (scrolling) mode when viewed on small screens.',

	'PBWOW_HEADERLINKS'					=> 'Header Box Custom Links',
	'PBWOW_HEADERLINKS_ENABLE'			=> 'Enable custom links in the header box',
	'PBWOW_HEADERLINKS_ENABLE_EXPLAIN'	=> 'By enabling this option, the HTML code entered below will be displayed inside the box at the top-right of the screen (in-line before the FAQ link). This is useful for portal and DKP links (some of which will be detected automatically).',
	'PBWOW_HEADERLINKS_CODE'			=> 'Custom header links code',
	'PBWOW_HEADERLINKS_CODE_EXPLAIN'	=> 'Enter your custom links here. These should be wrapped in &lt;li&gt; elements. To use icons, please define CSS classes inside your custom.css stylesheet.',
	
	'PBWOW_VIDEOBG'						=> '(Video) Background Settings',
	'PBWOW_VIDEOBG_ENABLE'				=> 'Enable animated video backgrounds',
	'PBWOW_VIDEOBG_ENABLE_EXPLAIN'		=> 'Some PBWoW styles support special animated video backgrounds (not all). You can enable these for cool effect, or disable them to save bandwidth (or if you are having problems).',
	'PBWOW_VIDEOBG_ALLPAGES'			=> 'Display video backgrounds on all pages?',
	'PBWOW_VIDEOBG_ALLPAGES_EXPLAIN'	=> 'By default, PBWoW only loads the video backgrounds (if available) on <u>index.php</u> pages. You can enable them for all pages, but this may affect the browsing speed of your visitors (but in general not your server bandwidth, because they are cached locally). [only applies if video is enabled]',
	'PBWOW_FIXEDBG'						=> 'Fixed background position',
	'PBWOW_FIXEDBG_EXPLAIN'				=> 'Fixing the background position will prevent it from scrolling along with the rest of the content. Keep in mind that some lower resolution devices will have no option to see the entire background image.',

	'PBWOW_BNETCHARS'					=> 'Battle.net Character Information',
	'PBWOW_BNETCHARS_ENABLE'			=> 'Enable Battle.net API character information',
	'PBWOW_BNETCHARS_ENABLE_EXPLAIN'	=> 'Enable this feature to use the Battle.net API to retrieve character information (when available), for use in user profiles. The <u>Gaming Avatars</u> setting must be enabled to display Battle.net avatars!',
	'PBWOW_BNETCHARS_CACHETIME'			=> 'Cache time-to-live',
	'PBWOW_BNETCHARS_CACHETIME_EXPLAIN'	=> 'Sets the time-to-live (in seconds) of cached character information after it has been retrieved from the Battle.net API. You can change this to update character information more or less frequently. 86400 = 24h',
	'PBWOW_BNETCHARS_TIMEOUT'			=> 'API query time-out',
	'PBWOW_BNETCHARS_TIMEOUT_EXPLAIN'	=> 'Sets the time-out interval (in seconds) of Battle.net API requests. Basically meaning the maximum time that the script will wait for Battle.net to respond. Increase this if you think that (correct) data is not being received on time, but page load time can increase!',

	'PBWOW_TOOLTIPS'					=> 'Tooltips',
	'PBWOW_WOWTIPS_ENABLE'				=> 'Enable World of Warcraft Tooltips',
	'PBWOW_WOWTIPS_ENABLE_EXPLAIN'		=> 'If enabled, all WoW database links found on your site will feature a tooltip. For more information, visit <a href="http://www.wowhead.com/tooltips" target="_blank">WoWhead</a>.',
	'PBWOW_D3TIPS_ENABLE'				=> 'Enable Diablo 3 Tooltips',
	'PBWOW_D3TIPS_ENABLE_EXPLAIN'		=> 'If enabled, all Diablo 3 database links found on your site will feature a tooltip. For more information, visit <a href="http://us.battle.net/d3/en/tooltip/" target="_blank">Battle.net</a>.',
	'PBWOW_ZAMTIPS_ENABLE'				=> 'Enable ZAM Tooltips',
	'PBWOW_ZAMTIPS_ENABLE_EXPLAIN'		=> 'If enabled, ZAM links found on your site will feature a tooltip and an icon. This supports tooltips for: Everquest, Everquest II, Final Fantasy XI, Final Fantasy XIV, Lord of the Rings Online and Warhammer Online. For more information, visit <a href="http://www.zam.com/wiki/Tooltips" target="_blank">ZAM Tooltips Wiki</a>.',
	'PBWOW_TOOLTIPS_REGION'				=> 'Region Settings',
	'PBWOW_TOOLTIPS_REGION_EXPLAIN'		=> 'Some (not all) tooltip scripts have regional distribution. Depending on your user\'s demographics, it might be advisable to choose the one with the lowest latency.',


	// POSTSTYLING //

	'PBWOW_POSTSTYLING_TITLE'			=> 'PBWoW Post Styling Settings',
	'PBWOW_POSTSTYLING_TITLE_EXPLAIN'	=> 'This page controls the PBWoW features relating to special post styling. You can enable these features for specific user groups.',

	'PBWOW_BLIZZ'						=> 'Blizzard Post Styling',
	'PBWOW_BLIZZ_ENABLE'				=> 'Enable Blizzard post styling',
	'PBWOW_BLIZZ_ENABLE_EXPLAIN'		=> 'Enable this feature to let the rank(s) selected below display as "Blizzard" posters, usually reserved for admins and moderators.',
	'PBWOW_BLIZZ_RANKS'					=> 'Blizzard post styling ranks',
	'PBWOW_BLIZZ_RANKS_EXPLAIN'			=> 'Choose the user rank(s) that you want to display as "Blizzard" posters (hold down the CTRL key to select multiple).',

	'PBWOW_PROPASS'						=> 'Propass Post Styling',
	'PBWOW_PROPASS_ENABLE'				=> 'Enable Propass post styling',
	'PBWOW_PROPASS_ENABLE_EXPLAIN'		=> 'Enable this feature to let the rank(s) selected below display as "Propass" or "Dragon" posters, usually reserved for special users.',
	'PBWOW_PROPASS_RANKS'				=> 'Propass post styling ranks',
	'PBWOW_PROPASS_RANKS_EXPLAIN'		=> 'Choose the user rank(s) that you want to display as "Propass" posters (hold down the CTRL key to select multiple).',

	'PBWOW_MVP'							=> 'MVP Post Styling',
	'PBWOW_MVP_ENABLE'					=> 'Enable MVP (most valued poster) post styling',
	'PBWOW_MVP_ENABLE_EXPLAIN'			=> 'Enable this feature to let the rank(s) selected below display as "MVP" or "Green" posters, usually reserved for community leaders.',
	'PBWOW_MVP_RANKS'					=> 'MVP post styling ranks',
	'PBWOW_MVP_RANKS_EXPLAIN'			=> 'Choose the user rank(s) that you want to display as "MVP" posters (hold down the CTRL key to select multiple).',	
	
	'PBWOW_RED'							=> 'Red Post Styling',
	'PBWOW_RED_ENABLE'					=> 'Enable Red post styling',
	'PBWOW_RED_ENABLE_EXPLAIN'			=> 'Enable this feature to let the rank(s) selected below display as "Red" posters. I don&rsquo;t really know what it&rsquo;s for.',
	'PBWOW_RED_RANKS'					=> 'Red post styling ranks',
	'PBWOW_RED_RANKS_EXPLAIN'			=> 'Choose the user rank(s) that you want to display as "Red" posters (hold down the CTRL key to select multiple).',


	// ADVERTISEMENTS //

	'PBWOW_ADS_TITLE'					=> 'PBWoW Advertisement Settings',
	'PBWOW_ADS_TITLE_EXPLAIN'			=> 'This page controls the way PBWoW displays advertisements. These blocks can of course also be used to put your own content, images, banners or whatever. Just keep in mind the size limitations.',

	'PBWOW_ADS_INDEX'					=> 'Index Advertisement Block',
	'PBWOW_ADS_INDEX_ENABLE'			=> 'Enable index advertisements',
	'PBWOW_ADS_INDEX_ENABLE_EXPLAIN'	=> 'Enabling this ad will generate a square ads block on the forum index page (requires NV Recent Topics MOD).',
	'PBWOW_ADS_INDEX_CODE'				=> 'Index advertisment code',
	'PBWOW_ADS_INDEX_CODE_EXPLAIN'		=> 'This block is suitable for advertisements with a <u>width</u> of: <b>300px</b>.<br />If you want to use/change custom CSS styling, please add it to <samp>styles/pbwow2/theme/custom.css</samp>',

	'PBWOW_ADS_TOP'						=> 'Horizontal (Top) Advertisement Block',
	'PBWOW_ADS_TOP_ENABLE'				=> 'Enable horizontal (top) forum advertisements',
	'PBWOW_ADS_TOP_ENABLE_EXPLAIN'		=> 'Enabling this ad will generate a horizontal bar advertisment at the top of every page except the index page.',
	'PBWOW_ADS_TOP_CODE'				=> 'Horizontal (top) advertisment code',
	'PBWOW_ADS_TOP_CODE_EXPLAIN'		=> 'Technically, this block has a maximum width of 930px, but this is not advisable (due to mobile devices, etc.). This block is generally suitable for advertisements with dimensions around: <b>728 x 90</b>.<br />If you want to use/change custom CSS styling, please add it to <samp>styles/pbwow2/theme/custom.css</samp>',
	
	'PBWOW_ADS_BOTTOM'					=> 'Horizontal (Bottom) Advertisement Block',
	'PBWOW_ADS_BOTTOM_ENABLE'			=> 'Enable horizontal (bottom) forum advertisements',
	'PBWOW_ADS_BOTTOM_ENABLE_EXPLAIN'	=> 'Enabling this ad will generate a horizontal bar advertisment at the bottom of every page except the index page.',
	'PBWOW_ADS_BOTTOM_CODE'				=> 'Horizontal (bottom) advertisment code',
	'PBWOW_ADS_BOTTOM_CODE_EXPLAIN'		=> 'Technically, this block has a maximum width of 930px, but this is not advisable (due to mobile devices, etc.). This block is generally suitable for advertisements with dimensions around: <b>728 x 90</b>.<br />If you want to use/change custom CSS styling, please add it to <samp>styles/pbwow2/theme/custom.css</samp>',
	
	// tracking
	'PBWOW_TRACKING'					=> 'Tracking Script',
	'PBWOW_TRACKING_ENABLE'				=> 'Enable tracking script for visitors',
	'PBWOW_TRACKING_ENABLE_EXPLAIN'		=> 'Enabling this will insert the code you enter at the bottom of the footer. This can be Google analytics or whatever scripts you want.',
	'PBWOW_TRACKING_CODE'				=> 'Tracking script code',
	'PBWOW_TRACKING_CODE_EXPLAIN'		=> 'Insert your tracking script code here, or whatever other script you want to use.',
));
