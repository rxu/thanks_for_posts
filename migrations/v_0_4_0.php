<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\thanksforposts\migrations;

class v_0_4_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'thanks') && $this->db_tools->sql_column_exists($this->table_prefix . 'thanks', 'poster_id');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		if (!$this->db_tools->sql_table_exists($this->table_prefix . 'thanks'))
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
		// If the thanks table exists but 'poster_id' column doesn't, most likely this is an upgrade
		// from the 3.0 'Thank Post Mod 0.4.0' https://www.phpbb.com/community/viewtopic.php?f=434&t=543797
		// by Geoffreak http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&un=Geoffreak
		// which is the one 'Thanks for posts MOD' by Палыч was initially based on
		else if (!$this->db_tools->sql_column_exists($this->table_prefix . 'thanks', 'poster_id'))
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
			'drop_tables'	=> array($this->table_prefix . 'thanks'),
		);
	}
}
