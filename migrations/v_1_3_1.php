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

class v_1_3_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.1', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.3.1', '>='));
	}

	static public function depends_on()
	{
			return array('\gfksx\ThanksForPosts\migrations\v_1_2_8');
	}

	public function update_schema()
	{
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
		return array(
			// Current version
			array('config.add', array('thanks_for_posts_version', '1.3.1')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.1', '<')),
				array('config.update', array('thanks_for_posts_version', '1.3.1')),
			)),

			// Add permissions
			array('permission.add', array('m_thanks', true)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_thanks', 'role', true)),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_thanks', 'group', true)),
		);
	}
}
