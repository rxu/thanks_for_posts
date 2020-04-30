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

class v_1_2_5 extends \phpbb\db\migration\migration
{
	protected $thanks_table_exists;
	protected $poster_id_field_exists;

	public function effectively_installed()
	{
		return isset($this->config['thanks_only_first_post']);
	}

	static public function depends_on()
	{
		return ['\gfksx\thanksforposts\migrations\v_0_4_0'];
	}

	public function update_data()
	{
		return [
			// Add configs
			['config.add', ['remove_thanks', 1]],
			['config.add', ['thanks_postlist_view', 1]],
			['config.add', ['thanks_profilelist_view', 1]],
			['config.add', ['thanks_counters_view', 1]],
			['config.add', ['thanks_number', 100]],
			['config.add', ['thanks_info_page', 1]],
			['config.add', ['thanks_only_first_post', 0]],

			// Add permissions
			['permission.add', ['f_thanks', false]],
			['permission.add', ['u_viewthanks', true]],

			// Add permissions sets
			['permission.permission_set', ['ROLE_USER_STANDARD', 'u_viewthanks', 'role', true]],
			['permission.permission_set', ['REGISTERED', 'u_viewthanks', 'group', true]],
			['permission.permission_set', ['ROLE_FORUM_STANDARD', 'f_thanks', 'role', true]],
		];
	}
}
