<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\ThanksForPosts\core;

class helper
{
	/** @var array thankers */
	protected $thankers = array();

	/** @var array forum_thanks */
	protected $forum_thanks = array();

	/** @var int max_post_thanks */
	protected $max_post_thanks;

	/** @var int max_topic_thanks */
	protected $max_topic_thanks;

	/** @var int max_forum_thanks */
	protected $max_forum_thanks;

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

	/** @var phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\event\dispatcher_interface */
	protected $phpbb_dispatcher;

	/** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string table_prefix */
	protected $table_prefix;

	/** @var string THANKS_TABLE */
	protected $thanks_table;

	/** @var string USERS_TABLE */
	protected $users_table;

	/** @var string POSTS_TABLE */
	protected $posts_table;

	/** @var string NOTIFICATIONS_TABLE */
	protected $notifications_table;

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
	* @param string                               $phpbb_root_path       phpbb_root_path
	* @param string                               $php_ext               phpEx
	* @param string                               $table_prefix          Tables prefix
	* @param string                               $thanks_table          THANKS_TABLE
	* @param string                               $users_table           USERS_TABLE
	* @param string                               $posts_table           POSTS_TABLE
	* @param string                               $notifications_table   NOTIFICATIONS_TABLE
	* @return gfksx\ThanksForPosts\controller\thankslist
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\cache\driver\driver_interface $cache, \phpbb\request\request_interface $request, \phpbb\notification\manager $notification_manager, \phpbb\controller\helper $controller_helper, \phpbb\event\dispatcher_interface $phpbb_dispatcher, $phpbb_root_path, $php_ext, $table_prefix, $thanks_table, $users_table, $posts_table, $notifications_table)
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
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->table_prefix = $table_prefix;
		$this->thanks_table = $thanks_table;
		$this->users_table = $users_table;
		$this->posts_table = $posts_table;
		$this->notifications_table = $notifications_table;
	}

	// Output thanks list
	public function get_thanks($post_id)
	{
		$view = $this->request->variable('view', '');
		$further_thanks_text = $return = '';
		$user_list = array();
		$further_thanks = $count = 0;
		$maxcount = (isset($this->config['thanks_number_post']) ? $this->config['thanks_number_post'] : false);

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
					$user_list[] = get_username_string('full', $thanker['user_id'], $thanker['username'], $thanker['user_colour']) .
						(($this->config['thanks_time_view'] && $thanker['thanks_time']) ? ' (' . $this->user->format_date($thanker['thanks_time'], false, ($view == 'print') ? true : false) . ')' : '');
					$count++;
				}
			}
		}

		if (!empty($user_list))
		{
			$return = implode($user_list, ' &bull; ');
		}

		if ($further_thanks > 0)
		{
			$further_thanks_text = ($further_thanks == 1) ? $this->user->lang['FURTHER_THANKS'] : sprintf($this->user->lang['FURTHER_THANKS_PL'], $further_thanks);
		}
		$return = ($return == '') ? false : ($return . $further_thanks_text);
		return $return;
	}

	//get thanks number
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

	// add a user to the thanks list
	public function insert_thanks($post_id, $user_id, $forum_id)
	{
		// $this->user->add_lang_ext('gfksx/ThanksForPosts', 'thanks_mod');
		$to_id = $this->request->variable('to_id', 0);
		$from_id = $this->request->variable('from_id', 0);
		$row = $this->get_post_info($post_id);
		if ($this->user->data['user_type'] != USER_IGNORE && !empty($to_id))
		{
			if ($row['poster_id'] != $user_id && $row['poster_id'] == $to_id && !$this->already_thanked($post_id, $user_id) && ($this->auth->acl_get('f_thanks', $row['forum_id']) || (!$row['forum_id'] && (isset($this->config['thanks_global_post']) ? $this->config['thanks_global_post'] : false))) && $from_id == $user_id)
			{
				$thanks_data = array(
					'user_id'	=> (int) $this->user->data['user_id'],
					'post_id'	=> $post_id,
					'poster_id'	=> $to_id,
					'topic_id'	=> (int) $row['topic_id'],
					'forum_id'	=> (int) $row['forum_id'],
					'thanks_time'	=> time(),
				);
				$sql = 'INSERT INTO ' . $this->thanks_table . ' ' . $this->db->sql_build_array('INSERT', $thanks_data);
				$this->db->sql_query($sql);

				$lang_act = 'GIVE';
				$thanks_data = array_merge($thanks_data, array(
					'username'	=> $this->user->data['username'],
					'lang_act'	=> $lang_act,
					'post_subject'	=> $row['post_subject'],
				));

				$this->add_notification($thanks_data);

				if (isset($this->config['thanks_info_page']) && $this->config['thanks_info_page'])
				{
					meta_refresh (1, append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id .'&amp;p=' . $post_id . '#p' . $post_id));
					trigger_error($this->user->lang['THANKS_INFO_'.$lang_act] . '<br /><br />' . $this->user->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id .'&amp;p=' . $post_id . '#p' . $post_id) . '">', '</a>'));
				}
				else
				{
					redirect (append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $post_id . '#p' . $post_id));
				}
			}
			else if (!$row['forum_id'] && (isset($this->config['thanks_global_post']) ? !$this->config['thanks_global_post'] : true))
			{
				trigger_error($this->user->lang['GLOBAL_INCORRECT_THANKS'] . '<br /><br />' . $this->user->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $post_id . '#p' . $post_id) . '">', '</a>'));
			}
			else
			{
				trigger_error($this->user->lang['INCORRECT_THANKS'] . '<br /><br />' . $this->user->lang('RETURN_POST', '<a href="'.append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $post_id . '#p' . $post_id) . '">', '</a>'));
			}
		}
		return;
	}

	// clear list user's thanks
	public function clear_list_thanks($object_id, $list_thanks = '')
	{
		// $this->user->add_lang_ext('gfksx/ThanksForPosts', 'thanks_mod');

		// confirm
		$s_hidden_fields = build_hidden_fields(array(
			'list_thanks'		=> $list_thanks,
			)
		);
		$lang_act = $field_act = '';
		if (confirm_box(true))
		{
			if (!empty($list_thanks) && $this->auth->acl_get('m_thanks'))
			{
				if ($list_thanks === 'give')
				{
					$lang_act = 'GIVE';
					$field_act = 'user_id';
				}
				else if ($list_thanks === 'receive')
				{
					$lang_act = 'RECEIVE';
					$field_act = 'poster_id';
				}
				else if ($list_thanks === 'post')
				{
					$lang_act = 'POST';
					$field_act = 'post_id';
				}

				if (!empty($field_act))
				{
					$sql = "DELETE FROM " . $this->thanks_table . '
						WHERE ' . $field_act . ' = ' . (int) $object_id;
					$result = $this->db->sql_query($sql);

					if ($result != 0)
					{
						if (isset($this->config['thanks_info_page']) ? $this->config['thanks_info_page'] : false)
						{
							if ($list_thanks === 'post')
							{
								meta_refresh (1, append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $object_id . '#p' . $object_id));
								trigger_error($this->user->lang['CLEAR_LIST_THANKS_' . $lang_act] . '<br /><br />' . $this->user->lang('BACK_TO_PREV', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $object_id . '#p' . $object_id) . '">', '</a>'));
							}
							else
							{
								meta_refresh (1, append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $object_id));
								trigger_error($this->user->lang['CLEAR_LIST_THANKS_'.$lang_act] . '<br /><br />' . $this->user->lang('BACK_TO_PREV', '<a href="' . append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext",'mode=viewprofile&amp;u=' . $object_id) . '">', '</a>'));
							}
						}
						else
						{
							if ($list_thanks === 'post')
							{
								redirect (append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $object_id . '#p' . $object_id));
							}
							else
							{
								redirect (append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $object_id));
							}
						}
					}
				}
			}
			else
			{
				if ($list_thanks === 'post')
				{
					trigger_error($this->user->lang['INCORRECT_THANKS'] . '<br /><br />' . $this->user->lang('BACK_TO_PREV', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $object_id . '#p' . $object_id) . '">', '</a>'));
				}
				else
				{
					trigger_error($this->user->lang['INCORRECT_THANKS'] . '<br /><br />' . $this->user->lang('BACK_TO_PREV', '<a href="' . append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $object_id) . '">', '</a>'));
				}
			}
		}
		else
		{
			confirm_box(false, 'CLEAR_LIST_THANKS', $s_hidden_fields);
			if ($list_thanks === 'post')
			{
				redirect (append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $object_id . '#p' . $object_id));
			}
			else
			{
				redirect(append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $object_id));
			}
		}
		return;
	}

	// remove a user's thanks
	public function delete_thanks($post_id, $forum_id)
	{
		// $this->user->add_lang_ext('gfksx/ThanksForPosts', 'thanks_mod');
		$to_id = $this->request->variable('to_id', 0);
		$forum_id = ($forum_id) ?: $this->request->variable('f', 0);
		$row = $this->get_post_info($post_id);
		// confirm
		$hidden = build_hidden_fields(array(
			'to_id'		=> $to_id,
			'rthanks'	=> $post_id,
			)
		);

		/**
		* This event allows to interrupt before a thanks is deleted
		*
		* @event gfksx.thanksforposts.delete_thanks_before
		* @var	int		post_id		The post id
		* @var	int		forum_id	The forum id
		* @since 2.0.3
		*/
		$vars = array(
			'post_id',
			'forum_id',
		);
		extract($this->phpbb_dispatcher->trigger_event('gfksx.thanksforposts.delete_thanks_before', compact($vars)));

		if (isset($this->config['remove_thanks']) ? !$this->config['remove_thanks'] : true)
		{
			trigger_error($this->user->lang['DISABLE_REMOVE_THANKS'] . '<br /><br />' . $this->user->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id") . '">', '</a>'));
		}

		if (confirm_box(true, 'REMOVE_THANKS', $hidden))
		{
			if ($this->user->data['user_type'] != USER_IGNORE && !empty($to_id) && $this->auth->acl_get('f_thanks', $forum_id))
			{
				$sql = "DELETE FROM " . $this->thanks_table . '
					WHERE post_id ='. (int) $post_id ." AND user_id = " . (int) $this->user->data['user_id'];
				$this->db->sql_query($sql);
				$result = $this->db->sql_affectedrows($sql);
				if ($result != 0)
				{
					$lang_act = 'REMOVE';
					$thanks_data = array(
						'user_id'	=> (int) $this->user->data['user_id'],
						'post_id'	=> $post_id,
						'poster_id'	=> $to_id,
						'topic_id'	=> (int) $row['topic_id'],
						'forum_id'	=> $forum_id,
						'thanks_time'	=> time(),
						'username'	=> $this->user->data['username'],
						'lang_act'	=> $lang_act,
						'post_subject'	=> $row['post_subject'],
					);
					$this->add_notification($thanks_data, 'gfksx.thanksforposts.notification.type.thanks_remove');

					if (isset($this->config['thanks_info_page']) && $this->config['thanks_info_page'])
					{
						meta_refresh (1, append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id"));
						trigger_error($this->user->lang['THANKS_INFO_' . $lang_act] . '<br /><br />' . $this->user->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id") . '">', '</a>'));
					}
					else
					{
						redirect (append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id"));
					}
				}
				else
				{
					trigger_error($this->user->lang['INCORRECT_THANKS'] . '<br /><br />' . $this->user->lang('RETURN_POST', '<a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id") . '">', '</a>'));
				}
			}
		}
		else
		{
			confirm_box(false, 'REMOVE_THANKS', $hidden);
			redirect(append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "f=$forum_id&amp;p=$post_id#p$post_id"));
		}
		return;
	}

	// display the text/image saying either to add or remove thanks
	public function get_thanks_text($post_id)
	{
		// $this->user->add_lang_ext('gfksx/ThanksForPosts', 'thanks_mod');
		if ($this->already_thanked($post_id, $this->user->data['user_id']))
		{
			return array(
				'THANK_ALT'		=> $this->user->lang['REMOVE_THANKS'],
				'THANK_ALT_SHORT'	=> $this->user->lang['REMOVE_THANKS_SHORT'],
				'THANKS_IMG'	=> 'removethanks-icon',
			);
		}
		return array(
			'THANK_ALT'		=> $this->user->lang['THANK_POST'],
			'THANK_ALT_SHORT'	=> $this->user->lang['THANK_POST_SHORT'],
			'THANKS_IMG'	=> 'thanks-icon',
		);
	}

	// change the variable sent via the link to avoid odd errors
	public function get_thanks_link($post_id)
	{
		if ($this->already_thanked($post_id, $this->user->data['user_id']))
		{
			return 'rthanks';
		}
		return 'thanks';
	}

	// check if the user has already thanked that post
	public function already_thanked($post_id, $user_id)
	{
		$thanked = false;
		foreach ($this->thankers as $thanker)
		{
			if ($thanker['post_id'] == $post_id && $thanker['user_id'] == $user_id)
			{
				$thanked = true;
			}
		}
		return $thanked;
	}

	// stuff goes here to avoid over-editing memberlist.php
	public function output_thanks_memberlist($user_id, $ex_fid_ary)
	{
		$thankers_member = array();
		$thankered_member = array();
		$thanks = '';
		$thanked = '';
		$poster_receive_count = 0;
		$poster_give_count = 0;
		$poster_limit = isset($this->config['thanks_number']) ? $this->config['thanks_number'] : false;

		// $this->user->add_lang_ext('gfksx/ThanksForPosts', 'thanks_mod');

		$sql = 'SELECT poster_id, COUNT(*) AS poster_receive_count
			FROM ' . $this->thanks_table . '
			WHERE poster_id = ' . (int) $user_id. ' AND (' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0)
			GROUP BY poster_id';
		$result = $this->db->sql_query($sql);
		$poster_receive_count = (int) $this->db->sql_fetchfield('poster_receive_count');
		$this->db->sql_freeresult($result);

		$sql_array = array(
			'SELECT'	=> 't.*, u.username, u.user_colour',
			'FROM'		=> array($this->thanks_table => 't', $this->users_table => 'u'),
		);
		$sql_array['WHERE'] = 't.poster_id =' . (int) $user_id .' AND ';
		$sql_array['WHERE'] .= 'u.user_id = t.user_id AND ';
		$sql_array['WHERE'] .= '('. $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0)';
		$sql_array['ORDER_BY'] = 't.post_id DESC LIMIT ' . (int) $poster_limit;
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$thankers_member[] = array(
				'user_id' 		=> $row['user_id'],
				'poster_id' 	=> $row['poster_id'],
				'post_id' 		=> $row['post_id'],
				'username'		=> $row['username'],
				'user_colour'	=> $row['user_colour'],
			);

		}
		$this->db->sql_freeresult($result);
		$user_list = array();
		$post_list = array ();
		$i=0;
		foreach ($thankers_member as $key => $value)
		{
			if ($thankers_member[$key]['poster_id'] == $user_id)
			{
				$i++;
				$user_list[$i] = array(
					'username' 		=> $thankers_member[$key]['username'],
					'user_id' 		=> $thankers_member[$key]['user_id'],
					'user_colour' 	=> $thankers_member[$key]['user_colour'],
					'post_id' 		=> $thankers_member[$key]['post_id'],
				);
			}
		}
		unset ($value);
		$collim = ($poster_limit > $poster_receive_count)? ceil($poster_receive_count/4) : ceil($poster_limit/4);
		$thanked .= '<span style="float: left;">';
		$i = $j = 0;
		foreach ($user_list as $value)
		{
			$i++;
			if ($i <= $poster_limit)
			{
				$thanked .= '&nbsp;&nbsp;&bull;&nbsp;&nbsp;' . get_username_string('full', $value['user_id'], $value['username'], $value['user_colour']) . ' &#8594; <a href="' . append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $value['post_id']. '#p' . $value['post_id']) . '">' . $this->user->lang['FOR_MESSAGE'] . '</a><br />';
				$j++;
				if ($j > $collim or $i == $poster_receive_count or $i == $poster_limit)
				{
					$thanked .= '&nbsp;</span>';
					$j = 0;
					if ($i < $poster_limit and $i < $poster_receive_count)
					{
						$thanked .= '<span style="float: left;">';
					}
				}
			}
		}
		if ($poster_receive_count > $poster_limit)
		{
			$further_thanks = $poster_receive_count - $poster_limit;
			$further_thanks_text = ($further_thanks == 1) ? $this->user->lang['FURTHER_THANKS'] : sprintf($this->user->lang['FURTHER_THANKS_PL'], $further_thanks);
			$thanked .= '<span style="float: left;">&nbsp;' . $further_thanks_text . '</span>';
		}
		unset ($value);
	//===
		$sql = 'SELECT user_id, COUNT(*) AS poster_give_count
			FROM ' . $this->thanks_table . "
			WHERE user_id = " . (int) $user_id.  ' AND (' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0)
			GROUP BY user_id';
		$result = $this->db->sql_query($sql);
		$poster_give_count = (int) $this->db->sql_fetchfield('poster_give_count');
		$this->db->sql_freeresult($result);

		$sql_array = array(
			'SELECT'	=> 't.*, u.username, u.user_colour',
			'FROM'		=> array($this->thanks_table => 't', $this->users_table => 'u'),
		);
		$sql_array['WHERE'] = 't.user_id =' . (int) $user_id . ' AND ';
		$sql_array['WHERE'] .= 'u.user_id = t.poster_id AND ';
		$sql_array['WHERE'] .= '(' . $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0)';
		$sql_array['ORDER_BY'] = 't.post_id DESC LIMIT ' . (int) $poster_limit;
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$thankered_member[] = array(
				'user_id' 		=> $row['user_id'],
				'poster_id' 	=> $row['poster_id'],
				'post_id' 		=> $row['post_id'],
				'username'		=> $row['username'],
				'user_colour'	=> $row['user_colour'],
			);
		}
		$this->db->sql_freeresult($result);

		$i=0;
		foreach ($thankered_member as $key => $value)
		{
			if ($thankered_member[$key]['user_id'] == $user_id)
			{
				$i++;
				$post_list[$i] = array(
					'postername' 		=> $thankered_member[$key]['username'],
					'poster_id' 		=> $thankered_member[$key]['poster_id'],
					'poster_colour' 	=> $thankered_member[$key]['user_colour'],
					'post_id' 			=> $thankered_member[$key]['post_id'],
				);
			}
		}
		unset ($value);
		$collim = ($poster_limit > $poster_give_count)? ceil($poster_give_count/4) : ceil($poster_limit/4);
		$thanks .= '<span style="float: left;">';
		$i = $j = 0;
		foreach ($post_list as $value)
		{
			$i++;
			if ($i <= $poster_limit)
			{
				$thanks .= '&nbsp;&nbsp;&bull;&nbsp;&nbsp;'. get_username_string('full', $value['poster_id'], $value['postername'], $value['poster_colour']) . ' &#8592; <a href="'. append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $value['post_id']. '#p' . $value['post_id']) . '">' . $this->user->lang['FOR_MESSAGE'] . '</a><br />';
				$j++;
				if ($j > $collim or $i == $poster_give_count or $i == $poster_limit)
				{
					$thanks .= '</span>';
					$j = 0;
					if ($i < $poster_limit and $i < $poster_give_count)
					{
						$thanks .= '<span style="float: left;">';
					}
				}
			}
		}
		if ($poster_give_count > $poster_limit)
		{
			$further_thanks = $poster_give_count - $poster_limit;
			$further_thanks_text = ($further_thanks == 1) ? $this->user->lang['FURTHER_THANKS'] : sprintf($this->user->lang['FURTHER_THANKS_PL'], $further_thanks);
			$thanks .= '<span style="float: left;">&nbsp;' . $further_thanks_text . '</span>';
		}
		unset ($value);

		$l_poster_receive_count = ($poster_receive_count) ? $this->user->lang('THANKS', $poster_receive_count) : '';
		$l_poster_give_count = ($poster_give_count) ? $this->user->lang('THANKS', $poster_give_count) : '';
		$this->template->assign_vars(array(
			'DELETE_IMG' 					=> $this->user->img('icon_post_delete', $this->user->lang['CLEAR_LIST_THANKS']),
			'POSTER_RECEIVE_COUNT'			=> $l_poster_receive_count,
			'THANKS'						=> $thanks,
			'POSTER_GIVE_COUNT'				=> $l_poster_give_count,
			'THANKED'						=> $thanked,
			'THANKS_PROFILELIST_VIEW'		=> isset($this->config['thanks_profilelist_view']) ? $this->config['thanks_profilelist_view'] : false,
			'S_MOD_THANKS'					=> $this->auth->acl_get('m_thanks'),
			'U_CLEAR_LIST_THANKS_GIVE'		=> append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $user_id . '&amp;list_thanks=give'),
			'U_CLEAR_LIST_THANKS_RECEIVE'	=> append_sid("{$this->phpbb_root_path}memberlist.$this->php_ext", 'mode=viewprofile&amp;u=' . $user_id . '&amp;list_thanks=receive'),
		));
	}

	// stuff goes here to avoid over-editing viewtopic.php
	public function output_thanks($poster_id, &$postrow, $row, $topic_data, $forum_id)
	{
		if (!empty($postrow))
		{
			$thanks_text = $this->get_thanks_text($row['post_id']);
			$thank_mode = $this->get_thanks_link($row['post_id']);
			$already_thanked = $this->already_thanked($row['post_id'], $this->user->data['user_id']);
			$l_poster_receive_count = (isset($this->poster_list_count[$poster_id]['R']) && $this->poster_list_count[$poster_id]['R']) ? $this->user->lang('THANKS', (int) $this->poster_list_count[$poster_id]['R']) : '';
			$l_poster_give_count = (isset($this->poster_list_count[$poster_id]['G']) && $this->poster_list_count[$poster_id]['G']) ? $this->user->lang('THANKS', (int) $this->poster_list_count[$poster_id]['G']) : '';

			// Correctly form URLs
			$u_receive_count_url = $this->controller_helper->route('gfksx_ThanksForPosts_thankslist_controller_user', array('mode' => 'givens', 'author_id' => $poster_id, 'give' => 'false', 'tslash' => ''));
			$u_give_count_url = $this->controller_helper->route('gfksx_ThanksForPosts_thankslist_controller_user', array('mode' => 'givens', 'author_id' => $poster_id, 'give' => 'true', 'tslash' => ''));

			$postrow = array_merge($postrow, $thanks_text, array(
				'COND'						=> ($already_thanked) ? true : false,
				'THANKS'					=> $this->get_thanks($row['post_id']),
				'THANK_MODE'				=> $thank_mode,
				'THANKS_LINK'				=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $row['post_id'] . '&amp;' . $thank_mode . '=' . $row['post_id'] . '&amp;to_id=' . $poster_id . '&amp;from_id=' . $this->user->data['user_id']),
				'THANK_TEXT'				=> $this->user->lang['THANK_TEXT_1'],
				'THANK_TEXT_2'				=> ($this->get_thanks_number($row['post_id']) != 1) ? sprintf($this->user->lang['THANK_TEXT_2PL'], $this->get_thanks_number($row['post_id'])) : $this->user->lang['THANK_TEXT_2'],
				'THANKS_FROM'				=> $this->user->lang['THANK_FROM'],
				'POSTER_RECEIVE_COUNT'		=> $l_poster_receive_count,
				'POSTER_GIVE_COUNT'			=> $l_poster_give_count,
				'POSTER_RECEIVE_COUNT_LINK'	=> $u_receive_count_url,
				'POSTER_GIVE_COUNT_LINK'	=> $u_give_count_url,
				'S_IS_OWN_POST'				=> ($this->user->data['user_id'] == $poster_id) ? true : false,
				'S_POST_ANONYMOUS'			=> ($poster_id == ANONYMOUS) ? true : false,
				'THANK_IMG' 				=> ($already_thanked) ? $this->user->img('removethanks', $this->user->lang['REMOVE_THANKS']. get_username_string('username', $poster_id, $row['username'], $row['user_colour'], $row['post_username'])) : $this->user->img('thankposts', $this->user->lang['THANK_POST']. get_username_string('username', $poster_id, $row['username'], $row['user_colour'], $row['post_username'])),
				'DELETE_IMG' 				=> $this->user->img('icon_post_delete', $this->user->lang['CLEAR_LIST_THANKS']),
				'THANKS_POSTLIST_VIEW'		=> isset($this->config['thanks_postlist_view']) ? $this->config['thanks_postlist_view'] : false,
				'THANKS_COUNTERS_VIEW'		=> isset($this->config['thanks_counters_view']) ? $this->config['thanks_counters_view'] : false,
				'S_ALREADY_THANKED'			=> $already_thanked,
				'S_REMOVE_THANKS'			=> isset($this->config['remove_thanks']) ? $this->config['remove_thanks'] : false,
				'S_FIRST_POST_ONLY'			=> isset($this->config['thanks_only_first_post']) ? $this->config['thanks_only_first_post'] : false,
				'POST_REPUT'				=> ($this->get_thanks_number($row['post_id']) != 0) ? round($this->get_thanks_number($row['post_id']) / ($this->max_post_thanks / 100), $this->config['thanks_number_digits']) . '%' : '',
				'S_THANKS_POST_REPUT_VIEW' 	=> isset($this->config['thanks_post_reput_view']) ? (bool) $this->config['thanks_post_reput_view'] : false,
				'S_THANKS_REPUT_GRAPHIC' 	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
				'THANKS_REPUT_HEIGHT'		=> isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_height']) : false,
				'THANKS_REPUT_GRAPHIC_WIDTH'=> isset($this->config['thanks_reput_level']) ? (isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']) : false) : false,
				'THANKS_REPUT_IMAGE' 		=> isset($this->config['thanks_reput_image']) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
				'THANKS_REPUT_IMAGE_BACK'	=> isset($this->config['thanks_reput_image_back']) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',
				'S_GLOBAL_POST_THANKS'		=> ($topic_data['topic_type'] == POST_GLOBAL) ? (isset($this->config['thanks_global_post']) ? !$this->config['thanks_global_post'] : true) : false,
				'U_CLEAR_LIST_THANKS_POST'	=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $row['post_id'] . '&amp;list_thanks=post'),
				'S_MOD_THANKS'				=> $this->auth->acl_get('m_thanks'),
				'S_ONLY_TOPICSTART'         => ($topic_data['topic_first_post_id'] == $row['post_id']) ? true : false,
			));
		}
	}

	//refresh counts if post delete
	public function delete_post_thanks($post_ids)
	{
		$sql = 'DELETE FROM ' . $this->thanks_table . '
				WHERE ' . $this->db->sql_in_set('post_id', $post_ids);
		$this->db->sql_query($sql);
	}

	// create an array of all thanks info
	public function array_all_thanks($post_list, $forum_id)
	{
		$poster_list = array();

		// max post thanks
		if (isset($this->config['thanks_post_reput_view']) ? $this->config['thanks_post_reput_view'] : false)
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

		//array all user who say thanks on viewtopic page
		if ($this->auth->acl_get('f_thanks', $forum_id))
		{
			$sql_array = array(
				'SELECT'	=> 't.*, u.username, u.username_clean, u.user_colour',
				'FROM'		=> array($this->thanks_table => 't', $this->users_table => 'u'),
				'WHERE'		=> 'u.user_id = t.user_id AND ' . $this->db->sql_in_set('t.post_id', $post_list),
				'ORDER_BY'	=> 't.thanks_time ASC',
			);
			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->thankers[] = array(
					'user_id' 			=> $row['user_id'],
					'poster_id' 		=> $row['poster_id'],
					'post_id' 			=> $row['post_id'],
					'thanks_time'		=> $row['thanks_time'],
					'username'			=> $row['username'],
					'username_clean'	=> $row['username_clean'],
					'user_colour'		=> $row['user_colour'],
				);
			}
			$this->db->sql_freeresult($result);
		}

		//array thanks_count for all poster on viewtopic page
		if (isset($this->config['thanks_counters_view']) ? $this->config['thanks_counters_view'] : false)
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
			$ex_fid_ary = (sizeof($ex_fid_ary)) ? $ex_fid_ary : false;

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
		return;
	}

	// topic reput
	public function get_thanks_topic_reput($topic_id, $max_topic_thanks, $topic_thanks)
	{
		return array(
			'TOPIC_REPUT'				=> (isset($topic_thanks[$topic_id])) ? round((int) $topic_thanks[$topic_id] / ($max_topic_thanks / 100), (int) $this->config['thanks_number_digits']) . '%' : '',
			'S_THANKS_TOPIC_REPUT_VIEW' => isset($this->config['thanks_topic_reput_view']) ? (bool) $this->config['thanks_topic_reput_view'] : false,
			'S_THANKS_TOPIC_REPUT_VIEW_COLUMN' => isset($this->config['thanks_topic_reput_view_column']) ? (bool) $this->config['thanks_topic_reput_view_column'] : false,
			'S_THANKS_REPUT_GRAPHIC' 	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
			'THANKS_REPUT_HEIGHT'		=> isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_height']) : false,
			'THANKS_REPUT_GRAPHIC_WIDTH'=> isset($this->config['thanks_reput_level']) ? (isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']) : false) : false,
			'THANKS_REPUT_IMAGE' 		=> isset($this->config['thanks_reput_image']) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
			'THANKS_REPUT_IMAGE_BACK'	=> isset($this->config['thanks_reput_image_back']) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',
		);
	}

	// topic thanks number
	public function get_thanks_topic_number($topic_list)
	{
		$topic_thanks = array();
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
			return $topic_thanks;
		}
	}

	// max topic thanks
	public function get_max_topic_thanks()
	{
		if ($this->config['thanks_topic_reput_view'])
		{
			$sql = 'SELECT MAX(tally) AS max_topic_thanks
				FROM (SELECT topic_id, COUNT(*) AS tally FROM ' . $this->thanks_table . ' GROUP BY topic_id) t';
			$result = $this->db->sql_query($sql);
			$this->max_topic_thanks = (int) $this->db->sql_fetchfield('max_topic_thanks');
			$this->db->sql_freeresult($result);
			return $this->max_topic_thanks;
		}
	}

	// max post thanks for toplist
	public function get_max_post_thanks()
	{
		$sql = 'SELECT MAX(tally) AS max_post_thanks
			FROM (SELECT post_id, COUNT(*) AS tally FROM ' . $this->thanks_table . ' GROUP BY post_id) t';
		$result = $this->db->sql_query($sql);
		$this->max_post_thanks = (int) $this->db->sql_fetchfield('max_post_thanks');
		$this->db->sql_freeresult($result);
		return $this->max_post_thanks;
	}

	// Generate thankslist if required ...
	public function get_toplist_index($ex_fid_ary)
	{
		$thanks_list = '';
		$sql = 'SELECT t.poster_id, COUNT(t.user_id) AS tally, u.user_id, u.username, u.user_colour
			FROM ' . $this->users_table . ' u 
			LEFT JOIN ' . $this->thanks_table . ' t ON (u.user_id = t.poster_id)
			WHERE ' . $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0
			GROUP BY t.poster_id 
			ORDER BY tally DESC';
		$result = $this->db->sql_query_limit($sql, (int) $this->config['thanks_top_number']);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$thanks_list .= (($thanks_list != '') ? ', ' : '') . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) . ' (' . $row['tally'] . ')';
		}
		$this->db->sql_freeresult($result);
		return $thanks_list;
	}

	// forum reput
	public function get_thanks_forum_reput($forum_id)
	{
		return array(
			'FORUM_REPUT'				=> (isset($this->forum_thanks[$forum_id])) ? round($this->forum_thanks[$forum_id] / ($this->max_forum_thanks / 100), ($this->config['thanks_number_digits'])) . '%' : '',
			'S_THANKS_FORUM_REPUT_VIEW'	=> isset($this->config['thanks_forum_reput_view']) ? (bool) $this->config['thanks_forum_reput_view'] : false,
			'S_THANKS_REPUT_GRAPHIC'	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
			'S_THANKS_FORUM_REPUT_VIEW_COLUMN' => isset($this->config['thanks_forum_reput_view_column']) ? (bool) $this->config['thanks_forum_reput_view_column'] : false,
			'THANKS_REPUT_HEIGHT'		=> isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_height']) : false,
			'THANKS_REPUT_GRAPHIC_WIDTH'=> isset($this->config['thanks_reput_level']) ? (isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']) : false) : false,
			'THANKS_REPUT_IMAGE'		=> (isset($this->config['thanks_reput_image'])) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
			'THANKS_REPUT_IMAGE_BACK'	=> (isset($this->config['thanks_reput_image_back'])) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',
		);
	}

	// forum thanks number
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
			return $this->forum_thanks;
		}
	}

	// max forum thanks
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
			return $this->max_forum_thanks;
		}
	}

	// Add notifications
	public function add_notification($notification_data, $notification_type_name = 'gfksx.thanksforposts.notification.type.thanks')
	{
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
			return array();
		}
		$sql_array = array(
			'SELECT'	=> 'p.post_id, p.poster_id, p.topic_id, p.forum_id, p.post_subject',
			'FROM'		=> array ($this->posts_table => 'p'),
			'WHERE'		=> 'p.post_id =' . (int) $post_id);
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return ($row) ?: array();
	}
}
