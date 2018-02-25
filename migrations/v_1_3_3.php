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

class v_1_3_3 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
			return array('\gfksx\thanksforposts\migrations\v_1_3_2');
	}

	public function update_data()
	{
		return array(
			// Add permissions sets
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_thanks', 'role', true)),
		);
	}
}
