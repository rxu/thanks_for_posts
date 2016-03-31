<?php
/**
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: toplist.php,v 135 2012-10-10 10:02:51 Палыч $
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\ThanksForPosts\controller;

use Symfony\Component\HttpFoundation\Response;

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

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var gfksx\ThanksForPosts\core\helper */
	protected $gfksx_helper;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var phpbb\controller\helper */
	protected $controller_helper;

	/** @var string THANKS_TABLE */
	protected $thanks_table;

	/** @var string USERS_TABLE */
	protected $users_table;

	/** @var string POSTS_TABLE */
	protected $posts_table;

	/**
	* Constructor
	*
	* @param \phpbb\config\config                 $config                Config object
	* @param \phpbb\db\driver\driver_interface    $db                    DBAL object
	* @param \phpbb\auth\auth                     $auth                  Auth object
	* @param \phpbb\template\template             $template              Template object
	* @param \phpbb\user                          $user                  User object
	* @param \phpbb\cache\driver\driver_interface $cache                 Cache driver object
	* @param string                               $phpbb_root_path       phpbb_root_path
	* @param string                               $php_ext               phpEx
	* @param \phpbb\pagination                    $pagination            Pagination object
	* @param \gfksx\ThanksForPosts\core\helper    $gfksx_helper          Helper object
	* @param \phpbb\request\request_interface     $request               Request object
	* @param \phpbb\controller\helper             $controller_helper     Controller helper object
	* @param string                               $thanks_table          THANKS_TABLE
	* @param string                               $users_table           USERS_TABLE
	* @param string                               $posts_table           POSTS_TABLE
	* @return gfksx\ThanksForPosts\controller\thankslist
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\cache\driver\driver_interface $cache, $phpbb_root_path, $php_ext, \phpbb\pagination $pagination, \gfksx\ThanksForPosts\core\helper $gfksx_helper, \phpbb\request\request_interface $request, \phpbb\controller\helper $controller_helper, $thanks_table, $users_table, $posts_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
		$this->template = $template;
		$this->user = $user;
		$this->cache = $cache;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->pagination = $pagination;
		$this->gfksx_helper = $gfksx_helper;
		$this->request = $request;
		$this->controller_helper = $controller_helper;
		$this->thanks_table = $thanks_table;
		$this->users_table = $users_table;
		$this->posts_table = $posts_table;
	}

	public function main()
	{
		include_once($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		$this->user->add_lang(array('memberlist', 'groups', 'search'));
		$this->user->add_lang_ext('gfksx/ThanksForPosts', 'thanks_mod');

		// Grab data
		$mode = $this->request->variable('mode', '');
		$end_row_rating = isset($this->config['thanks_number_row_reput']) ? $this->config['thanks_number_row_reput'] : false;
		$full_post_rating = $full_topic_rating = $full_forum_rating = false;
		$u_search_post = $u_search_topic = $u_search_forum = '';
		$total_match_count = 0;
		//$page_title = $this->user->lang['REPUT_TOPLIST'];
		$topic_id = $this->request->variable('t', 0);
		$return_chars = $this->request->variable('ch', ($topic_id) ? -1 : 300);
		$words = array();
		$ex_fid_ary = array_keys($this->auth->acl_getf('!f_read', true));
		$ex_fid_ary = (sizeof($ex_fid_ary)) ? $ex_fid_ary : true;
		$pagination_url = append_sid("{$this->phpbb_root_path}toplist",'mode=' . $mode);

		if (!$this->auth->acl_gets('u_viewtoplist'))
		{
			if ($this->user->data['user_id'] != ANONYMOUS)
			{
				trigger_error('RATING_NO_VIEW_TOPLIST');
			}
			login_box('', ((isset($this->user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)])) ? $this->user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)] : $this->user->lang['RATING_LOGIN_EXPLAIN']));
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
				$page_title = $this->user->lang['REPUT_TOPLIST'];
				$total_match_count = 0;
		}
		$page_title = sprintf($this->user->lang['REPUT_TOPLIST'], $total_match_count);
		//post rating
		if (!$full_forum_rating && !$full_topic_rating && $this->config['thanks_post_reput_view'])
		{
			$end = ($full_post_rating) ?  $this->config['topics_per_page'] : $end_row_rating;

			$sql_p_array['FROM']	= array($this->thanks_table => 't');
			$sql_p_array['SELECT'] = 'u.user_id, u.username, u.user_colour, p.post_subject, p.post_id, p.post_time, p.poster_id, p.post_username, p.topic_id, p.forum_id, p.post_text, p.bbcode_uid, p.bbcode_bitfield, p.post_attachment';
			$sql_p_array['SELECT'] .= ', t.post_id, COUNT(*) AS post_thanks';
			$sql_p_array['LEFT_JOIN'][] = array(
				'FROM'	=> array ($this->posts_table => 'p'),
				'ON'	=> 't.post_id = p.post_id',
				);
			$sql_p_array['LEFT_JOIN'][] = array(
				'FROM'	=> array($this->users_table => 'u'),
				'ON'	=> 'p.poster_id = u.user_id'
			);
			$sql_p_array['GROUP_BY'] = 't.post_id';
			$sql_p_array['ORDER_BY'] = 'post_thanks DESC';
			$sql_p_array['WHERE'] = $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true);

			$sql = $this->db->sql_build_query('SELECT',$sql_p_array);
			$result = $this->db->sql_query_limit($sql, $end, $start);
			$u_search_post = append_sid("{$this->phpbb_root_path}toplist", "mode=post");
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
						// make list items visible as such
						if ($row['bbcode_uid'])
						{
							$text_only_message = str_replace('[*:' . $row['bbcode_uid'] . ']', '&sdot;&nbsp;', $text_only_message);
							// no BBCode in text only message
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
						if ($bbcode_bitfield !== '' and !class_exists('bbcode'))
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
					$this->template->assign_block_vars('toppostrow', array(
						'MESSAGE'					=> $this->auth->acl_get('f_read', $row['forum_id']) ? $row['post_text'] : ((!empty($row['forum_id'])) ? $this->user->lang['SORRY_AUTH_READ'] : $row['post_text']),
						'POST_DATE'					=> !empty($row['post_time']) ? $this->user->format_date($row['post_time']) : '',
						'MINI_POST_IMG'				=> $this->user->img('icon_post_target', 'POST'),
						'POST_ID'					=> $post_url,
						'POST_SUBJECT'				=> $this->auth->acl_get('f_read', $row['forum_id']) ? $row['post_subject'] : ((!empty($row['forum_id'])) ? '' : $row['post_subject']),
						'POST_AUTHOR'				=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
						'POST_REPUT'				=> round($row['post_thanks'] / ($max_post_thanks / 100), $this->config['thanks_number_digits']) . '%',
						'POST_THANKS'				=> $row['post_thanks'],
						'S_THANKS_POST_REPUT_VIEW' 	=> isset($this->config['thanks_post_reput_view']) ? $this->config['thanks_post_reput_view'] : false,
						'S_THANKS_REPUT_GRAPHIC' 	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
						'THANKS_REPUT_HEIGHT'		=> sprintf('%dpx', $this->config['thanks_reput_height']),
						'THANKS_REPUT_GRAPHIC_WIDTH' 	=> sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']),
						'THANKS_REPUT_IMAGE' 		=> isset($this->config['thanks_reput_image']) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
						'THANKS_REPUT_IMAGE_BACK'	=> isset($this->config['thanks_reput_image_back']) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',
					));
				}
				while ($row = $this->db->sql_fetchrow($result));
				$this->db->sql_freeresult($result);
			}
		}
		//topic rating
		if (!$full_forum_rating && !$full_post_rating && $this->config['thanks_topic_reput_view'])
		{
			$end = ($full_topic_rating) ?  $this->config['topics_per_page'] : $end_row_rating;

			$sql_t_array['FROM']	= array($this->thanks_table => 'f');
			$sql_t_array['SELECT'] = 'u.user_id, u.username, u.user_colour, t.topic_title, t.topic_id, t.topic_time, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_type, t.topic_status, t.poll_start';
			$sql_t_array['SELECT'] .= ', f.topic_id, COUNT(*) AS topic_thanks';
			$sql_t_array['LEFT_JOIN'][] = array(
				'FROM'	=> array (TOPICS_TABLE => 't'),
				'ON'	=> 'f.topic_id = t.topic_id',
				);
			$sql_t_array['LEFT_JOIN'][] = array(
				'FROM'	=> array($this->users_table => 'u'),
				'ON'	=> 't.topic_poster = u.user_id'
			);
			$sql_t_array['GROUP_BY'] = 'f.topic_id';
			$sql_t_array['ORDER_BY'] = 'topic_thanks DESC';
			$sql_t_array['WHERE'] = $this->db->sql_in_set('f.forum_id', $ex_fid_ary, true);

			$sql = $this->db->sql_build_query('SELECT',$sql_t_array);
			$result = $this->db->sql_query_limit($sql, $end, $start);
			$u_search_topic = append_sid("{$this->phpbb_root_path}toplist", "mode=topic");
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
					topic_status($row, 0, false, $folder_img, $folder_alt, $topic_type);
					$view_topic_url_params = 'f=' . (($row['forum_id']) ? $row['forum_id'] : '') . '&amp;t=' . $row['topic_id'];
					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", $view_topic_url_params);
					$this->template->assign_block_vars('toptopicrow', array(
						'TOPIC_IMG_STYLE'			=> $folder_img,
						'TOPIC_FOLDER_IMG_SRC'		=> $row['forum_id'] ? 'topic_read' : 'announce_read',
						'TOPIC_TITLE'				=> ($this->auth->acl_get('f_read', $row['forum_id'])) ? $row['topic_title'] : ((!empty($row['forum_id'])) ? $this->user->lang['SORRY_AUTH_READ'] : $row['topic_title']),
						'U_VIEW_TOPIC'				=> $view_topic_url,
						'TOPIC_AUTHOR'				=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
						'TOPIC_THANKS'				=> $row['topic_thanks'],
						'TOPIC_REPUT'				=> round($row['topic_thanks'] / ($max_topic_thanks / 100), $this->config['thanks_number_digits']) . '%',
						'S_THANKS_TOPIC_REPUT_VIEW' => isset($this->config['thanks_topic_reput_view']) ? $this->config['thanks_topic_reput_view'] : false,
						'S_THANKS_REPUT_GRAPHIC' 	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
						'THANKS_REPUT_HEIGHT'		=> sprintf('%dpx', $this->config['thanks_reput_height']),
						'THANKS_REPUT_GRAPHIC_WIDTH'=> sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']),
						'THANKS_REPUT_IMAGE' 		=> (isset($this->config['thanks_reput_image'])) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
						'THANKS_REPUT_IMAGE_BACK'	=> (isset($this->config['thanks_reput_image_back'])) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',
					));
				}
				while ($row = $this->db->sql_fetchrow($result));
				$this->db->sql_freeresult($result);
			}
		}
		//forum rating
		if (!$full_topic_rating && !$full_post_rating && $this->config['thanks_forum_reput_view'])
		{
			$end = ($full_forum_rating) ?  $this->config['topics_per_page'] : $end_row_rating;

			$sql_f_array['FROM']	= array($this->thanks_table => 't');
			$sql_f_array['SELECT'] = 'f.forum_name, f.forum_id';
			$sql_f_array['SELECT'] .= ', t.forum_id, COUNT(*) AS forum_thanks';
			$sql_f_array['LEFT_JOIN'][] = array(
				'FROM'	=> array (FORUMS_TABLE => 'f'),
				'ON'	=> 't.forum_id = f.forum_id',
				);
			$sql_f_array['GROUP_BY'] = 't.forum_id';
			$sql_f_array['ORDER_BY'] = 'forum_thanks DESC';
			$sql_f_array['WHERE'] = $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true);

			$sql = $this->db->sql_build_query('SELECT',$sql_f_array);
			$result = $this->db->sql_query_limit($sql, $end, $start);
			$u_search_forum = append_sid("{$this->phpbb_root_path}toplist", "mode=forum");
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
						$this->template->assign_block_vars('topforumrow', array(
							'FORUM_FOLDER_IMG_SRC'		=> $this->user->img('forum_read', 'NO_NEW_POSTS', false, '', 'src'),
							'FORUM_IMG_STYLE'			=> $folder_image,
							'FORUM_NAME'				=> ($this->auth->acl_get('f_read', $row['forum_id'])) ? $row['forum_name'] : ((!empty($row['forum_id'])) ? $this->user->lang['SORRY_AUTH_READ'] : $row['forum_name']),
							'U_VIEW_FORUM'				=> $u_viewforum,
							'FORUM_THANKS'				=> $row['forum_thanks'],
							'FORUM_REPUT'				=> round($row['forum_thanks'] / ($max_forum_thanks / 100), $this->config['thanks_number_digits']) . '%',
							'S_THANKS_FORUM_REPUT_VIEW' => isset($this->config['thanks_forum_reput_view']) ? $this->config['thanks_forum_reput_view'] : false,
							'S_THANKS_REPUT_GRAPHIC' 	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
							'THANKS_REPUT_HEIGHT'		=> sprintf('%dpx', $this->config['thanks_reput_height']),
							'THANKS_REPUT_GRAPHIC_WIDTH'=> sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']),
							'THANKS_REPUT_IMAGE' 		=> (isset($this->config['thanks_reput_image'])) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
							'THANKS_REPUT_IMAGE_BACK'	=> (isset($this->config['thanks_reput_image_back'])) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',
						));
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

		$this->pagination->generate_template_pagination($pagination_url, 'pagination', 'start', $total_match_count, $this->config['topics_per_page'], $start);

		// Output the page
		$this->template->assign_vars(array(
			'PAGE_NUMBER'				=> $this->pagination->on_page($total_match_count, $this->config['posts_per_page'], $start),
			'PAGE_TITLE'				=> $page_title,
			'S_THANKS_FORUM_REPUT_VIEW' => isset($this->config['thanks_forum_reput_view']) ? $this->config['thanks_forum_reput_view'] : false,
			'S_THANKS_TOPIC_REPUT_VIEW' => isset($this->config['thanks_topic_reput_view']) ? $this->config['thanks_topic_reput_view'] : false,
			'S_THANKS_POST_REPUT_VIEW'	=> isset($this->config['thanks_post_reput_view']) ? $this->config['thanks_post_reput_view'] : false,
			'S_FULL_POST_RATING'		=> $full_post_rating,
			'S_FULL_TOPIC_RATING'		=> $full_topic_rating,
			'S_FULL_FORUM_RATING'		=> $full_forum_rating,
			'U_SEARCH_POST'				=> $u_search_post,
			'U_SEARCH_TOPIC'			=> $u_search_topic,
			'U_SEARCH_FORUM'			=> $u_search_forum,
		));

		page_header($page_title);
		$this->template->set_filenames(array(
			'body' => 'toplist_body.html'));

		make_jumpbox(append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext"));
		page_footer();
		return new Response($this->template->return_display('body'), 200);
	}
}
