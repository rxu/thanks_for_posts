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

class v_2_0_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !isset($this->config['thanks_forum_reput_view_column'])
			&& !isset($this->config['thanks_topic_reput_view_column']);
	}

	static public function depends_on()
	{
			return array(
				'\gfksx\thanksforposts\migrations\v_2_0_2',
			);
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('thanks_topic_reput_view_column')),
			array('config.remove', array('thanks_forum_reput_view_column')),
		);
	}
}
