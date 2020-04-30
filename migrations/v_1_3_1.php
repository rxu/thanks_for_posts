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

class v_1_3_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_1_2_8'];
	}

	public function update_data()
	{
		return [
			// Add permissions
			['permission.add', ['m_thanks', true]],

			// Add permissions sets
			['permission.permission_set', ['ROLE_MOD_FULL', 'm_thanks', 'role', true]],
			['permission.permission_set', ['GLOBAL_MODERATORS', 'm_thanks', 'group', true]],
		];
	}
}
