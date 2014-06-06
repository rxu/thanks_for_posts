<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_2_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.0', '>=');
	}

	static public function depends_on()
	{
			return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return 	array(
			'add_tables' => array(
				$this->table_prefix . 'thanks' => array(
					'COLUMNS'		=> array(
						'forum_id'		=> array('UINT', 0),
						'post_id'		=> array('UINT', 0),
						'poster_id'		=> array('UINT', 0),
						'thanks_time'	=> array('UINT:11', 0),
						'topic_id'		=> array('UINT', 0),
						'user_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> array('post_id', 'user_id'),
					'KEYS'			=> array(
						'post_id'		=> array('INDEX', 'post_id'),
						'topic_id'		=> array('INDEX', 'topic_id'),
						'forum_id'		=> array('INDEX', 'forum_id'),
						'user_id'		=> array('INDEX', 'user_id'),
						'poster_id'		=> array('INDEX', 'poster_id'),
					),
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_allow_thanks_pm'		=> array('BOOL', 0),
					'user_allow_thanks_email'	=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables'	=> array($this->table_prefix . 'thanks'),
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array('user_allow_thanks_pm', 'user_allow_thanks_email'),
			),
		);
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('remove_thanks', 1)),
			array('config.add', array('thanks_postlist_view', 1)),
			array('config.add', array('thanks_profilelist_view', 1)),
			array('config.add', array('thanks_counters_view', 1)),
			array('config.add', array('thanks_number', 100)),
			array('config.add', array('thanks_info_page', 1)),
			array('config.add', array('thanks_only_first_post', 0)),
			array('config.add', array('thanks_number_post', 10)),
			array('config.add', array('thanks_post_reput_view', 1)),
			array('config.add', array('thanks_topic_reput_view', 1)),
			array('config.add', array('thanks_forum_reput_view', 0)),
			array('config.add', array('thanks_reput_height', 15)),
			array('config.add', array('thanks_reput_level', 10)),
			array('config.add', array('thanks_number_digits', 2)),
			array('config.add', array('thanks_number_row_reput', 5)),
			array('config.add', array('thanks_reput_graphic', 1)),
			array('config.add', array('thanks_reput_image', 'images/rating/reput_star_gold.gif')),
			array('config.add', array('thanks_reput_image_back', 'images/rating/reput_star_back.gif')),
			array('config.add', array('thanks_time_view', 1)),
			array('config.add', array('thanks_top_number', 0)),
			array('config.add', array('thanks_forum_reput_view_column', 0)),
			array('config.add', array('thanks_topic_reput_view_column', 0)),
			array('config.add', array('thanks_notice_on', 0)),
			array('config.add', array('thanks_global_announce', 1)),

			// Current version
			array('config.add', array('thanks_for_posts_version', '2.0.0')),

			// Add permissions
			array('permission.add', array('f_thanks', false)),
			array('permission.add', array('u_viewthanks', true)),
			array('permission.add', array('u_viewtoplist', true)),
			array('permission.add', array('m_thanks', true)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('REGISTERED', 'u_viewthanks', 'group', true)),
			array('permission.permission_set', array('ROLE_FORUM_STANDARD', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('REGISTERED', 'u_viewtoplist', 'group', true)),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_thanks', 'role', true)),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_thanks', 'group', true)),
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_POLLS', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_LIMITED', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_LIMITED_POLLS', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_viewthanks', 'role', true)),

			// Add ACP modules
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_THANKS')),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_module',
					'module_langname'	=> 'ACP_THANKS_SETTINGS',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_refresh_module',
					'module_langname'	=> 'ACP_THANKS_REFRESH',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_truncate_module',
					'module_langname'	=> 'ACP_THANKS_TRUNCATE',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_reput_module',
					'module_langname'	=> 'ACP_THANKS_REPUT_SETTINGS',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
		);
	}
}
