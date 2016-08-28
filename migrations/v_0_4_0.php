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

class v_0_4_0 extends \phpbb\db\migration\migration
{
	public $thanks_table_exists;
	public $poster_id_field_exists;

	public function effectively_installed()
	{
		$this->thanks_table_exists = $this->db_tools->sql_table_exists($this->table_prefix . 'thanks');
		$this->poster_id_field_exists = ($this->thanks_table_exists) ? $this->db_tools->sql_column_exists($this->table_prefix . 'thanks', 'poster_id') : false;

		return (isset($this->config['thanks_for_posts_version']) || isset($this->config['thanks_mod_version'])
			|| ($this->thanks_table_exists && $this->poster_id_field_exists));
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		// If the thanks table exists but 'poster_id' column doesn't, most likely this is an upgrade
		// from the 3.0 'Thank Post Mod 0.4.0' https://www.phpbb.com/community/viewtopic.php?f=434&t=543797
		// by Geoffreak http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&un=Geoffreak
		// which is the one 'Thanks for posts MOD' by Палыч was initially based on
		if ($this->thanks_table_exists && !$this->poster_id_field_exists)
		{
			return array(
				'add_columns' => array(
					$this->table_prefix . 'thanks' => array(
						'poster_id'		=> array('UINT', 0),
					),
				),
				'add_primary_keys' => array(
					$this->table_prefix . 'thanks' => array('post_id, user_id'),
				),
			);
		}

		return array(
		);
	}

	public function revert_schema()
	{
		return array(
		);
	}

	public function update_data()
	{
		if ($this->thanks_table_exists)
		{
			return array(
				array('custom', array(array($this, 'update_poster_id_data'))),
			);
		}
		else
		{
			return array(
			);
		}
	}

	public function update_poster_id_data()
	{
		$thanks_table = $this->table_prefix . 'thanks';

		$sql = 'UPDATE '. $thanks_table . ' t
			LEFT JOIN ' . POSTS_TABLE . ' p ON  t.post_id = p.post_id
			SET t.poster_id = p.poster_id
			WHERE t.post_id = p.post_id';
		$this->db->sql_query($sql);
	}
}
