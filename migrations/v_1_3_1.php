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

class v_1_3_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
			return array('\gfksx\thanksforposts\migrations\v_1_2_8');
	}

	public function update_data()
	{
		return array(
			// Add permissions
			array('permission.add', array('m_thanks', true)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_thanks', 'role', true)),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_thanks', 'group', true)),
		);
	}
}
