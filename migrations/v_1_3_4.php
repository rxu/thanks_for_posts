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

class v_1_3_4 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_global_announce']);
	}

	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_1_3_3'];
	}

	public function update_schema()
	{
		return [
			'add_index'		=> [
				$this->table_prefix . 'thanks'	=> [
					'post_id'		=> ['post_id'],
					'topic_id'		=> ['topic_id'],
					'forum_id'		=> ['forum_id'],
					'user_id'		=> ['user_id'],
					'poster_id'		=> ['poster_id'],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'thanks' => [
					'post_id',
					'topic_id',
					'forum_id',
					'user_id',
					'poster_id',
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// Add configs
			['config.add', ['thanks_global_announce', 1]],

			// Add permissions sets
			['permission.permission_set', ['ROLE_FORUM_FULL', 'f_thanks', 'role', true]],
			['permission.permission_set', ['ROLE_FORUM_POLLS', 'f_thanks', 'role', true]],
			['permission.permission_set', ['ROLE_FORUM_LIMITED', 'f_thanks', 'role', true]],
			['permission.permission_set', ['ROLE_FORUM_LIMITED_POLLS', 'f_thanks', 'role', true]],
			['permission.permission_set', ['ROLE_USER_FULL', 'u_viewtoplist', 'role', true]],
			['permission.permission_set', ['ROLE_USER_LIMITED', 'u_viewtoplist', 'role', true]],
			['permission.permission_set', ['ROLE_USER_NOPM', 'u_viewtoplist', 'role', true]],
			['permission.permission_set', ['ROLE_USER_NOAVATAR', 'u_viewtoplist', 'role', true]],
			['permission.permission_set', ['ROLE_USER_FULL', 'u_viewthanks', 'role', true]],
			['permission.permission_set', ['ROLE_USER_LIMITED', 'u_viewthanks', 'role', true]],
			['permission.permission_set', ['ROLE_USER_NOPM', 'u_viewthanks', 'role', true]],
			['permission.permission_set', ['ROLE_USER_NOAVATAR', 'u_viewthanks', 'role', true]],
		];
	}
}
