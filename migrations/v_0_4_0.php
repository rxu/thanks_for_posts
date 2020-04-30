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

namespace gfksx\thanksforposts\migrations;

class v_0_4_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'thanks') && $this->db_tools->sql_column_exists($this->table_prefix . 'thanks', 'poster_id');
	}

	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v310\dev'];
	}

	public function update_schema()
	{
		if (!$this->db_tools->sql_table_exists($this->table_prefix . 'thanks'))
		{
			return [
				'add_tables' => [
					$this->table_prefix . 'thanks' => [
						'COLUMNS'		=> [
							'post_id'		=> ['UINT', 0],
							'poster_id'		=> ['UINT', 0],
							'user_id'		=> ['UINT', 0],
						],
						'PRIMARY_KEY'	=> ['post_id', 'user_id'],
					],
				],
			];
		}
		// If the thanks table exists but 'poster_id' column doesn't, most likely this is an upgrade
		// from the 3.0 'Thank Post Mod 0.4.0' https://www.phpbb.com/community/viewtopic.php?f=434&t=543797
		// by Geoffreak http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&un=Geoffreak
		// which is the one 'Thanks for posts MOD' by Палыч was initially based on
		else if (!$this->db_tools->sql_column_exists($this->table_prefix . 'thanks', 'poster_id'))
		{
			return [
				'add_columns' => [
					$this->table_prefix . 'thanks' => [
						'poster_id'		=> ['UINT', 0],
					],
				],
				'add_primary_keys' => [
					$this->table_prefix . 'thanks' =>['post_id, user_id'],
				],
			];
		}

		return [];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [$this->table_prefix . 'thanks'],
		];
	}

	public function revert_data()
	{
		return [
			// Remove configs
			['config.remove', ['thanks_for_posts_version']],
			['config.remove', ['thanks_mod_version']],
		];
	}
}
