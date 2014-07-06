<?php
/**
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: thankslist.php,v 135 2012-10-10 10:02:51 Палыч $
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\controller;
use Symfony\Component\HttpFoundation\Response;

class thankslist
{
    public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\cache\driver\driver_interface $cache, $phpbb_root_path, $php_ext, \phpbb\controller\helper $helper, $phpbb_container, \phpbb\request\request_interface $request)
    {
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
        $this->template = $template;
        $this->user = $user;
		$this->cache = $cache;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->helper = $helper;
		$this->phpbb_container = $phpbb_container;
		$this->request = $request;
    }

	public function main($mode, $author_id, $give)
	{
		$this->user->add_lang(array('memberlist', 'groups', 'search'));
		$this->user->add_lang_ext('gfksx/thanks_for_posts', 'thanks_mod');

		// Grab data
		$row_number	= $total_users = 0;
		$givens = $reseved = $rowsp = $rowsu = $words = $where = array();
		$sthanks = false;
		$ex_fid_ary = array_keys($this->auth->acl_getf('!f_read', true));
		$ex_fid_ary = (sizeof($ex_fid_ary)) ? $ex_fid_ary : false;

		if (!$this->auth->acl_gets('u_viewthanks'))
		{
			if ($this->user->data['user_id'] != ANONYMOUS)
			{
				trigger_error('NO_VIEW_USERS_THANKS');
			}
			login_box('', ((isset($this->user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)])) ? $this->user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)] : $this->user->lang['LOGIN_EXPLAIN_MEMBERLIST']));
		}
		$top = $this->request->variable('top', 0);
		$start = $this->request->variable('start', 0);
		$submit = (isset($_POST['submit'])) ? true : false;
		$default_key = 'a';
		$sort_key = $this->request->variable('sk', $default_key);
		$sort_dir = $this->request->variable('sd', 'd');
		$topic_id = $this->request->variable('t', 0);
		$return_chars = $this->request->variable('ch', ($topic_id) ? -1 : 300);
		$order_by = '';

		switch ($mode)
		{
				case 'givens':
				$per_page = $this->config['posts_per_page'];
				$total_match_count = 0;
				$page_title = $this->user->lang['SEARCH'];
				$template_html = 'thanks_results.html';

				switch ($give)
				{
					case 'true':
					$u_search = append_sid("{$this->phpbb_root_path}thankslist/givens/$author_id/true");
					
					$sql = 'SELECT COUNT(user_id) AS total_match_count
						FROM ' . THANKS_TABLE . '  
						WHERE (' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0) AND user_id = '.$author_id; 
					$where = 'user_id';
					break;
						
					case 'false':
					$u_search = append_sid("{$this->phpbb_root_path}thankslist/givens/$author_id/false");
					
					$sql = 'SELECT COUNT(DISTINCT post_id) as total_match_count
						FROM ' . THANKS_TABLE . '  
						WHERE (' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0) AND poster_id = '.$author_id; 
					$where = 'poster_id';
					break;		
				}
				
				$result = $this->db->sql_query($sql);

				if (!$row = $this->db->sql_fetchrow($result))
				{
					break;
				}
				else
				{
					$total_match_count = (int) $row['total_match_count'];
					$this->db->sql_freeresult($result);

					$sql_array = array(
						'SELECT'	=> 'u.username, u.user_colour, p.poster_id, p.post_id, p.topic_id, p.forum_id, p.post_time, p.post_subject, p.post_text, p.post_username, p.bbcode_bitfield, p.bbcode_uid, p.post_attachment, p.enable_bbcode, p. enable_smilies, p.enable_magic_url',
						'FROM'		=> array (THANKS_TABLE => 't'),
						'WHERE'		=> '('. $this->db->sql_in_set('t.forum_id', $ex_fid_ary, true) . ' OR t.forum_id = 0) AND t.' . $where . "= $author_id"
					);
					$sql_array['LEFT_JOIN'][] = array(
						'FROM'	=> array(USERS_TABLE => 'u'),
						'ON'	=> 't.poster_id = u.user_id'
					);
					$sql_array['LEFT_JOIN'][] = array(
						'FROM'	=> array(POSTS_TABLE => 'p'),
						'ON'	=> 't.post_id = p.post_id'
					);
					$sql = $this->db->sql_build_query('SELECT_DISTINCT', $sql_array);
					$result = $this->db->sql_query_limit($sql, $per_page, $start);
			
					if (!$row = $this->db->sql_fetchrow($result))
					{
						break;
					}		
					else
					{
						$bbcode_bitfield = $text_only_message = '';
						do
						{
							// We pre-process some variables here for later usage
							$row['post_text'] = censor_text($row['post_text']);
							$text_only_message = $row['post_text'];
							// make list items visible as such
							if ($row['bbcode_uid'])
							{
								// no BBCode in text only message
								strip_bbcode($text_only_message, $row['bbcode_uid']);
							}

							if ($return_chars == -1 || utf8_strlen($text_only_message) < ($return_chars + 3))
							{
								$row['display_text_only'] = false;
								$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);

								// Does this post have an attachment? If so, add it to the list
								if ($row['post_attachment'] && $config['allow_attachments'])
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
							$flags = (($row['enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) + (($row['enable_smilies']) ? OPTION_FLAG_SMILIES : 0) + (($row['enable_magic_url']) ? OPTION_FLAG_LINKS : 0);					
							$row['post_text'] =	generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $flags);

							$forum_id = $row['forum_id'];

							$this->template->assign_block_vars('searchresults', array (
								'POST_AUTHOR_FULL'		=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
								'POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
								'POST_AUTHOR'			=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
								'U_POST_AUTHOR'			=> get_username_string('profile', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
								'POST_SUBJECT'		=> ($this->auth->acl_get('f_read', $row['forum_id'])) ? $row['post_subject'] : ((!empty($row['forum_id'])) ? '' : $row['post_subject']),
								'POST_DATE'			=> (!empty($row['post_time'])) ? $this->user->format_date($row['post_time']) : '',
								'MESSAGE'			=> ($this->auth->acl_get('f_read', $row['forum_id'])) ? $row['post_text'] : ((!empty($row['forum_id'])) ? $this->user->lang['SORRY_AUTH_READ'] : $row['post_text']),
								'FORUM_ID'			=> $row['forum_id'],
								'TOPIC_ID'			=> $row['topic_id'],
								'POST_ID'			=> $row['post_id'],
								'U_VIEW_TOPIC'		=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id']),
								'U_VIEW_FORUM'		=> append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']),
								'U_VIEW_POST'		=> (!empty($row['post_id'])) ? append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", "t=" . $row['topic_id'] . '&amp;p=' . $row['post_id']) . '#p' . $row['post_id'] : '',
							));
						}
						while ($row = $this->db->sql_fetchrow($result));

						$this->db->sql_freeresult($result);
					}		
				}
				if ($total_match_count > 1000)
				{
					$total_match_count--;
					$l_search_matches = $this->user->lang('FOUND_MORE_SEARCH_MATCHES', $total_match_count);
				}
				else
				{
					$l_search_matches = $this->user->lang('FOUND_SEARCH_MATCHES', $total_match_count);
				}
				$pagination = $this->phpbb_container->get('pagination');
				$pagination->generate_template_pagination($u_search, 'pagination', 'start', $total_match_count, $per_page, $start);
				$this->template->assign_vars(array(
				//	'PAGINATION'		=> generate_pagination($u_search, $total_match_count, $per_page, $start),
					'PAGE_NUMBER'		=> $pagination->on_page($total_match_count, $per_page, $start),
					'TOTAL_MATCHES'		=> $total_match_count,
					'SEARCH_MATCHES'	=> $l_search_matches,
					'U_THANKS'			=> append_sid("{$this->phpbb_root_path}thankslist"),
				));

				break;
				
				default:
				$page_title = $this->user->lang['THANKS_USER'];
				$template_html = 'thankslist_body.html';
				
				// Grab relevant data thanks
				$sql = 'SELECT user_id, COUNT(user_id) AS tally
					FROM ' . THANKS_TABLE . '  
					WHERE ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0
					GROUP BY user_id';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$givens[$row['user_id']] = $row['tally'];
				}
				$this->db->sql_freeresult($result);

				$sql = 'SELECT poster_id, COUNT(user_id) AS tally
					FROM ' . THANKS_TABLE . ' 
					WHERE ' . $this->db->sql_in_set('forum_id', $ex_fid_ary, true) . ' OR forum_id = 0
					GROUP BY poster_id';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$reseved[$row['poster_id']] = $row['tally'];
				}
				$this->db->sql_freeresult($result);	

				// Sorting
				$sort_key_text = array('a' => $this->user->lang['SORT_USERNAME'], 'b' => $this->user->lang['SORT_LOCATION'], 'c' => $this->user->lang['SORT_JOINED'], 'd' => $this->user->lang['SORT_POST_COUNT'], 'e' => 'R_THANKS', 'f' => 'G_THANKS',);
				$sort_key_sql = array('a' => 'u.username_clean', 'b' => 'u.user_from', 'c' => 'u.user_regdate', 'd' => 'u.user_posts', 'e' => 'count_thanks', 'f' => 'count_thanks');
				$sort_dir_text = array('a' => $this->user->lang['ASCENDING'], 'd' => $this->user->lang['DESCENDING']);
				if ($this->auth->acl_get('u_viewonline'))
				{
					$sort_key_text['l'] = $this->user->lang['SORT_LAST_ACTIVE'];
					$sort_key_sql['l'] = 'u.user_lastvisit';
				}

				$s_sort_key = '';
				foreach ($sort_key_text as $key => $value)
				{
					$selected = ($sort_key == $key) ? ' selected="selected"' : '';
					$s_sort_key .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
				}
				$s_sort_dir = '';
				foreach ($sort_dir_text as $key => $value)
				{
					$selected = ($sort_dir == $key) ? ' selected="selected"' : '';
					$s_sort_dir .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
				}

				// Sorting and order
				if (!isset($sort_key_sql[$sort_key]))
				{
					$sort_key = $default_key;
				}

				$order_by .= $sort_key_sql[$sort_key] . ' ' . (($sort_dir == 'a') ? 'ASC' : 'DESC');

				// Build a relevant pagination_url
				$params = array();
				$check_params = array(
					'sk'			=> array('sk', $default_key),
					'sd'			=> array('sd', 'a'),
				);
				foreach ($check_params as $key => $call)
				{
					if (!isset($_REQUEST[$key]))
					{
						continue;
					}

					$param = call_user_func_array(array($this->request, 'variable'), $call);
					$param = urlencode($key) . '=' . ((is_string($param)) ? urlencode($param) : $param);
					$params[] = $param;

					if ($key != 'sk' && $key != 'sd')
					{
						$sort_params[] = $param;
					}
				}
				$pagination_url = append_sid("{$this->phpbb_root_path}thankslist", implode('&amp;', $params));
				$sort_url = append_sid("{$this->phpbb_root_path}thankslist", $mode);

				// Grab relevant data
				$sql = 'SELECT DISTINCT poster_id
					FROM ' . THANKS_TABLE;
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$rowsp[] = $row['poster_id']; 
				}

				$sql = 'SELECT DISTINCT user_id
					FROM ' . THANKS_TABLE;
				$result = $this->db->sql_query($sql);	

				while ($row = $this->db->sql_fetchrow($result))
				{
					$rowsu[] = $row['user_id']; 
				}
				
				if ($sort_key == 'e')
				{
					$sortparam = 'poster';
					$rows = $rowsp;
				}
				else if ($sort_key == 'f')
				{
					$sortparam = 'user';
					$rows = $rowsu;
				}
				else
				{
					$sortparam = '';		
					$rows = array_merge($rowsp,$rowsu);
				}

				$total_users = count(array_unique($rows));
				
				if (empty($rows))
				{
					break;
				}
				

				
				$sql_array = array(
					'SELECT'	=> 'u.user_id, u.username, u.user_posts, u.user_colour, u.user_rank, u.user_inactive_reason, u.user_type, u.username_clean, u.user_regdate, u.user_lastvisit',
					'FROM'		=> array(USERS_TABLE => 'u'),
					'ORDER_BY'	=> $order_by,
				);
				
				if ($top)
				{
					$total_users = $top;
					$start = 0;
					$page_title = $this->user->lang['REPUT_TOPLIST'];
				}
				else
				{
					$top = $this->config['topics_per_page'];
				}
				
				if ($sortparam)
				{	
					$sql_array['FROM']	= array(THANKS_TABLE => 't');		
					$sql_array['SELECT'].= ', count(t.'.$sortparam.'_id) as count_thanks';	
					$sql_array['LEFT_JOIN'][] = array(
							'FROM'	=> array(USERS_TABLE => 'u'),
							'ON'	=> 't.'.$sortparam.'_id = u.user_id' 
						);
					$sql_array['GROUP_BY'] = 't.'.$sortparam.'_id';
				}
				
				$where[] = $rows[0];
				for ($i = 1, $end = sizeof($rows); $i < $end; ++$i)
				{
					$where[] = $rows[$i];
				}
				$sql_array['WHERE'] = $this->db->sql_in_set('u.user_id', $where);
				$sql = $this->db->sql_build_query('SELECT', $sql_array);
				$result = $this->db->sql_query_limit($sql, $top, $start);

				if (!$row = $this->db->sql_fetchrow($result))
				{
					trigger_error('NO_USER');
				}		
				else
				{
					do
					{
						$last_visit = $row['user_lastvisit'];
						$user_id = $row['user_id'];
						$rank_title = $rank_img = $rank_img_src = '';
						include_once($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
						get_user_rank($row['user_rank'], (($user_id == ANONYMOUS) ? false : $row['user_posts']), $rank_title, $rank_img, $rank_img_src);
						$sthanks = true;
						// Custom Profile Fields
						$profile_fields = array();
						if ($this->config['load_cpf_viewprofile'])
						{
							$cp = $this->phpbb_container->get('profilefields.manager');
							$profile_fields = $cp->grab_profile_fields_data($user_id);
							$profile_fields = (isset($profile_fields[$user_id])) ? $cp->generate_profile_fields_template_data($profile_fields[$user_id]) : array();
						}
						$this->template->assign_block_vars('memberrow', array(
							'ROW_NUMBER'			=> $row_number + ($start + 1),
							'RANK_TITLE'			=> $rank_title,
							'RANK_IMG'				=> $rank_img,
							'RANK_IMG_SRC'			=> $rank_img_src,
							'GIVENS'				=> (!isset($givens[$user_id])) ? 0 : $givens[$user_id], 
							'RECEIVED'				=> (!isset($reseved[$user_id])) ? 0 : $reseved[$user_id],
							'JOINED'				=> $this->user->format_date($row['user_regdate']),
							'VISITED'				=> (empty($last_visit)) ? ' - ' : $this->user->format_date($last_visit),
							'POSTS'					=> ($row['user_posts']) ? $row['user_posts'] : 0,
							'USERNAME_FULL'			=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
							'USERNAME'				=> get_username_string('username', $row['user_id'], $row['username'], $row['user_colour']),
							'USER_COLOR'			=> get_username_string('colour', $row['user_id'], $row['username'], $row['user_colour']),
							'U_VIEW_PROFILE'		=> get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour']),
							'U_SEARCH_USER'			=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->phpbb_root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=posts") : '',
							'U_SEARCH_USER_GIVENS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->phpbb_root_path}thankslist/givens/$user_id/true") : '',
							'U_SEARCH_USER_RECEIVED'=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->phpbb_root_path}thankslist/givens/$user_id/false") : '',
							'L_VIEWING_PROFILE'		=> sprintf($this->user->lang['VIEWING_PROFILE'], $row['username']),
						//	'LOCATION'				=> ($row['user_from']) ? $row['user_from'] : '',
						//	'U_WWW'					=> (!empty($row['user_website'])) ? $row['user_website'] : '',
							'VISITED'				=> (empty($last_visit)) ? ' - ' : $this->user->format_date($last_visit),
							'S_CUSTOM_FIELDS'		=> (isset($profile_fields['row']) && sizeof($profile_fields['row'])) ? true : false,
						));

						if (!empty($profile_fields['row']))
						{
							$this->template->assign_vars($profile_fields['row']);
						}

						if (!empty($profile_fields['blockrow']))
						{
							foreach ($profile_fields['blockrow'] as $field_data)
							{
								$this->template->assign_block_vars('custom_fields', $field_data);
							}
						}

						$row_number++;
					}
					while ($row = $this->db->sql_fetchrow($result));
					$this->db->sql_freeresult($result);
					// www.phpBB-SEO.com SEO TOOLKIT BEGIN
					$seo_sep = strpos($sort_url, '?') === false ? '?' : '&amp;';
					// www.phpBB-SEO.com SEO TOOLKIT END
					$pagination = $this->phpbb_container->get('pagination');
					$pagination->generate_template_pagination($pagination_url, 'pagination', 'start', $total_users, $this->config['topics_per_page'], $start);
					$this->template->assign_vars(array(
						'PAGE_NUMBER'			=> $pagination->on_page($total_users, $this->config['topics_per_page'], $start),
		//				'PAGINATION'			=> generate_pagination($pagination_url, $total_users, $this->config['topics_per_page'], $start),
						'U_SORT_POSTS'			=> $sort_url . $seo_sep . 'sk=d&amp;sd=' . (($sort_key == 'd' && $sort_dir == 'a') ? 'd' : 'a'),
						'U_SORT_USERNAME'		=> $sort_url . $seo_sep . 'sk=a&amp;sd=' . (($sort_key == 'a' && $sort_dir == 'a') ? 'd' : 'a'),
						'U_SORT_FROM'			=> $sort_url . $seo_sep . 'sk=b&amp;sd=' . (($sort_key == 'b' && $sort_dir == 'a') ? 'd' : 'a'),
						'U_SORT_JOINED'			=> $sort_url . $seo_sep . 'sk=c&amp;sd=' . (($sort_key == 'c' && $sort_dir == 'a') ? 'd' : 'a'),
						'U_SORT_THANKS_R'		=> $sort_url . $seo_sep . 'sk=e&amp;sd=' . (($sort_key == 'e' && $sort_dir == 'd') ? 'a' : 'd'),
		//				'U_SORT_THANKS_RT'		=> $sort_url . $seo_sep . 'sk=e&amp;sd=' . (($sort_key == 'e' && $sort_dir == 'd') ? 'a' : 'd') . '&amp;top=' . $config['thanks_top_number'],
						'U_SORT_THANKS_G'		=> $sort_url . $seo_sep . 'sk=f&amp;sd=' . (($sort_key == 'f' && $sort_dir == 'd') ? 'a' : 'd'),
		//				'U_SORT_THANKS_GT'		=> $sort_url . $seo_sep . 'sk=f&amp;sd=' . (($sort_key == 'f' && $sort_dir == 'd') ? 'a' : 'd') . '&amp;top=' . $config['thanks_top_number'],
						'U_SORT_ACTIVE'			=> ($this->auth->acl_get('u_viewonline')) ? $sort_url . $seo_sep . 'sk=l&amp;sd=' . (($sort_key == 'l' && $sort_dir == 'a') ? 'd' : 'a') : '',
					));
				}
				break;
		}

		// Output the page
		$this->template->assign_vars(array(
			'TOTAL_USERS'		=> $this->user->lang('LIST_USERS', $total_users),
			'U_THANKS'			=> append_sid("{$this->phpbb_root_path}thankslist"),
			'S_THANKS'			=> $sthanks,
		));

		page_header($page_title);

		$this->template->set_filenames(array(
			'body' => $template_html));
			
		make_jumpbox(append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext"));
		page_footer();
		return new Response($this->template->return_display('body'), 200);
	}
}
