<?php
/**
 *
 * Thanks For Posts.
 * Adds the ability to thank the author and to use per posts/topics/forum rating system based on the count of thanks.
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace gfksx\thanksforposts\acp;

/**
* @package acp
*/
class acp_thanks_truncate_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbb\db\driver\driver_interface $db DBAL object */
		$db = $phpbb_container->get('dbal.conn');

		/** @var \phpbb\language\language $language Language object */
		$language = $phpbb_container->get('language');

		/** @var \phpbb\request\request $request Request object */
		$request  = $phpbb_container->get('request');

		/** @var \phpbb\template\template $template Template object */
		$template = $phpbb_container->get('template');

		/** @var string $thanks_table _thanks database table */
		$thanks_table = $phpbb_container->getParameter('tables.thanks');

		$this->tpl_name = 'acp_thanks_truncate';
		$this->page_title = 'ACP_THANKS_TRUNCATE';

		$sql = 'SELECT COUNT(post_id) as total_match_count
			FROM ' . $thanks_table;
		$result = $db->sql_query($sql);
		$all_thanks = $end_thanks = (int) $db->sql_fetchfield('total_match_count');
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(DISTINCT post_id) as total_match_count
			FROM ' . $thanks_table;
		$result = $db->sql_query($sql);
		$all_posts_thanks = $del_posts = $end_posts_thanks = (int) $db->sql_fetchfield('total_match_count');
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(DISTINCT user_id) as total_match_count
			FROM ' . $thanks_table;
		$result = $db->sql_query($sql);
		$all_users_thanks = $del_uposts = $end_users_thanks = (int) $db->sql_fetchfield('total_match_count');
		$db->sql_freeresult($result);

		$truncate = $request->variable('truncate', false);

		if ($truncate)
		{
			if (confirm_box(true))
			{
				$sql = 'DELETE FROM ' . $thanks_table;
				$db->sql_query($sql);

				$sql = 'SELECT COUNT(post_id) as total_match_count
					FROM ' . $thanks_table;
				$result = $db->sql_query($sql);
				$end_thanks = $db->sql_fetchfield('total_match_count');
				$db->sql_freeresult($result);

				$end_posts_thanks = $all_posts_thanks - $del_posts;
				$end_users_thanks = $all_users_thanks - $del_uposts;
			}
			else
			{
				$s_hidden_fields = build_hidden_fields([
					'truncate'		=> true,
				]);

				// Display mode
				confirm_box(false, 'TRUNCATE_THANKS', $s_hidden_fields);
				trigger_error($language->lang('TRUNCATE_NO_THANKS') . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars([
			'ALLTHANKS'		=> $all_thanks,
			'POSTSTHANKS'	=> $all_posts_thanks,
			'USERSTHANKS'	=> $all_users_thanks,
			'POSTSEND'		=> $end_posts_thanks,
			'USERSEND'		=> $end_users_thanks,
			'THANKSEND'		=> $end_thanks,
			'S_TRUNCATE' 	=> $truncate,
		]);
	}
}
