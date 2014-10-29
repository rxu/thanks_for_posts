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

class v_1_3_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.3', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.3.3', '>='));
	}

	static public function depends_on()
	{
			return array('\gfksx\ThanksForPosts\migrations\v_1_3_2');
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
			array('config.add', array('thanks_for_posts_version', '1.3.3')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.3', '<')),
				array('config.update', array('thanks_for_posts_version', '1.3.3')),
			)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_thanks', 'role', true)),
		);
	}
}
