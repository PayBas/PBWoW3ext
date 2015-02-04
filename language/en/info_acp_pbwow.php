<?php
/**
 *
 * @package PBWoW Extension
 * English translation by PayBas
 *
 * @copyright (c) 2015 PayBas
 * @license GNU General Public License, version 2 (GPL-2.0)
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

	// Common
	'PBWOW_ACTIVE'				=> 'active',
	'PBWOW_INACTIVE'			=> 'inactive',
	'PBWOW_DETECTED'			=> 'detected',
	'PBWOW_NOT_DETECTED'		=> 'not detected',
	'PBWOW_OBSOLETE'			=> 'no longer used',
	'PBWOW_FLUSH'				=> 'Flush',
	'PBWOW_FATAL'				=> 'Fatal error! This really should never happen.',

	'LOG_PBWOW_CONFIG'			=> '<strong>Altered PBWoW settings</strong><br />&raquo; %s',


	// OVERVIEW //

	'PBWOW_OVERVIEW_TITLE'				=> 'PBWoW Extension Overview',
	'PBWOW_OVERVIEW_TITLE_EXPLAIN'		=> 'Thank you for choosing PBWoW, hope you like it.',
	'ACP_PBWOW_INDEX_SETTINGS'			=> 'General information',

	'PBWOW_DB_CHECK'					=> 'PBWoW Database Check',
	'PBWOW_DB_GOOD'						=> 'PBWoW configuration table found (%s)',
	'PBWOW_DB_BAD'						=> 'No PBWoW configuration table found. Make sure that the table (%s) exists in your phpBB database.',
	'PBWOW_DB_BAD_EXPLAIN'				=> 'Try to disable and re-enable the PBWoW 3 extension. If that does not work, disable the extension and delete the data. Then try enabling it again.',

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

	'PBWOW_BNETCHARS_CHECK'				=> 'Battle.net API character information functionality',
	'PBWOW_CHARSDB_GOOD'				=> 'PBWoW characters table found (%s)',
	'PBWOW_CHARSDB_BAD'					=> 'No PBWoW characters table found. Make sure that the table (%s) exists in your phpBB database.',
	'PBWOW_CHARSDB_BAD_EXPLAIN'			=> 'The required PBWoW 3 Battle.net Characters database table should have been installed automatically when you installed the PBWoW extension. Please uninstall it, delete the data, and try installing it again.',
	'PBWOW_CHARSDB_FLUSH'				=> 'Flush/clear the characters table',
	'PBWOW_CHARSDB_FLUSH_EXPLAIN'		=> 'This will clear all the Battle.net character information stored in the DB. It will be retrieved again automatically when needed.',
	'PBWOW_CURL_BAD'					=> 'Your server does not allow &quot;cURL&quot;!',
	'PBWOW_CURL_BAD_EXPLAIN'			=> 'Check your server config, or contact your server host. Disable the Battle.net API until cURL is enabled!',

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

	'PBWOW_AVATARS'						=> 'Gaming Avatars',
	'PBWOW_AVATARS_ENABLE'				=> 'Enable board-wide gaming avatars (and icons)',
	'PBWOW_AVATARS_ENABLE_EXPLAIN'		=> 'If enabled, your board will display a generated gaming avatar (based on profile field entries) if the user has no custom avatar configured.',
	'PBWOW_AVATARS_PATH'				=> 'Gaming avatars path',
	'PBWOW_AVATARS_PATH_EXPLAIN'		=> 'Path under your phpBB root directory where the gaming avatars are stored, e.g. <samp>images/avatars/gaming</samp>.<br />Character icons also require this path to be set.',
	'PBWOW_SMALLRANKS_ENABLE'			=> 'Use small rank-images',
	'PBWOW_SMALLRANKS_ENABLE_EXPLAIN'	=> 'Enable this if you wish to use small rank-images that overlay the avatar (as it does on PBWoW.com). Don&#39;t enable this if you are using larger rank-images.',

	'PBWOW_BNET_APIKEY'					=> 'Battle.net API Key',
	'PBWOW_BNET_APIKEY_EXPLAIN'			=> 'Enter your Battle.net game API key. If you don&#39;t have one, get one by creating a <a href="https://dev.battle.net/member/register">Mashery account</a>.',
	'PBWOW_BNETCHARS'					=> 'Battle.net Character Information',
	'PBWOW_BNETCHARS_ENABLE'			=> 'Enable Battle.net API character information',
	'PBWOW_BNETCHARS_ENABLE_EXPLAIN'	=> 'Enable this feature to use the Battle.net API to retrieve character information (when available), for use in user profiles. The <u>Gaming Avatars</u> setting must be enabled to display Battle.net avatars!',
	'PBWOW_BNETCHARS_CACHETIME'			=> 'Cache time-to-live',
	'PBWOW_BNETCHARS_CACHETIME_EXPLAIN'	=> 'Sets the time-to-live (in seconds) of cached character information after it has been retrieved from the Battle.net API. You can change this to update character information more or less frequently. 86400 = 24h',
	'PBWOW_BNETCHARS_TIMEOUT'			=> 'API query time-out',
	'PBWOW_BNETCHARS_TIMEOUT_EXPLAIN'	=> 'Sets the time-out interval (in seconds) of Battle.net API requests. Basically meaning the maximum time that the script will wait for Battle.net to respond. Increase this if you think that (correct) data is not being received on time, but page load time can increase!',

	'PBWOW_ADS_INDEX'					=> 'Index Advertisement Block',
	'PBWOW_ADS_INDEX_ENABLE'			=> 'Enable index advertisement',
	'PBWOW_ADS_INDEX_ENABLE_EXPLAIN'	=> 'Enabling this ad will generate a narrow advertisement block on the forum index page (requires Recent Topics extension).',
	'PBWOW_ADS_INDEX_CODE'				=> 'Index advertisment code',
	'PBWOW_ADS_INDEX_CODE_EXPLAIN'		=> 'This block is suitable for advertisements with a <u>width</u> of: <b>300px</b>.<br />If you want to use/change custom CSS styling, please add it to <samp>styles/pbwow3/theme/custom.css</samp>',
));
