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

namespace gfksx\thanksforposts\controller;

class toplist
{
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

	/** @var \phpbb\language\language $language */
	protected $language;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \gfksx\thanksforposts\core\helper */
	protected $gfksx_helper;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var string FORUMS_TABLE */
	protected $forums_table;

	/** @var string THANKS_TABLE */
	protected $thanks_table;

	/** @var string USERS_TABLE */
	protected $users_table;

	/** @var string POSTS_TABLE */
	protected $posts_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config					$config				Config object
	 * @param \phpbb\db\driver\driver_interface		$db					DBAL object
	 * @param \phpbb\auth\auth						$auth				Auth object
	 * @param \phpbb\template\template				$template			Template object
	 * @param \phpbb\user							$user				User object
	 * @param \phpbb\language\language				$language			Language object
	 * @param \phpbb\cache\driver\driver_interface	$cache				Cache driver object
	 * @param string								$phpbb_root_path	phpbb_root_path
	 * @param string								$php_ext			phpEx
	 * @param \phpbb\pagination						$pagination			Pagination object
	 * @param \gfksx\thanksforposts\core\helper		$gfksx_helper		Helper object
	 * @param \phpbb\request\request_interface		$request			Request object
	 * @param \phpbb\controller\helper				$controller_helper	Controller helper object
	 * @param string								$forums_table		FORUMS_TABLE
	 * @param string								$thanks_table		THANKS_TABLE
	 * @param string								$users_table		USERS_TABLE
	 * @param string								$posts_table		POSTS_TABLE
	 * @access public
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\auth\auth $auth,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\cache\driver\driver_interface $cache,
		$phpbb_root_path, $php_ext,
		\phpbb\pagination $pagination,
		\gfksx\thanksforposts\core\helper $gfksx_helper,
		\phpbb\request\request_interface $request,
		\phpbb\controller\helper $controller_helper,
		$forums_table, $thanks_table, $users_table, $posts_table
	)
	{
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->cache = $cache;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->pagination = $pagination;
		$this->gfksx_helper = $gfksx_helper;
		$this->request = $request;
		$this->controller_helper = $controller_helper;
		$this->forums_table = $forums_table;
		$this->thanks_table = $thanks_table;
		$this->users_table = $users_table;
		$this->posts_table = $posts_table;
	}

	public function main()
	{
		$this->language->add_lang(['memberlist', 'groups', 'search']);
		$this->language->add_lang('thanks_mod', 'gfksx/thanksforposts');

		// Grab data
		$mode = $this->request->variable('mode', '');
		$full_post_rating = $full_topic_rating = $full_forum_rating = false;
		$u_search_post = $u_search_topic = $u_search_forum = '';
		$topic_id = $this->request->variable('t', 0);
		$return_chars = $this->request->variable('ch', ($topic_id) ? -1 : 300);
		$words = [];
		$ex_fid_ary = array_keys($this->auth->acl_getf('!f_read', true));
		$ex_fid_ary = (count($ex_fid_ary)) ? $ex_fid_ary : true;
		$pagination_url = $this->controller_helper->route('gfksx_thanksforposts_toplist_controller', ['mode' => $mode, 'tslash' => '']);

		if (!$this->auth->acl_gets('u_viewtoplist'))
		{
			if ($this->user->data['user_id'] != ANONYMOUS)
			{
				trigger_error('RATING_NO_VIEW_TOPLIST');
			}
			login_box('', $this->language->lang('LOGIN_EXPLAIN_' . strtoupper($mode)));
		}

		$notoplist = true;
		$start	= $this->request->variable('start', 0);
		$max_post_thanks = $this->config['thanks_post_reput_view'] ? $this->gfksx_helper->get_max_post_thanks() : 1;
		$max_topic_thanks = $this->config['thanks_topic_reput_view'] ? $this->gfksx_helper->get_max_topic_thanks() : 1;
		$max_forum_thanks = $this->config['thanks_forum_reput_view'] ? $this->gfksx_helper->get_max_forum_thanks() : 1;

		switch ($mode)
		{
				case 'post':
					$sql = 'SELECT COUNT(DISTINCT post_id) as total_post_count
						FROM ' . $this->thanks_table .'
						WHERE ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true);
					$result = $this->db->sql_query($sql);
					$total_match_count = (int) $this->db->sql_fetchfield('total_post_count');
					$this->db->sql_freeresult($result);

					$full_post_rating = true;
					$notoplist = false;
				break;

				case 'topic':
					$sql = 'SELECT COUNT(DISTINCT topic_id) as total_topic_count
						FROM ' . $this->thanks_table .'
						WHERE ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true);
					$result = $this->db->sql_query($sql);
					$total_match_count = (int) $this->db->sql_fetchfield('total_topic_count');
					$this->db->sql_freeresult($result);

					$full_topic_rating = true;
					$notoplist = false;
				break;

				case 'forum':
					$sql = 'SELECT COUNT(DISTINCT forum_id) as total_forum_count
						FROM ' . $this->thanks_table .'
						WHERE ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true);
					$result = $this->db->sql_query($sql);
					$total_match_count = (int) $this->db->sql_fetchfield('total_forum_count');
					$this->db->sql_freeresult($result);

					$full_forum_rating = true;
					$notoplist = false;
				break;

				default:
				$total_match_count = 0;
				break;
		}

		$page_title = $this->language->lang('REPUT_TOPLIST', $total_match_count);

		// Post rating
		if (!$full_forum_rating && !$full_topic_rating && $this->config['thanks_post_reput_view'])
		{
			$end = ($full_post_rating) ?  $this->config['topics_per_page'] : $this->config['thanks_number_row_reput'];

			$sql_p_array = [
				'FROM'		=> [$this->thanks_table => 't'],
				'SELECT'	=> 'u.user_id, u.username, u.user_colour,
					p.post_subject, p.post_id, p.post_time, p.poster_id, p.post_username,
					p.topic_id, p.forum_id, p.post_text, p.bbcode_uid, p.bbcode_bitfield,
					p.post_attachment, t.post_id, COUNT(*) AS post_thanks',
				'LEFT_JOIN' => [
					[
						'FROM'	=> [$this->posts_table => 'p'],
						'ON'	=> 't.post_id = p.post_id',
					],
					[
						'FROM'	=> [$this->users_table => 'u'],
						'ON'	=> 'p.poster_id = u.user_id',
					],
				],
				'WHERE'		=> $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true),
				'GROUP_BY'	=> 't.post_id, u.user_id, p.post_subject, p.post_id',
				'ORDER_BY'	=> 'post_thanks DESC',
			];

			$sql = $this->db->sql_build_query('SELECT',$sql_p_array);
			$result = $this->db->sql_query_limit($sql, $end, $start);

			$u_search_post = $this->controller_helper->route('gfksx_thanksforposts_toplist_controller', ['mode' => 'post', 'tslash' => '']);

			if (!$row = $this->db->sql_fetchrow($result))
			{
				trigger_error('RATING_VIEW_TOPLIST_NO');
			}
			else
			{
				$notoplist = false;
				$bbcode_bitfield = $text_only_message = '';
				do
				{
						// We pre-process some variables here for later usage
						$row['post_text'] = censor_text($row['post_text']);
						$text_only_message = $row['post_text'];

						// Make list items visible as such
						if ($row['bbcode_uid'])
						{
							$text_only_message = str_replace('[*:' . $row['bbcode_uid'] . ']', '&sdot;&nbsp;', $text_only_message);

							// No BBCode in text only message
							strip_bbcode($text_only_message, $row['bbcode_uid']);
						}

						if ($return_chars == -1 || utf8_strlen($text_only_message) < ($return_chars + 3))
						{
							$row['display_text_only'] = false;
							$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);

							// Does this post have an attachment? If so, add it to the list
							if ($row['post_attachment'] && $this->config['allow_attachments'])
							{
								$attach_list[$row['forum_id']][] = $row['post_id'];
							}
						}
						else
						{
							$row['post_text'] = $text_only_message;
							$row['display_text_only'] = true;
						}
						$rowset[] = $row;
						unset($text_only_message);

						// Instantiate BBCode if needed
						if ($bbcode_bitfield !== '' && !class_exists('bbcode'))
						{
							include($this->phpbb_root_path . 'includes/bbcode.' . $this->php_ext);
							$bbcode = new \bbcode(base64_encode($bbcode_bitfield));
						}

						// Replace naughty words such as farty pants
						$row['post_subject'] = censor_text($row['post_subject']);

						if ($row['display_text_only'])
						{
							$row['post_text'] = get_context($row['post_text'], $words, $return_chars);
							$row['post_text'] = bbcode_nl2br($row['post_text']);
						}
						else
						{
							// Second parse bbcode here
							if ($row['bbcode_bitfield'])
							{
								$bbcode->bbcode_second_pass($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield']);
							}

							$row['post_text'] = bbcode_nl2br($row['post_text']);
							$row['post_text'] = smiley_text($row['post_text']);
						}

					$post_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'p=' . $row['post_id'] . '#p' . $row['post_id']);
					$this->template->assign_block_vars('toppostrow', [
						'MESSAGE'					=> $this->auth->acl_get('f_read', $row['forum_id']) ? $row['post_text'] : ((!empty($row['forum_id'])) ? $this->language->lang('SORRY_AUTH_READ') : ''),
						'POST_DATE'					=> !empty($row['post_time']) ? $this->user->format_date($row['post_time']) : '',
						'POST_ID'					=> $post_url,
						'POST_SUBJECT'				=> $this->auth->acl_get('f_read', $row['forum_id']) ? $row['post_subject'] : ((!empty($row['forum_id'])) ? $this->language->lang('SORRY_AUTH_READ') : ''),
						'POST_AUTHOR'				=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
						'POST_REPUT'				=> round($row['post_thanks'] / ($max_post_thanks / 100), (int) $this->config['thanks_number_digits']) . '%',
						'POST_THANKS'				=> $row['post_thanks'],
						'S_THANKS_POST_REPUT_VIEW' 	=> (bool) $this->config['thanks_post_reput_view'],
						'S_THANKS_REPUT_GRAPHIC' 	=> (bool) $this->config['thanks_reput_graphic'],
						'THANKS_REPUT_HEIGHT'		=> (int) $this->config['thanks_reput_height'],
						'THANKS_REPUT_GRAPHIC_WIDTH'=> (int) $this->config['thanks_reput_level'] * (int) $this->config['thanks_reput_height'],
						'THANKS_REPUT_IMAGE' 		=> !empty($this->config['thanks_reput_image']) ? generate_board_url() . '/' . $this->config['thanks_reput_image'] : '',
						'THANKS_REPUT_IMAGE_BACK'	=> !empty($this->config['thanks_reput_image_back']) ? generate_board_url() . '/' . $this->config['thanks_reput_image_back'] : '',
					]);
				}
				while ($row = $this->db->sql_fetchrow($result));
				$this->db->sql_freeresult($result);
			}
		}

		// Topic rating
		if (!$full_forum_rating && !$full_post_rating && $this->config['thanks_topic_reput_view'])
		{
			$end = ($full_topic_rating) ?  $this->config['topics_per_page'] : $this->config['thanks_number_row_reput'];

			$sql_t_array = [
				'FROM'		=> [$this->thanks_table => 'f'],
				'SELECT'	=> 'u.user_id, u.username, u.user_colour, t.topic_title,
					t.topic_id, t.topic_time, t.topic_poster, t.topic_first_poster_name,
					t.topic_first_poster_colour, t.forum_id, t.topic_type, t.topic_status,
					t.poll_start, f.topic_id, COUNT(*) AS topic_thanks',
				'LEFT_JOIN' => [
					[
						'FROM'	=> [TOPICS_TABLE => 't'],
						'ON'	=> 'f.topic_id = t.topic_id',
					],
					[
						'FROM'	=> [$this->users_table => 'u'],
						'ON'	=> 't.topic_poster = u.user_id',
					],
				],
				'WHERE'		=> $this->db->sql_in_set('f.forum_id', $ex_fid_ary, true),
				'GROUP_BY'	=> 'f.topic_id, u.user_id, t.topic_title, t.topic_id',
				'ORDER_BY'	=> 'topic_thanks DESC',
			];

			$sql = $this->db->sql_build_query('SELECT',$sql_t_array);
			$result = $this->db->sql_query_limit($sql, $end, $start);
			$u_search_topic = $this->controller_helper->route('gfksx_thanksforposts_toplist_controller', ['mode' => 'topic', 'tslash' => '']);

			if (!$row = $this->db->sql_fetchrow($result))
			{
				trigger_error('RATING_VIEW_TOPLIST_NO');
			}
			else
			{
				$notoplist = false;
				do
				{
					// Get folder img, topic status/type related information
					$folder_img = $folder_alt = $topic_type = '';
					if (!function_exists('topic_status'))
					{
						include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
					}

					topic_status($row, 0, false, $folder_img, $folder_alt, $topic_type);
					$view_topic_url_params = 'f=' . (($row['forum_id']) ? $row['forum_id'] : '') . '&amp;t=' . $row['topic_id'];
					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", $view_topic_url_params);

					$this->template->assign_block_vars('toptopicrow', [
						'TOPIC_IMG_STYLE'			=> $folder_img,
						'TOPIC_FOLDER_IMG_SRC'		=> $row['forum_id'] ? 'topic_read' : 'announce_read',
						'TOPIC_TITLE'				=> ($this->auth->acl_get('f_read', $row['forum_id'])) ? $row['topic_title'] : ((!empty($row['forum_id'])) ? $this->language->lang('SORRY_AUTH_READ') : ''),
						'U_VIEW_TOPIC'				=> $view_topic_url,
						'TOPIC_AUTHOR'				=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
						'TOPIC_THANKS'				=> $row['topic_thanks'],
						'TOPIC_REPUT'				=> round($row['topic_thanks'] / ($max_topic_thanks / 100), (int) $this->config['thanks_number_digits']) . '%',
						'S_THANKS_TOPIC_REPUT_VIEW' => (bool) $this->config['thanks_topic_reput_view'],
						'S_THANKS_REPUT_GRAPHIC' 	=> (bool) $this->config['thanks_reput_graphic'],
						'THANKS_REPUT_HEIGHT'		=> (int) $this->config['thanks_reput_height'],
						'THANKS_REPUT_GRAPHIC_WIDTH'=> (int) $this->config['thanks_reput_level'] * (int) $this->config['thanks_reput_height'],
						'THANKS_REPUT_IMAGE' 		=> !empty($this->config['thanks_reput_image']) ? generate_board_url() . '/' . $this->config['thanks_reput_image'] : '',
						'THANKS_REPUT_IMAGE_BACK'	=> !empty($this->config['thanks_reput_image_back']) ? generate_board_url() . '/' . $this->config['thanks_reput_image_back'] : '',
					]);
				}
				while ($row = $this->db->sql_fetchrow($result));
				$this->db->sql_freeresult($result);
			}
		}

		// Forum rating
		if (!$full_topic_rating && !$full_post_rating && $this->config['thanks_forum_reput_view'])
		{
			$end = ($full_forum_rating) ?  (int) $this->config['topics_per_page'] : (int) $this->config['thanks_number_row_reput'];

			$sql_f_array = [
				'FROM'		=> [$this->thanks_table => 't'],
				'SELECT'	=> 'f.forum_name, f.forum_id, t.forum_id, COUNT(*) AS forum_thanks',
				'LEFT_JOIN' => [
					[
						'FROM'	=> [$this->forums_table => 'f'],
						'ON'	=> 't.forum_id = f.forum_id',
					],
				],
				'WHERE'		=> $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true),
				'GROUP_BY'	=> 't.forum_id, f.forum_name, f.forum_id',
				'ORDER_BY'	=> 'forum_thanks DESC',
			];

			$sql = $this->db->sql_build_query('SELECT',$sql_f_array);
			$result = $this->db->sql_query_limit($sql, $end, $start);
			$u_search_forum = $this->controller_helper->route('gfksx_thanksforposts_toplist_controller', ['mode' => 'forum', 'tslash' => '']);

			if (!$row = $this->db->sql_fetchrow($result))
			{
				trigger_error('RATING_VIEW_TOPLIST_NO');
			}
			else
			{
				$notoplist = false;
				do
				{
					if (!empty($row['forum_id']))
					{
						$u_viewforum = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
						$folder_image = 'forum_read';
						$this->template->assign_block_vars('topforumrow', [
							'FORUM_FOLDER_IMG_SRC'		=> $this->user->img('forum_read', 'NO_NEW_POSTS', false, '', 'src'),
							'FORUM_IMG_STYLE'			=> $folder_image,
							'FORUM_NAME'				=> ($this->auth->acl_get('f_read', $row['forum_id'])) ? $row['forum_name'] : ((!empty($row['forum_id'])) ? $this->language->lang('SORRY_AUTH_READ') : ''),
							'U_VIEW_FORUM'				=> $u_viewforum,
							'FORUM_THANKS'				=> $row['forum_thanks'],
							'FORUM_REPUT'				=> round($row['forum_thanks'] / ($max_forum_thanks / 100), (int) $this->config['thanks_number_digits']) . '%',
							'S_THANKS_FORUM_REPUT_VIEW' => (bool) $this->config['thanks_forum_reput_view'],
							'S_THANKS_REPUT_GRAPHIC' 	=> (bool) $this->config['thanks_reput_graphic'],
							'THANKS_REPUT_HEIGHT'		=> (int) $this->config['thanks_reput_height'],
							'THANKS_REPUT_GRAPHIC_WIDTH'=> (int) $this->config['thanks_reput_level'] * (int) $this->config['thanks_reput_height'],
							'THANKS_REPUT_IMAGE' 		=> !empty($this->config['thanks_reput_image']) ? generate_board_url() . '/' . $this->config['thanks_reput_image'] : '',
							'THANKS_REPUT_IMAGE_BACK'	=> !empty($this->config['thanks_reput_image_back']) ? generate_board_url() . '/' . $this->config['thanks_reput_image_back'] : '',
						]);
					}
				}
				while ($row = $this->db->sql_fetchrow($result));
				$this->db->sql_freeresult($result);
			}
		}

		if ($notoplist)
		{
			trigger_error('RATING_VIEW_TOPLIST_NO');
		}

		$this->pagination->generate_template_pagination($pagination_url, 'pagination', 'start', $total_match_count, (int) $this->config['topics_per_page'], $start);

		// Output the page
		$this->template->assign_vars([
			'PAGE_NUMBER'				=> $this->pagination->on_page($total_match_count, (int) $this->config['posts_per_page'], $start),
			'PAGE_TITLE'				=> $page_title,
			'PHPBB_VERSION'				=> phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>=') ? '3.2' : '3.1',
			'S_THANKS_FORUM_REPUT_VIEW' => (bool) $this->config['thanks_forum_reput_view'],
			'S_THANKS_TOPIC_REPUT_VIEW' => (bool) $this->config['thanks_topic_reput_view'],
			'S_THANKS_POST_REPUT_VIEW'	=> (bool) $this->config['thanks_post_reput_view'],
			'S_FULL_POST_RATING'		=> $full_post_rating,
			'S_FULL_TOPIC_RATING'		=> $full_topic_rating,
			'S_FULL_FORUM_RATING'		=> $full_forum_rating,
			'U_SEARCH_POST'				=> $u_search_post,
			'U_SEARCH_TOPIC'			=> $u_search_topic,
			'U_SEARCH_FORUM'			=> $u_search_forum,
		]);

		make_jumpbox(append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext"));

		// Send all data to the template file
		return $this->controller_helper->render('toplist_body.html', $page_title);
	}
}
