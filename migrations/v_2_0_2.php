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

class v_2_0_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_global_post']);
	}

	static public function depends_on()
	{
			return array(
				'\gfksx\thanksforposts\migrations\v_2_0_1',
			);
	}

	public function update_data()
	{
		return array(
			// This config value was missing from the original MOD ver. 1.3.4
			// installation script, so fix and add that
			array('config.add', array('thanks_global_post', 0)),
		);
	}
}
