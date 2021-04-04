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

namespace gfksx\thanksforposts\core;

class helper
{
	/** @var array thankers */
	protected $thankers = [];

	/** @var array forum_thanks */
	protected $forum_thanks = [];

	/** @var int max_post_thanks */
	protected $max_post_thanks = 0;

	/** @var int max_topic_thanks */
	protected $max_topic_thanks = 0;

	/** @var int max_forum_thanks */
	protected $max_forum_thanks = 0;

	/** @var int poster_list_count */
	protected $poster_list_count;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\notification\manager */
	protected $notification_manager;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\event\dispatcher_interface */
	protected $phpbb_dispatcher;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string THANKS_TABLE */
	protected $thanks_table;

	/** @var string USERS_TABLE */
	protected $users_table;

	/** @var string POSTS_TABLE */
	protected $posts_table;

	/** @var string NOTIFICATIONS_TABLE */
	protected $notifications_table;

	/** @var array */
	public $topic_data;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config                 $config                Config object
	 * @param \phpbb\db\driver\driver_interface    $db                    DBAL object
	 * @param \phpbb\auth\auth                     $auth                  User object
	 * @param \phpbb\template\template             $template              Template object
	 * @param \phpbb\user                          $user                  User object
	 * @param \phpbb\cache\driver\driver_interface $cache                 Cache driver object
	 * @param \phpbb\request\request_interface     $request               Request object
	 * @param \phpbb\request\request_interface     $request               Request object
	 * @param \phpbb\controller\helper             $controller_helper     Controller helper object
	 * @param \phpbb\event\dispatcher_interface    $phpbb_dispatcher      Event dispatcher object
	 * @param \phpbb\language\language             $language              Language object
	 * @param string                               $phpbb_root_path       phpbb_root_path
	 * @param string                               $php_ext               phpEx
	 * @param string                               $thanks_table          THANKS_TABLE
	 * @param string                               $users_table           USERS_TABLE
	 * @param string                               $posts_table           POSTS_TABLE
	 * @param string                               $notifications_table   NOTIFICATIONS_TABLE
	 * @access public
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\auth\auth $auth,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\request\request_interface $request,
		\phpbb\notification\manager $notification_manager,
		\phpbb\controller\helper $controller_helper,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\phpbb\language\language $language,
		$phpbb_root_path, $php_ext, $thanks_table, $users_table, $posts_table, $notifications_table
	)
	{
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
		$this->template = $template;
		$this->user = $user;
		$this->cache = $cache;
		$this->request = $request;
		$this->notification_manager = $notification_manager;
		$this->controller_helper = $controller_helper;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->language = $language;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->thanks_table = $thanks_table;
		$this->users_table = $users_table;
		$this->posts_table = $posts_table;
		$this->notifications_table = $notifications_table;
		$this->topic_data = [];
	}

	// Output thanks list
	public function get_thanks($post_id)
	{
		$view = $this->request->variable('view', '');
		$further_thanks_text = $return = '';
		$user_list = array();
		$further_thanks = $count = 0;
		$maxcount = (int) $this->config['thanks_number_post'];

		foreach ($this->thankers as $thanker)
		{
			if ($thanker['post_id'] == $post_id)
			{
				if ($count >= $maxcount)
				{
					$further_thanks++;
				}
				else
				{
					$thanks_time_info = (($this->config['thanks_time_view'] && $thanker['thanks_time']) ? $this->user->format_date($thanker['thanks_time'], false, ($view == 'print') ? true : false) : '');
					$usertname_string_tpl = ($thanks_time_info) ? '<span title="' . $thanks_time_info . '">' . 'USERNAME_STRING' . '</span>' : 'USERNAME_STRING';
					$user_list[] = str_replace('USERNAME_STRING', get_username_string('full', $thanker['user_id'], $thanker['username'], $thanker['user_colour']), $usertname_string_tpl);
					$count++;
				}
			}
		}

		if (!empty($user_list))
		{
			$return = implode(', ', $user_list);
		}

		if ($further_thanks > 0)
		{
			$further_thanks_text = $this->language->lang('FURTHER_THANKS', $further_thanks);
		}
		$return = ($return == '') ? false : ($return . $further_thanks_text);

		return $return;
	}

	public function get_thanks_number($post_id)
	{
		$i = 0;
		foreach ($this->thankers as $thanker)
		{
			if ($thanker['post_id'] == $post_id)
			{
				$i++;
			}
		}
		return $i;
	}

	public function insert_thanks($post_id, $user_id, $forum_id)
	{
		$to_id = $this->request->variable('to_id', 0);
		$from_id = $this->request->variable('from_id', 0);
		$row = $this->get_post_info($post_id);

		if ($this->user->data['user_type'] != USER_IGNORE && !empty($to_id))
		{
			if ($row['poster_id'] != $user_id && $row['poster_id'] == $to_id && !$this->already_thanked($post_id, $user_id) && ($this->auth->acl_get('f_thanks', $row['forum_id']) || (!$row['forum_id'] && $this->config['thanks_global_post'])) && $from_id == $user_id)
			{
				$thanks_data = [
					'user_id'		=> (int) $this->user->data['user_id'],
					'post_id'		=> $post_id,
					'poster_id'		=> $to_id,
					'topic_id'		=> (int) $row['topic_id'],
					'forum_id'		=> (int) $row['forum_id'],
					'thanks_time'	=> time(),
				];
				$sql = 'INSERT INTO ' . $this->thanks_table . ' ' . $this->db->sql_build_array('INSERT', $thanks_data);
				$this->db->sql_query($sql);

				$lang_act = 'GIVE';
				$thanks_data = array_merge($thanks_data, [
					'username'		=> $this->user->data['username'],
					'lang_act'		=> $lang_act,
					'post_subject'	=> $row['post_subject'],
				]);

				$this->add_notification($thanks_data);

				if ($this->config['thanks_info_page'])
				{
					meta_refresh (1, append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id .'&amp;p=' . $post_id . '#p' . $post_id));
					trigger_error($this->language->lang('THANKS_INFO_' . $lang_act) . '<br /><br />' . $this->language->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id .'&amp;p=' . $post_id . '#p' . $post_id) . '">', '</a>'));
				}
				else
				{
					redirect(append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $post_id . '#p' . $post_id));
				}
			}
			else if (!$row['forum_id'] && !$this->config['thanks_global_post'])
			{
				trigger_error($this->language->lang('GLOBAL_INCORRECT_THANKS') . '<br /><br />' . $this->language->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $post_id . '#p' . $post_id) . '">', '</a>'));
			}
			else
			{
				trigger_error($this->language->lang('INCORRECT_THANKS') . '<br /><br />' . $this->language->lang('RETURN_POST', '<a href="'.append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $post_id . '#p' . $post_id) . '">', '</a>'));
			}
		}
	}

	public function clear_list_thanks($object_id, $mode = '')
	{
		if (empty($mode) || !in_array($mode, ['give', 'receive', 'post']))
		{
			trigger_error($this->language->lang('INCORRECT_THANKS'));
		}

		if (!$this->auth->acl_get('m_thanks'))
		{
			trigger_error($this->language->lang('NOT_AUTHORISED'));
		}

		$s_hidden_fields = build_hidden_fields([
				'list_thanks'	=> $mode,
		]);

		$redirect_url = append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . (string) $object_id);

		switch ($mode)
		{
			case 'give':
				$field_act = 'user_id';
			break;

			case 'receive':
				$field_act = 'poster_id';
			break;

			case 'post':
				$field_act = 'post_id';
				$redirect_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . (string) $object_id . '#p' . (string) $object_id);
			break;
		}

		if (confirm_box(true))
		{
			$sql = "DELETE FROM " . $this->thanks_table . '
				WHERE ' . $field_act . ' = ' . (int) $object_id;

			if ($this->db->sql_query($sql))
			{
				if ($this->config['thanks_info_page'])
				{
					meta_refresh (1, $redirect_url);
					trigger_error($this->language->lang('CLEAR_LIST_THANKS_' . strtoupper($mode)) . '<br /><br />' . $this->language->lang('BACK_TO_PREV', '<a href="' . $redirect_url . '">', '</a>'));
				}
				else
				{
					redirect($redirect_url);
				}
			}
		}
		else
		{
			confirm_box(false, 'CLEAR_LIST_THANKS', $s_hidden_fields);
			redirect($redirect_url);
		}
	}

	public function delete_thanks($post_id, $forum_id)
	{
		$to_id = $this->request->variable('to_id', 0);
		$forum_id = ((int) $forum_id) ?: $this->request->variable('f', 0);
		$row = $this->get_post_info((int) $post_id);
		$redirect_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id");

		$hidden = build_hidden_fields([
			'to_id'		=> $to_id,
			'rthanks'	=> $post_id,
		]);

		/**
		 * This event allows to interrupt before a thanks is deleted
		 *
		 * @event gfksx.thanksforposts.delete_thanks_before
		 * @var	int		post_id		The post id
		 * @var	int		forum_id	The forum id
		 * @since 2.0.3
		 */
		$vars = ['post_id', 'forum_id'];
		extract($this->phpbb_dispatcher->trigger_event('gfksx.thanksforposts.delete_thanks_before', compact($vars)));

		if (!$this->config['remove_thanks'])
		{
			trigger_error($this->language->lang('DISABLE_REMOVE_THANKS') . '<br /><br />' . $this->language->lang('RETURN_POST', '<a href="' . $redirect_url . '">', '</a>'));
		}

		if (confirm_box(true, 'REMOVE_THANKS', $hidden))
		{
			if ($this->user->data['user_type'] != USER_IGNORE && !empty($to_id) && $this->auth->acl_get('f_thanks', $forum_id))
			{
				$sql = 'DELETE FROM ' . $this->thanks_table . '
					WHERE post_id =' . (int) $post_id . ' AND user_id = ' . (int) $this->user->data['user_id'];
				$this->db->sql_query($sql);

				if ($this->db->sql_affectedrows())
				{
					$thanks_data = array(
						'user_id'	=> (int) $this->user->data['user_id'],
						'post_id'	=> $post_id,
						'poster_id'	=> $to_id,
						'topic_id'	=> (int) $row['topic_id'],
						'forum_id'	=> $forum_id,
						'thanks_time'	=> time(),
						'username'	=> $this->user->data['username'],
						'lang_act'	=> 'REMOVE',
						'post_subject'	=> $row['post_subject'],
					);
					$this->add_notification($thanks_data, 'gfksx.thanksforposts.notification.type.thanks_remove');

					if ($this->config['thanks_info_page'])
					{
						meta_refresh (1, $redirect_url);
						trigger_error($this->language->lang('THANKS_INFO_REMOVE') . '<br /><br />' . $this->language->lang('RETURN_POST', '<a href="' . $redirect_url . '">', '</a>'));
					}
					else
					{
						redirect ($redirect_url);
					}
				}
				else
				{
					trigger_error($this->language->lang('INCORRECT_THANKS') . '<br /><br />' . $this->language->lang('RETURN_POST', '<a href="' . $redirect_url . '">', '</a>'));
				}
			}
		}
		else
		{
			confirm_box(false, 'REMOVE_THANKS', $hidden);
			redirect($redirect_url);
		}
	}

	// Display the text/image saying either to add or remove thanks
	public function get_thanks_text($post_id)
	{
		$already_thanked = $this->already_thanked($post_id, $this->user->data['user_id']);
		return [
			'THANK_ALT'			=> $this->language->lang($already_thanked ? 'REMOVE_THANKS' : 'THANK_POST'),
			'THANK_ALT_SHORT'	=> $this->language->lang($already_thanked ? 'REMOVE_THANKS_SHORT' : 'THANK_POST_SHORT'),
			'THANKED'			=> $already_thanked,
		];
	}

	// Change the variable sent via the link to avoid odd errors
	public function get_thanks_link($post_id)
	{
		return $this->already_thanked($post_id, $this->user->data['user_id']) ? 'rthanks' : 'thanks';
	}

	// Check if the user has already thanked that post
	public function already_thanked($post_id, $user_id)
	{
		$already_thanked = false;
		foreach ($this->thankers as $thanker)
		{
			if ($thanker['post_id'] == $post_id && $thanker['user_id'] == $user_id)
			{
				$already_thanked = true;
				break;
			}
		}

		return $already_thanked;
	}

	public function output_thanks_memberlist($user_id, $ex_fid_ary)
	{
		$user_thankers = $user_thanked = [];
		$poster_limit = (int) $this->config['thanks_number'];

		// Get all user's received thanks count
		$sql = 'SELECT poster_id, COUNT(*) AS poster_receive_count
			FROM ' . $this->thanks_table . '
			WHERE poster_id = ' . (int) $user_id. ' AND (' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0)
			GROUP BY poster_id';
		$result = $this->db->sql_query($sql);
		$poster_receive_count = (int) $this->db->sql_fetchfield('poster_receive_count');
		$this->db->sql_freeresult($result);

		// Get all user's given thanks count
		$sql = 'SELECT user_id, COUNT(*) AS poster_give_count
			FROM ' . $this->thanks_table . "
			WHERE user_id = " . (int) $user_id.  ' AND (' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0)
			GROUP BY user_id';
		$result = $this->db->sql_query($sql);
		$poster_give_count = (int) $this->db->sql_fetchfield('poster_give_count');
		$this->db->sql_freeresult($result);

		$sql_array = [
			'SELECT'	=> 't.user_id, t.post_id, u.username, u.user_colour',
			'FROM'		=> [$this->thanks_table => 't', $this->users_table => 'u'],
			'WHERE' 	=> 't.poster_id =' . (int) $user_id .' AND u.user_id = t.user_id AND (' . $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0)',
			'ORDER_BY'	=> 't.post_id DESC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, (int) $poster_limit);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_thankers[] = [
				'user_id' 		=> $row['user_id'],
				'post_id' 		=> $row['post_id'],
				'username'		=> $row['username'],
				'user_colour'	=> $row['user_colour'],
			];
		}
		$this->db->sql_freeresult($result);

		$collim = ($poster_limit > $poster_receive_count)? ceil($poster_receive_count/4) : ceil($poster_limit/4);
		$thanked_row = [];
		$i = $j = 0;
		foreach ($user_thankers as $thanker)
		{
			$i++;
			if ($i <= $poster_limit)
			{
				$thanked_row[$i]['USERNAME_FULL'] = get_username_string('full', $thanker['user_id'], $thanker['username'], $thanker['user_colour']);
				$thanked_row[$i]['U_POST_LINK'] = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $thanker['post_id']. '#p' . $thanker['post_id']);

				$j++;
				if ($j > $collim || $i == $poster_receive_count || $i == $poster_limit)
				{
					$thanked_row[$i]['S_SWITCH_COLUMN'] = true;
					$j = 0;
				}
			}
		}
		$this->template->assign_block_vars_array('thanked_row', $thanked_row);

		if ($poster_receive_count > $poster_limit)
		{
			$further_thanks = $poster_receive_count - $poster_limit;
			$further_thanks_text = $this->language->lang('FURTHER_THANKS', $further_thanks);
			$this->template->assign_var('FURTHER_THANKS_TEXT_RECEIVED', $further_thanks_text);
		}

		$sql_array = [
			'SELECT'	=> 't.poster_id, t.post_id, u.username, u.user_colour',
			'FROM'		=> [$this->thanks_table => 't', $this->users_table => 'u'],
			'WHERE'		=> 't.user_id =' . (int) $user_id . ' AND u.user_id = t.poster_id AND (' . $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0)',
			'ORDER_BY'	=> 't.post_id DESC',
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, (int) $poster_limit);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_thanked[] = array(
				'poster_id' 	=> $row['poster_id'],
				'post_id' 		=> $row['post_id'],
				'postername'	=> $row['username'],
				'poster_colour'	=> $row['user_colour'],
			);
		}
		$this->db->sql_freeresult($result);

		$collim = ($poster_limit > $poster_give_count) ? ceil($poster_give_count/4) : ceil($poster_limit/4);
		$thanks_row = array();
		$i = $j = 0;
		foreach ($user_thanked as $thanked)
		{
			$i++;
			if ($i <= $poster_limit)
			{
				$thanks_row[$i]['USERNAME_FULL'] = get_username_string('full', $thanked['poster_id'], $thanked['postername'], $thanked['poster_colour']);
				$thanks_row[$i]['U_POST_LINK'] = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $thanked['post_id']. '#p' . $thanked['post_id']);

				$j++;
				if ($j > $collim || $i == $poster_give_count || $i == $poster_limit)
				{
					$j = 0;
					if ($i < $poster_limit && $i < $poster_give_count)
					{
						$thanks_row[$i]['S_SWITCH_COLUMN'] = true;
					}
				}
			}
		}
		$this->template->assign_block_vars_array('thanks_row', $thanks_row);

		if ($poster_give_count > $poster_limit)
		{
			$further_thanks = $poster_give_count - $poster_limit;
			$further_thanks_text = $this->language->lang('FURTHER_THANKS', $further_thanks);
			$this->template->assign_var('FURTHER_THANKS_TEXT_GIVEN', $further_thanks_text);
		}

		$l_poster_receive_count = ($poster_receive_count) ? $this->language->lang('THANKS', $poster_receive_count) : '';
		$l_poster_give_count = ($poster_give_count) ? $this->language->lang('THANKS', $poster_give_count) : '';
		$this->template->assign_vars([
			'DELETE_IMG' 					=> $this->user->img('icon_post_delete', $this->language->lang('CLEAR_LIST_THANKS')),
			'POSTER_RECEIVE_COUNT'			=> $l_poster_receive_count,
			'POSTER_GIVE_COUNT'				=> $l_poster_give_count,
			'THANKS_PROFILELIST_VIEW'		=> $this->config['thanks_profilelist_view'],
			'S_MOD_THANKS'					=> $this->auth->acl_get('m_thanks'),
			'U_CLEAR_LIST_THANKS_GIVE'		=> append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $user_id . '&amp;list_thanks=give'),
			'U_CLEAR_LIST_THANKS_RECEIVE'	=> append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $user_id . '&amp;list_thanks=receive'),
		]);
	}

	public function output_thanks($poster_id, &$postrow, $row, $topic_data, $forum_id)
	{
		if (!empty($postrow))
		{
			$thanks_text = $this->get_thanks_text($row['post_id']);
			$thank_mode = $this->get_thanks_link($row['post_id']);
			$thanks_count = $this->get_thanks_number((int) $row['post_id']);
			$already_thanked = $this->already_thanked($row['post_id'], $this->user->data['user_id']);
			$l_poster_receive_count = (isset($this->poster_list_count[$poster_id]['R']) && $this->poster_list_count[$poster_id]['R']) ? $this->language->lang('THANKS', (int) $this->poster_list_count[$poster_id]['R']) : '';
			$l_poster_give_count = (isset($this->poster_list_count[$poster_id]['G']) && $this->poster_list_count[$poster_id]['G']) ? $this->language->lang('THANKS', (int) $this->poster_list_count[$poster_id]['G']) : '';

			// Correctly form URLs
			$u_receive_count_url = $this->controller_helper->route('gfksx_thanksforposts_thankslist_controller_user', ['mode' => 'givens', 'author_id' => $poster_id, 'give' => 'false', 'tslash' => '']);
			$u_give_count_url = $this->controller_helper->route('gfksx_thanksforposts_thankslist_controller_user', ['mode' => 'givens', 'author_id' => $poster_id, 'give' => 'true', 'tslash' => '']);

			$postrow = array_merge($postrow, $thanks_text, [
				'COND'						=> $already_thanked,
				'THANKS'					=> $this->get_thanks($row['post_id']),
				'THANK_MODE'				=> $thank_mode,
				'THANKS_LINK'				=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $row['post_id'] . '&amp;' . $thank_mode . '=' . $row['post_id'] . '&amp;to_id=' . $poster_id . '&amp;from_id=' . $this->user->data['user_id']),
				'THANK_TEXT'				=> $this->language->lang('THANK_TEXT_1'),
				'THANK_TEXT_2'				=> ($thanks_count != 1) ? $this->language->lang('THANK_TEXT_2PL', $thanks_count) : $this->language->lang('THANK_TEXT_2'),
				'THANKS_FROM'				=> $this->language->lang('THANK_FROM'),
				'POSTER_RECEIVE_COUNT'		=> $l_poster_receive_count,
				'POSTER_GIVE_COUNT'			=> $l_poster_give_count,
				'POSTER_RECEIVE_COUNT_LINK'	=> $u_receive_count_url,
				'POSTER_GIVE_COUNT_LINK'	=> $u_give_count_url,
				'S_IS_OWN_POST'				=> $this->user->data['user_id'] == $poster_id,
				'S_POST_ANONYMOUS'			=> $poster_id == ANONYMOUS,
				'THANK_IMG' 				=> ($already_thanked) ? $this->user->img('removethanks', $this->language->lang('REMOVE_THANKS') . get_username_string('username', $poster_id, $row['username'], $row['user_colour'], $row['post_username'])) : $this->user->img('thankposts', $this->language->lang('THANK_POST') . get_username_string('username', $poster_id, $row['username'], $row['user_colour'], $row['post_username'])),
				'DELETE_IMG' 				=> $this->user->img('icon_post_delete', $this->language->lang('CLEAR_LIST_THANKS')),
				'THANKS_POSTLIST_VIEW'		=> $this->config['thanks_postlist_view'],
				'THANKS_COUNTERS_VIEW'		=> $this->config['thanks_counters_view'],
				'S_ALREADY_THANKED'			=> $already_thanked,
				'S_REMOVE_THANKS'			=> (bool) $this->config['remove_thanks'],
				'S_FIRST_POST_ONLY'			=> (bool) $this->config['thanks_only_first_post'],
				'POST_REPUT'				=> ($thanks_count != 0) ? round($thanks_count / ($this->max_post_thanks / 100), (int) $this->config['thanks_number_digits']) . '%' : '',
				'S_THANKS_POST_REPUT_VIEW' 	=> (bool) $this->config['thanks_post_reput_view'],
				'S_THANKS_REPUT_GRAPHIC' 	=> (bool) $this->config['thanks_reput_graphic'],
				'THANKS_REPUT_HEIGHT'		=> $this->config['thanks_reput_height'] ?: false,
				'THANKS_REPUT_GRAPHIC_WIDTH'=> ($this->config['thanks_reput_level'] && $this->config['thanks_reput_height']) ? (int) $this->config['thanks_reput_level'] * (int) $this->config['thanks_reput_height'] : false,
				'THANKS_REPUT_IMAGE' 		=> $this->config['thanks_reput_image'] ? generate_board_url() . '/' . $this->config['thanks_reput_image'] : '',
				'THANKS_REPUT_IMAGE_BACK'	=> $this->config['thanks_reput_image_back'] ? generate_board_url() . '/' . $this->config['thanks_reput_image_back'] : '',
				'S_GLOBAL_POST_THANKS'		=> ($topic_data['topic_type'] == POST_GLOBAL) ? (bool) !$this->config['thanks_global_post'] : false,
				'U_CLEAR_LIST_THANKS_POST'	=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $row['post_id'] . '&amp;list_thanks=post'),
				'S_MOD_THANKS'				=> $this->auth->acl_get('m_thanks'),
				'S_ONLY_TOPICSTART'         => $topic_data['topic_first_post_id'] == $row['post_id'],
				'THANKS_COUNT'				=> $thanks_count,
			]);
		}
	}

	// Refresh counts if post delete
	public function delete_post_thanks($post_ids)
	{
		$sql = 'DELETE FROM ' . $this->thanks_table . '
				WHERE ' . $this->db->sql_in_set('post_id', $post_ids);
		$this->db->sql_query($sql);
	}

	// Create an array of all thanks info
	public function array_all_thanks($post_list, $forum_id)
	{
		$poster_list = [];

		// Max post thanks
		if ($this->config['thanks_post_reput_view'])
		{
			$sql = 'SELECT MAX(tally) AS max_post_thanks
				FROM (SELECT post_id, COUNT(*) AS tally FROM ' . $this->thanks_table . ' GROUP BY post_id) t';
			$result = $this->db->sql_query($sql);
			$this->max_post_thanks = (int) $this->db->sql_fetchfield('max_post_thanks');
			$this->db->sql_freeresult($result);
		}
		else
		{
			$this->max_post_thanks = 1;
		}

		// Array all user who say thanks on viewtopic page
		if ($this->auth->acl_get('f_thanks', $forum_id))
		{
			$sql_array = [
				'SELECT'	=> 't.*, u.username, u.username_clean, u.user_colour',
				'FROM'		=> [$this->thanks_table => 't', $this->users_table => 'u'],
				'WHERE'		=> 'u.user_id = t.user_id AND ' . $this->db->sql_in_set('t.post_id', $post_list),
				'ORDER_BY'	=> 't.thanks_time ASC',
			];
			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->thankers[] = [
					'user_id' 			=> $row['user_id'],
					'poster_id' 		=> $row['poster_id'],
					'post_id' 			=> $row['post_id'],
					'thanks_time'		=> $row['thanks_time'],
					'username'			=> $row['username'],
					'username_clean'	=> $row['username_clean'],
					'user_colour'		=> $row['user_colour'],
				];
			}
			$this->db->sql_freeresult($result);
		}

		// Array thanks_count for all poster on viewtopic page
		if ($this->config['thanks_counters_view'])
		{
			$sql = 'SELECT DISTINCT poster_id FROM '. $this->posts_table . ' WHERE ' . $this->db->sql_in_set('post_id', $post_list);
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$poster_list[] = $row['poster_id'];
				$this->poster_list_count[$row['poster_id']]['R'] = $this->poster_list_count[$row['poster_id']]['G'] = 0;
			}
			$this->db->sql_freeresult($result);

			$ex_fid_ary = array_keys($this->auth->acl_getf('!f_read', true));
			$ex_fid_ary = (count($ex_fid_ary)) ? $ex_fid_ary : false;

			$sql = 'SELECT poster_id, COUNT(poster_id) AS poster_count FROM ' . $this->thanks_table . '
				WHERE ' . $this->db->sql_in_set('poster_id', $poster_list) . '
					AND ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . '
				GROUP BY poster_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->poster_list_count[$row['poster_id']]['R'] = $row['poster_count'];
			}
			$this->db->sql_freeresult($result);

			$sql = 'SELECT user_id, COUNT(user_id) AS user_count FROM ' . $this->thanks_table . '
				WHERE ' . $this->db->sql_in_set('user_id', $poster_list) . '
					AND ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . '
				GROUP BY user_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->poster_list_count[$row['user_id']]['G'] = $row['user_count'];
			}
			$this->db->sql_freeresult($result);
		}
	}

	public function get_thanks_topic_reput($topic_id, $max_topic_thanks, $topic_thanks)
	{
		return [
			'TOPIC_REPUT'				=> (isset($topic_thanks[$topic_id])) ? round((int) $topic_thanks[$topic_id] / ($max_topic_thanks / 100), (int) $this->config['thanks_number_digits']) . '%' : '',
			'S_THANKS_TOPIC_REPUT_VIEW' => (bool) $this->config['thanks_topic_reput_view'],
			'S_THANKS_REPUT_GRAPHIC' 	=> (bool) $this->config['thanks_reput_graphic'],
			'THANKS_REPUT_HEIGHT'		=> $this->config['thanks_reput_height'] ?: false,
			'THANKS_REPUT_GRAPHIC_WIDTH'=> ($this->config['thanks_reput_level'] && $this->config['thanks_reput_height']) ? (int) $this->config['thanks_reput_level'] * (int) $this->config['thanks_reput_height'] : false,
			'THANKS_REPUT_IMAGE' 		=> $this->config['thanks_reput_image'] ? generate_board_url() . '/' . $this->config['thanks_reput_image'] : '',
			'THANKS_REPUT_IMAGE_BACK'	=> $this->config['thanks_reput_image_back'] ? generate_board_url() . '/' . $this->config['thanks_reput_image_back'] : '',
		];
	}

	public function get_thanks_topic_number($topic_list)
	{
		$topic_thanks = [];
		if ($this->config['thanks_topic_reput_view'])
		{
			$sql = 'SELECT topic_id, COUNT(*) AS topic_thanks
				FROM ' . $this->thanks_table . "
				WHERE " . $this->db->sql_in_set('topic_id', $topic_list) . '
				GROUP BY topic_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$topic_thanks[$row['topic_id']] = $row['topic_thanks'];
			}
			$this->db->sql_freeresult($result);
		}
		return $topic_thanks;
	}

	// Max topic thanks
	public function get_max_topic_thanks()
	{
		if ($this->config['thanks_topic_reput_view'])
		{
			$sql = 'SELECT MAX(tally) AS max_topic_thanks
				FROM (SELECT topic_id, COUNT(*) AS tally FROM ' . $this->thanks_table . ' GROUP BY topic_id) t';
			$result = $this->db->sql_query($sql);
			$this->max_topic_thanks = (int) $this->db->sql_fetchfield('max_topic_thanks');
			$this->db->sql_freeresult($result);
		}
		return $this->max_topic_thanks;
	}

	// Max post thanks for toplist
	public function get_max_post_thanks()
	{
		$sql = 'SELECT MAX(tally) AS max_post_thanks
			FROM (SELECT post_id, COUNT(*) AS tally FROM ' . $this->thanks_table . ' GROUP BY post_id) t';
		$result = $this->db->sql_query($sql);
		$this->max_post_thanks = (int) $this->db->sql_fetchfield('max_post_thanks');
		$this->db->sql_freeresult($result);
		return $this->max_post_thanks;
	}

	// Generate thankslist if required
	public function get_toplist_index($ex_fid_ary)
	{
		$sql_ary = [
			'SELECT' =>  't.poster_id, COUNT(t.user_id) AS tally, u.user_id, u.username, u.user_colour',
			'FROM' => [$this->users_table => 'u'],
			'LEFT_JOIN' => [
				[
					'FROM' => [$this->thanks_table => 't'],
					'ON' => 'u.user_id = t.poster_id',
				],
			],
			'WHERE' => $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0',
			'GROUP_BY' => 't.poster_id, u.user_id',
			'ORDER_BY' => 'tally DESC',
		];

		$cache_ttl = 86400; // Cache thanks toplist on index for 24 hours
		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_ary), (int) $this->config['thanks_top_number'], 0, $cache_ttl);

		$thanks_list = '';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$thanks_list .= (($thanks_list != '') ? ', ' : '') . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) . ' (' . $row['tally'] . ')';
		}
		$this->db->sql_freeresult($result);

		return $thanks_list;
	}

	public function get_thanks_forum_reput($forum_id)
	{
		return [
			'FORUM_REPUT'				=> (isset($this->forum_thanks[$forum_id])) ? round($this->forum_thanks[$forum_id] / ($this->max_forum_thanks / 100), (int) $this->config['thanks_number_digits']) . '%' : '',
			'S_THANKS_FORUM_REPUT_VIEW'	=> (bool) $this->config['thanks_forum_reput_view'],
			'S_THANKS_REPUT_GRAPHIC'	=> (bool) $this->config['thanks_reput_graphic'],
			'THANKS_REPUT_HEIGHT'		=> $this->config['thanks_reput_height'] ? $this->config['thanks_reput_height'] : false,
			'THANKS_REPUT_GRAPHIC_WIDTH'=> ($this->config['thanks_reput_level'] && $this->config['thanks_reput_height']) ? (int) $this->config['thanks_reput_level'] * (int) $this->config['thanks_reput_height'] : false,
			'THANKS_REPUT_IMAGE'		=> $this->config['thanks_reput_image'] ? generate_board_url() . '/' . $this->config['thanks_reput_image'] : '',
			'THANKS_REPUT_IMAGE_BACK'	=> $this->config['thanks_reput_image_back'] ? generate_board_url() . '/' . $this->config['thanks_reput_image_back'] : '',
		];
	}

	public function get_thanks_forum_number()
	{
		if ($this->config['thanks_forum_reput_view'])
		{
			if ($forum_thanks_rating = $this->cache->get('_forum_thanks_rating'))
			{
				$sql = 'SELECT forum_id, COUNT(*) AS forum_thanks
					FROM ' . $this->thanks_table . "
					WHERE " . $this->db->sql_in_set('forum_id', $forum_thanks_rating) . '
					GROUP BY forum_id';
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->forum_thanks[$row['forum_id']] = $row['forum_thanks'];
				}
				$this->db->sql_freeresult($result);
			}
		}
		return $this->forum_thanks;
	}

	public function get_max_forum_thanks()
	{
		if ($this->config['thanks_forum_reput_view'])
		{
			$sql = 'SELECT MAX(tally) AS max_forum_thanks
				FROM (SELECT forum_id, COUNT(*) AS tally FROM ' . $this->thanks_table . ' GROUP BY forum_id) t 
				WHERE forum_id <> 0';
			$result = $this->db->sql_query($sql);
			$this->max_forum_thanks = (int) $this->db->sql_fetchfield('max_forum_thanks');
			$this->db->sql_freeresult($result);
		}
		return $this->max_forum_thanks;
	}

	public function add_notification($notification_data, $notification_type_name = 'gfksx.thanksforposts.notification.type.thanks')
	{
		$topic_data = $this->topic_data;
		$mode = '';

		/**
		 * Modify notification data
		 *
		 * @event gfksx.thanksforposts.modify_thanks_notification_data
		 * @var	string		notification_type_name		The notification name
		 * @var	array		notification_data			The notification data to be inserted in to the database
		 * @var	array		topic_data					Array with topic data
		 * @var	string		mode						Thanking mode 'give|receive|post'
		 * @since 2.0.3
		 */
		$vars = ['notification_type_name', 'notification_data', 'topic_data', 'mode'];
		extract($this->phpbb_dispatcher->trigger_event('gfksx.thanksforposts.modify_thanks_notification_data', compact($vars)));

		if ($this->notification_exists($notification_data, $notification_type_name))
		{
			$this->notification_manager->update_notifications($notification_type_name, $notification_data);
		}
		else
		{
			$this->notification_manager->add_notifications($notification_type_name, $notification_data);
		}
	}

	public function notification_exists($thanks_data, $notification_type_name)
	{
		$notification_type_id = $this->notification_manager->get_notification_type_id($notification_type_name);
		$sql = 'SELECT notification_id FROM ' . $this->notifications_table . '
			WHERE notification_type_id = ' . (int) $notification_type_id . '
				AND item_id = ' . (int) $thanks_data['post_id'];
		$result = $this->db->sql_query($sql);
		$item_id = $this->db->sql_fetchfield('notification_id');
		$this->db->sql_freeresult($result);

		return ($item_id) ?: false;
	}

	public function notification_markread($item_ids)
	{
		// Mark post notifications read for this user in this topic
		$this->notification_manager->mark_notifications_read(array(
			'gfksx.thanksforposts.notification.type.thanks',
			'gfksx.thanksforposts.notification.type.thanks_remove',
		), $item_ids, $this->user->data['user_id']);
	}

	public function get_post_info($post_id = false)
	{
		if (!$post_id)
		{
			return [];
		}

		$sql_array = [
			'SELECT'	=> 'p.post_id, p.poster_id, p.topic_id, p.forum_id, p.post_subject',
			'FROM'		=> [$this->posts_table => 'p'],
			'WHERE'		=> 'p.post_id =' . (int) $post_id
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return ($row) ?: [];
	}
}
