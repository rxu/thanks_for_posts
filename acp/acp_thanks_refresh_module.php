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
class acp_thanks_refresh_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbb\cache\driver\driver_interface $cache Cache driver object */
		$cache = $phpbb_container->get('cache.driver');

		/** @var \phpbb\config\config $config Config object */
		$config = $phpbb_container->get('config');

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

		$this->tpl_name = 'acp_thanks_refresh';
		$this->page_title = 'ACP_THANKS_REFRESH';

		$posts_delete_us = [];
		$del_thanks = $end_thanks = $del_uthanks = $end_posts_thanks = $end_users_thanks = $thanks_update = 0;
		$all_users_thanks = $all_thanks = $all_posts_number = $all_posts_thanks = 0;

		$refresh = $request->variable('refresh', false);
		if (!$refresh)
		{
			$cache->destroy('_all_posts_thanks');
			$cache->destroy('_all_users_thanks');
			$cache->destroy('_all_thanks');
			$cache->destroy('_all_posts');
			$cache->destroy('_all_posts_number');

			// Count all posts, thanks, users
			$sql = 'SELECT COUNT(DISTINCT post_id) as all_posts_thanks
				FROM ' . $thanks_table;
			$result = $db->sql_query($sql);
			$all_posts_thanks = (int) $db->sql_fetchfield('all_posts_thanks');
			$db->sql_freeresult($result);

			$sql = 'SELECT COUNT(DISTINCT user_id) as all_users_thanks
				FROM ' . $thanks_table;
			$result = $db->sql_query($sql);
			$all_users_thanks = (int) $db->sql_fetchfield('all_users_thanks');
			$db->sql_freeresult($result);

			$sql = 'SELECT COUNT(post_id) as total_match_count
				FROM ' . $thanks_table;
			$result = $db->sql_query($sql);
			$all_thanks = (int) $db->sql_fetchfield('total_match_count');
			$db->sql_freeresult($result);

			$all_posts = [];
			$sql_ary = [
				'SELECT' =>  't.*',
				'FROM' => [$thanks_table => 't'],
				'LEFT_JOIN' => [
					[
						'FROM' => [POSTS_TABLE => 'p'],
						'ON' => 't.post_id = p.post_id',
					],
				],
				'WHERE' => 'p.post_id IS NULL',
			];
			$result = $db->sql_query($db->sql_build_query('SELECT', $sql_ary));

			while ($row = $db->sql_fetchrow($result))
			{
				$all_posts[] = (int) $row['post_id'];
			}
			$db->sql_freeresult($result);

			$all_posts_number = (int) $config['num_posts'];

			$cache->put('_all_posts_thanks', $all_posts_thanks);
			$cache->put('_all_users_thanks', $all_users_thanks);
			$cache->put('_all_thanks', $all_thanks);
			$cache->put('_all_posts', $all_posts);
			$cache->put('_all_posts_number', $all_posts_number);

			$template->assign_vars([
				'S_REFRESH'	=> false,
			]);
		}

		// Update
		if ($refresh)
		{
			if (confirm_box(true))
			{
				$all_users_thanks = (int) $cache->get('_all_users_thanks');
				$all_thanks = (int) $cache->get('_all_thanks');
				$all_posts = (array) $cache->get('_all_posts');
				$all_posts_number = (int) $cache->get('_all_posts_number');
				$all_posts_thanks = (int) $cache->get('_all_posts_thanks');

				// Update deleted posts thanks
				if (!empty($all_posts))
				{
					$sql = 'DELETE FROM ' . $thanks_table ."
						WHERE " . $db->sql_in_set('post_id', $all_posts, false);
					$db->sql_query($sql);
					$del_thanks = (int) $db->sql_affectedrows();
					$end_thanks = $all_thanks - $del_thanks;
				}

				// Update deleted users thanks
				$sql_ary = [
					'SELECT' =>  't.post_id',
					'FROM' => [$thanks_table => 't'],
					'LEFT_JOIN' => [
						[
							'FROM' => [POSTS_TABLE => 'p'],
							'ON' => 't.post_id = p.post_id',
						],
					],
					'WHERE' => 'p.poster_id = '. ANONYMOUS,
				];
				$result = $db->sql_query($db->sql_build_query('SELECT', $sql_ary));

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
					$db->sql_query($sql);
				}

				// Update moved posts /topics /forums and changed posters data
				$sql_ary = [
					'SELECT' =>  'p.post_id',
					'FROM' => [POSTS_TABLE => 'p'],
					'LEFT_JOIN' => [
						[
							'FROM' => [$thanks_table => 't'],
							'ON' => 'p.post_id = t.post_id',
						],
					],
					'WHERE' => 'p.topic_id <> t.topic_id OR p.forum_id <> t.forum_id OR p.poster_id <> t.poster_id',
				];
				$result = $db->sql_query($db->sql_build_query('SELECT', $sql_ary));

				$thanks_updated = 0;
				if ($result)
				{
					while ($row = $db->sql_fetchrow($result))
					{
						$sql = 'SELECT forum_id, topic_id, poster_id, post_id
							FROM ' . POSTS_TABLE . '
							WHERE post_id = ' . (int) $row['post_id'];
						$results = $db->sql_query($sql);
						$rows = $db->sql_fetchrow($results);
						$db->sql_freeresult($results);

						$sql_ary = [
							'post_id'	=> $rows['post_id'],
							'forum_id'	=> $rows['forum_id'],
							'topic_id'	=> $rows['topic_id'],
							'poster_id'	=> $rows['poster_id'],
						];

						$sql = 'UPDATE ' . $thanks_table . '
							SET ' . $db->sql_build_array('UPDATE', $sql_ary) .'
							WHERE post_id = '. $sql_ary['post_id'];
						$db->sql_query($sql);
						$thanks_updated++;
					}
				}
				$db->sql_freeresult($result);

				$end_thanks = $end_thanks - $del_uthanks;
				$del_thanks = $del_thanks + $del_uthanks;

				// Delete topic first posts thanks
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
						$db->sql_query($sql);
						$del_nofirst_thanks = $db->sql_affectedrows();
						$end_thanks = $end_thanks - $del_nofirst_thanks;
						$del_thanks = $del_thanks + $del_nofirst_thanks;
					}
				}

				// Delete global announces thanks
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
						$db->sql_query($sql);
						$del_global_thanks = $db->sql_affectedrows();
						$end_thanks = $end_thanks - $del_global_thanks;
						$del_thanks = $del_thanks + $del_global_thanks;
					}
				}

				// Delete selfthanks
				$sql = 'DELETE FROM ' . $thanks_table .'
					WHERE poster_id = user_id';
				$db->sql_query($sql);
				$del_selfthanks = $db->sql_affectedrows();

				$del_thanks = $del_thanks + $del_selfthanks;
				$end_thanks = $end_thanks - $del_selfthanks;

				$sql = 'SELECT COUNT(DISTINCT post_id) as end_posts_thanks
					FROM ' . $thanks_table;
				$result = $db->sql_query($sql);
				$end_posts_thanks = (int) $db->sql_fetchfield('end_posts_thanks');
				$db->sql_freeresult($result);

				$sql = 'SELECT COUNT(DISTINCT user_id) as end_users_thanks
					FROM ' . $thanks_table;
				$result = $db->sql_query($sql);
				$end_users_thanks = (int) $db->sql_fetchfield('end_users_thanks');
				$db->sql_freeresult($result);

				$template->assign_vars([
					'S_REFRESH'	=> true,
				]);
			}
			else
			{
				$s_hidden_fields = build_hidden_fields([
					'refresh'		=> true,
				]);

				// Display mode
				confirm_box(false, 'REFRESH_THANKS', $s_hidden_fields);
				trigger_error($language->lang('TRUNCATE_NO_THANKS') . adm_back_link($this->u_action));
			}
		}
		$template->assign_vars([
			'POSTS'			=> $all_posts_number,

			'POSTSTHANKS'	=> $all_posts_thanks,
			'USERSTHANKS'	=> $all_users_thanks,
			'ALLTHANKS'		=> $all_thanks,

			'DELTHANKS'		=> $del_thanks,
			'UPDATETHANKS'	=> $thanks_update,

			'POSTSEND'		=> $end_posts_thanks,
			'USERSEND'		=> $end_users_thanks,
			'THANKSEND'		=> $end_thanks,
		]);
	}
}
