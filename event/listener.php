<?php

/**
*
* @package PBWoW Extension
* @copyright (c) 2014 PayBas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace paybas\pbwow\event;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
    exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/* @var \paybas\pbwow\core\main */
	protected $pbwow;

	public function __construct(\paybas\pbwow\core\pbwow $pbwow)
	{
		$this->pbwow = $pbwow;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'								=> 'page_header',
			'core.page_header_after'						=> 'page_header_after',

			'core.grab_profile_fields_data'					=> 'profile_fields_grab',
			'core.generate_profile_fields_template_data'	=> 'profile_fields_show',

			'core.viewtopic_cache_guest_data'				=> 'viewtopic_cache_guest',
			'core.viewtopic_cache_user_data'				=> 'viewtopic_cache_user',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_modify_post',

			'core.ucp_pm_view_messsage'						=> 'ucp_pm_view_messsage',

			'core.memberlist_view_profile'					=> 'memberlist_view_profile',
			'core.memberlist_prepare_profile_data'			=> 'memberlist_prepare_profile',

			'core.search_get_posts_data'					=> 'search_get_posts_data',
			'core.search_modify_tpl_ary'					=> 'search_modify_tpl_ary',

			// Topic Preview
			'core.viewforum_modify_topics_data'				=> 'topic_preview_modify_row',
			'core.search_modify_rowset'						=> 'topic_preview_modify_row',
			'paybas.recenttopics.modify_topics_list'		=> 'topic_preview_modify_row',
			'vse.topicpreview.display_topic_preview'		=> 'topic_preview_modify_display',
		);
	}

	public function page_header($event)
	{
		$this->pbwow->global_style_append($event);
	}
	public function page_header_after($event)
	{
		$this->pbwow->global_style_append_after($event);
	}

	public function profile_fields_grab($event)
	{
		$event['field_data'] = $this->pbwow->process_pf_grab($event['user_ids'], $event['field_data']);
	}
	public function profile_fields_show($event)
	{
		$event['tpl_fields'] = $this->pbwow->process_pf_show($event['profile_row'], $event['tpl_fields']);
	}


	public function viewtopic_cache_guest($event)
	{
		$event['user_cache_data'] = $this->pbwow->viewtopic_cache_guest($event['user_cache_data'], $event['poster_id']);
	}
	public function viewtopic_cache_user($event)
	{
		$event['user_cache_data'] = $this->pbwow->viewtopic_cache_user($event['user_cache_data'], $event['poster_id'], $event['row']);
	}
	public function viewtopic_modify_post($event)
	{
		$event['post_row'] = $this->pbwow->viewtopic_modify_post($event['user_poster_data'], $event['post_row'], $event['cp_row']);
	}


	public function ucp_pm_view_messsage($event)
	{
		$event['msg_data'] = $this->pbwow->ucp_pm_view_messsage($event['msg_data'], $event['cp_row']);
	}


	public function memberlist_view_profile($event)
	{
		$event['member'] = $this->pbwow->memberlist_view_profile($event['member'], $event['profile_fields']);
	}
	public function memberlist_prepare_profile($event)
	{
		$event['template_data'] = $this->pbwow->memberlist_prepare_profile($event['data'], $event['template_data']);
	}


	public function search_get_posts_data($event)
	{
		$array = $event['sql_array'];
		$array['SELECT'] .= ', u.user_rank, u.user_posts';
		$event['sql_array'] = $array; 
	}
	public function search_modify_tpl_ary($event)
	{
		if($event['show_results'] == 'posts') {
			$event['tpl_ary'] = $this->pbwow->search_modify_tpl_ary($event['row'], $event['tpl_ary'], $event['show_results']);
		}
	}


	public function topic_preview_modify_row($event)
	{
		if (sizeof($event['rowset']))
		{
			if ($event['show_results'] && $event['show_results'] == 'posts')
			{
				return;
			}

			$event['rowset'] = $this->pbwow->topic_preview_modify_row($event['rowset']);
		}
	}	
	public function topic_preview_modify_display($event)
	{
		$event['block'] = $this->pbwow->topic_preview_modify_display($event['row'], $event['block'], $event['tp_avatars']);
	}
}