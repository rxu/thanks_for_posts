<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\ThanksForPosts\acp;

/**
* @package acp
*/
class acp_thanks_refresh_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $request, $template, $cache, $config, $phpbb_container;

		$this->tpl_name = 'acp_thanks_refresh';
		$this->page_title = 'ACP_THANKS_REFRESH';

		$posts_delete_us = $all_posts = array();
		$del_thanks = $end_thanks = $del_uthanks = $end_posts_thanks = $end_users_thanks = $thanks_update = 0;
		$del_nofirst_thanks = $del_selfthanks = $all_users_thanks = $all_thanks = $all_posts_number = $all_posts_thanks = 0;

		$thanks_table = $phpbb_container->getParameter('tables.thanks');

		// check mode
		$refresh = $request->variable('refresh', false);
		if (!$refresh)
		{
			$cache->destroy('_all_posts_thanks');
			$cache->destroy('_all_users_thanks');
			$cache->destroy('_all_thanks');
			$cache->destroy('_all_posts');
			$cache->destroy('_all_posts_number');

			// count all posts, thanks, users
			$sql = 'SELECT DISTINCT post_id
				FROM ' . $thanks_table;
			$result = $db->sql_query($sql);
			$all_posts_thanks = $db->sql_affectedrows($result);
			$db->sql_freeresult($result);

			$sql = 'SELECT DISTINCT user_id
				FROM ' . $thanks_table;
			$result = $db->sql_query($sql);
			$all_users_thanks = $db->sql_affectedrows($result);
			$db->sql_freeresult($result);

			$sql = 'SELECT COUNT(post_id) as total_match_count
				FROM ' . $thanks_table;
			$result = $db->sql_query($sql);
			$all_thanks = $db->sql_fetchfield('total_match_count');
			$db->sql_freeresult($result);

			unset($all_posts);
			$all_posts = array();

			$sql = 'SELECT t.*
				FROM ' . $thanks_table .' t
				LEFT JOIN ' . POSTS_TABLE .' p ON t.post_id = p.post_id
				WHERE p.post_id IS NULL';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				$all_posts[] = $row['post_id'];
			}
			$db->sql_freeresult($result);
			$all_posts_number = $config['num_posts'];

			$cache->put('_all_posts_thanks', $all_posts_thanks);
			$cache->put('_all_users_thanks', $all_users_thanks);
			$cache->put('_all_thanks', $all_thanks);
			$cache->put('_all_posts', $all_posts);
			$cache->put('_all_posts_number', $all_posts_number);

			$template->assign_vars(array(
				'S_REFRESH'	=> false,
				'L_WARNING' => sprintf($user->lang['WARNING']),
			));
		}
		//update
		if ($refresh)
		{
			// check mode
			if (confirm_box(true))
			{
				$all_users_thanks = (int) $cache->get('_all_users_thanks');
				$all_thanks = (int) $cache->get('_all_thanks');
				$all_posts = $cache->get('_all_posts');
				$all_posts_number = (int) $cache->get('_all_posts_number');
				$all_posts_thanks = (int) $cache->get('_all_posts_thanks');

				// update delete posts
				if (!empty($all_posts))
				{
					$sql = 'DELETE FROM ' . $thanks_table ."
						WHERE " . $db->sql_in_set('post_id', $all_posts, false);
					$result = $db->sql_query($sql);
					$del_thanks = (int) $db->sql_affectedrows($result);
					$db->sql_freeresult($result);
					$end_thanks = $all_thanks - $del_thanks;
				}

				// update delete users
				$sql = 'SELECT t.post_id
					FROM ' . $thanks_table . ' t 
					LEFT JOIN ' . POSTS_TABLE . ' p ON (t.post_id = p.post_id)
					WHERE p.poster_id = '. ANONYMOUS;
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$posts_delete_us[] = $row['post_id'];
				}
				$db->sql_freeresult($result);

				if (!empty($posts_delete_us))
				{
					$del_uthanks = count($posts_delete_us);
					$sql = 'DELETE FROM ' . $thanks_table ."
						WHERE " . $db->sql_in_set('post_id', $posts_delete_us);
					$result = $db->sql_query($sql);
					$db->sql_freeresult($result);
				}
				//update move posts /topics /forums and change posters
				$sql = 'SELECT p.post_id
					FROM ' . POSTS_TABLE . ' p 
					LEFT JOIN ' . $thanks_table . ' t ON (p.post_id = t.post_id)
					WHERE p.topic_id <> t.topic_id OR p.forum_id <> t.forum_id OR p.poster_id <> t.poster_id';
				$result = $db->sql_query($sql);
				$thanks_update = 0;
				if ($result)
				{
					while ($row = $db->sql_fetchrow($result))
					{
						$sql = 'SELECT forum_id, topic_id, poster_id, post_id
							FROM ' . POSTS_TABLE . '
							WHERE post_id = '.$row['post_id'];
						$results = $db->sql_query($sql);
						$rows = $db->sql_fetchrow($results);

						$sql_ary = array(
							'post_id'	=> $rows['post_id'],
							'forum_id'	=> $rows['forum_id'],
							'topic_id'	=> $rows['topic_id'],
							'poster_id'	=> $rows['poster_id'],
						);

						$sql = 'UPDATE ' . $thanks_table . '
							SET ' . $db->sql_build_array('UPDATE', $sql_ary) .'
							WHERE post_id = '. $sql_ary['post_id'];
						$db->sql_query($sql);
						$thanks_update++;
					}
				}
				$db->sql_freeresult($result);

				$end_thanks = $end_thanks - $del_uthanks;
				$del_thanks = $del_thanks + $del_uthanks;
				// delete thanks only first post
				if (isset($config['thanks_only_first_post']) ? $config['thanks_only_first_post'] : false)
				{
					$sql = 'SELECT topic_first_post_id 
						FROM ' . TOPICS_TABLE;
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$all_first_posts[] = $row['topic_first_post_id'];
					}
					$db->sql_freeresult($result);

					if (!empty($all_first_posts))
					{
						$sql = 'DELETE FROM ' . $thanks_table ."
							WHERE " . $db->sql_in_set('post_id', $all_first_posts, true);
						$result = $db->sql_query($sql);
						$del_nofirst_thanks = $db->sql_affectedrows($result);
						$db->sql_freeresult($result);
						$end_thanks = $end_thanks - $del_nofirst_thanks;
						$del_thanks = $del_thanks + $del_nofirst_thanks;
					}
				}
				// delete thanks global announce
				if (isset($config['thanks_global_post']) ? !$config['thanks_global_post'] : false)
				{
					$sql = 'SELECT topic_id 
						FROM ' . TOPICS_TABLE .'
						WHERE topic_type = '. POST_GLOBAL;
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$all_global_posts[] = $row['topic_id'];
					}
					$db->sql_freeresult($result);

					if (!empty($all_global_posts))
					{
						$sql = 'DELETE FROM ' . $thanks_table ."
							WHERE " . $db->sql_in_set('topic_id', $all_global_posts, false);
						$result = $db->sql_query($sql);
						$del_global_thanks = $db->sql_affectedrows($result);
						$db->sql_freeresult($result);
						$end_thanks = $end_thanks - $del_global_thanks;
						$del_thanks = $del_thanks + $del_global_thanks;
					}
				}
				// delete selfthanks
				$sql = 'DELETE FROM ' . $thanks_table .'
					WHERE poster_id = user_id';
				$result = $db->sql_query($sql);
				$del_selfthanks = $db->sql_affectedrows($result);
				$db->sql_freeresult($result);
				$del_thanks = $del_thanks + $del_selfthanks;
				$end_thanks = $end_thanks - $del_selfthanks;

				$sql = 'SELECT DISTINCT post_id
					FROM ' . $thanks_table;
				$result = $db->sql_query($sql);
				$end_posts_thanks = $db->sql_affectedrows($result);
				$db->sql_freeresult($result);

				$sql = 'SELECT DISTINCT user_id
					FROM ' . $thanks_table;
				$result = $db->sql_query($sql);
				$end_users_thanks = $db->sql_affectedrows($result);
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_REFRESH'	=> true,
				));
			}
			else
			{
				$s_hidden_fields = build_hidden_fields(array(
					'refresh'		=> true,
					)
				);
				//display mode
				confirm_box(false, 'REFRESH_THANKS', $s_hidden_fields);
				trigger_error($user->lang['TRUNCATE_NO_THANKS'] . adm_back_link($this->u_action));
			}
		}
		$template->assign_vars(array(
			'POSTS'			=> $all_posts_number,

			'POSTSTHANKS'	=> $all_posts_thanks,
			'USERSTHANKS'	=> $all_users_thanks,
			'ALLTHANKS'		=> $all_thanks,

			'DELTHANKS'		=> $del_thanks,
			'UPDATETHANKS'	=> $thanks_update,

			'POSTSEND'		=> $end_posts_thanks,
			'USERSEND'		=> $end_users_thanks,
			'THANKSEND'		=> $end_thanks,
		));
	}
}
