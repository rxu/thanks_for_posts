<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_1_2_5 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.0', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.5', '>='));
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
						'post_id'		=> array('UINT', 0),
						'poster_id'		=> array('UINT', 0),
						'user_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> array('post_id', 'user_id'),
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_allow_thanks_pm'		=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables'	=> array($this->table_prefix . 'thanks'),
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array('user_allow_thanks_pm'),
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

			// Current version
			array('config.add', array('thanks_for_posts_version', '1.2.5')),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),

			// Add permissions
			array('permission.add', array('f_thanks', false)),
			array('permission.add', array('u_viewthanks', true)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('REGISTERED', 'u_viewthanks', 'group', true)),
			array('permission.permission_set', array('ROLE_FORUM_STANDARD', 'f_thanks', 'role', true)),
		);
	}
}
