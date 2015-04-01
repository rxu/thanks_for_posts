<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\ThanksForPosts\migrations;

class v_1_2_5 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.5', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.5', '>='));
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		$thanks_table_exists = $this->db_tools->sql_table_exists($this->table_prefix . 'thanks');

		// If the thanks table exists but 'poster_id' column doesn't, most likely this is an upgrade
		// from the 3.0 'Thank Post Mod 0.4.0' https://www.phpbb.com/community/viewtopic.php?f=434&t=543797
		// by Geoffreak http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&un=Geoffreak
		// which is the one 'Thanks for posts MOD' by Палыч was initially based on
		if (!$thanks_table_exists)
		{
			return array(
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
			);
		}
		else if (!$this->db_tools->sql_column_exists($this->table_prefix . 'thanks', 'poster_id'))
		{
			return array(
				'add_columns' => array(
					$this->table_prefix . 'thanks' => array(
						'poster_id'		=> array('UINT', 0),
					),
				),
				'add_primary_keys' => array(
					$this->table_prefix . 'thanks' => array('post_id', 'user_id'),
				),
			);
		}
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array($this->table_prefix . 'thanks'),
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
