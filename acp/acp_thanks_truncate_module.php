<?php
/**
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: acp_thanks_truncate.php,v 135 2012-10-10 10:02:51 Палыч$
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace gfksx\ThanksForPosts\acp;

/**
* @package acp
*/
class acp_thanks_truncate_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $request, $user, $template, $table_prefix;

		$this->tpl_name = 'acp_thanks_truncate';
		$this->page_title = 'ACP_THANKS_TRUNCATE';

		$all_posts_thanks = $all_thanks = $del_thanks = $del_uposts = $del_posts = 0;

		if (!defined('THANKS_TABLE'))
		{
			define('THANKS_TABLE', $table_prefix . 'thanks');
		}

		$sql = 'SELECT COUNT(post_id) as total_match_count
			FROM ' . THANKS_TABLE;
		$result = $db->sql_query($sql);
		$all_thanks = $end_thanks = $del_thanks = $db->sql_fetchfield('total_match_count');
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(DISTINCT post_id) as total_match_count
			FROM ' . THANKS_TABLE;
		$result = $db->sql_query($sql);
		$all_posts_thanks = $del_posts = $end_posts_thanks = $db->sql_fetchfield('total_match_count');
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(DISTINCT user_id) as total_match_count
			FROM ' . THANKS_TABLE;
		$result = $db->sql_query($sql);
		$all_users_thanks = $del_uposts = $end_users_thanks = $db->sql_fetchfield('total_match_count');
		$db->sql_freeresult($result);

		$truncate = $request->variable('truncate', false);

		if ($truncate)
		{
			// check mode
			if (confirm_box(true))
			{
				$sql = 'TRUNCATE TABLE ' . THANKS_TABLE;
				$result = $db->sql_query($sql);
				$db->sql_freeresult($result);

				$sql = 'SELECT COUNT(post_id) as total_match_count
					FROM ' . THANKS_TABLE;
				$result = $db->sql_query($sql);
				$end_thanks = $db->sql_fetchfield('total_match_count');
				$db->sql_freeresult($result);

				$end_posts_thanks = $all_posts_thanks - $del_posts;
				$end_users_thanks = $all_users_thanks - $del_uposts;
				$del_thanks = $all_thanks - $end_thanks;
			}
			else
			{
				$s_hidden_fields = build_hidden_fields(array(
					'truncate'		=> true,
					)
				);
				//display mode
				confirm_box(false, 'TRUNCATE_THANKS', $s_hidden_fields);
				trigger_error($user->lang['TRUNCATE_NO_THANKS'] . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars(array(
			'ALLTHANKS'		=> $all_thanks,
			'POSTSTHANKS'	=> $all_posts_thanks,
			'USERSTHANKS'	=> $all_users_thanks,
			'POSTSEND'		=> $end_posts_thanks,
			'USERSEND'		=> $end_users_thanks,
			'THANKSEND'		=> $end_thanks,
			'S_TRUNCATE' 	=> $truncate,
		));
	}
}
