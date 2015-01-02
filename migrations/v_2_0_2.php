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

class v_2_0_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.2', '>=');
	}

	static public function depends_on()
	{
			return array(
				'\gfksx\ThanksForPosts\migrations\v_2_0_1',
			);
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
			// This config value was missing from the original MOD ver. 1.3.4
			// installation script, so fix and add that
			array('config.add', array('thanks_global_post', 0)),

			// Current version
			array('config.update', array('thanks_for_posts_version', '2.0.2')),
		);
	}
}
