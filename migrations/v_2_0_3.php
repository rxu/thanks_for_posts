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

class v_2_0_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.3', '>=');
	}

	static public function depends_on()
	{
			return array(
				'\gfksx\ThanksForPosts\migrations\v_2_0_2',
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
			array('config.remove', array('thanks_topic_reput_view_column')),

			// Current version
			array('config.update', array('thanks_for_posts_version', '2.0.3')),
		);
	}
}
