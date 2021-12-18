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

class v_2_0_8 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_2_0_6'];
	}

	public function update_schema()
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'thanks' => ['poster_id'],
				$this->table_prefix . 'thanks' => ['user_id'],
			],
			'add_index' => [
				$this->table_prefix . 'thanks' => [
					'poster_id'	=> ['poster_id', 'forum_id'],
					'user_id'	=> ['user_id', 'forum_id'],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'thanks' => ['poster_id'],
				$this->table_prefix . 'thanks' => ['user_id'],
			],
			'add_index' => [
				$this->table_prefix . 'thanks' => [
					'poster_id'	=> ['poster_id'],
					'user_id'	=> ['poster_id'],
				],
			],
		];
	}
}
