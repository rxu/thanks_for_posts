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

class v_1_2_6 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_number_post']);
	}

	static public function depends_on()
	{
		return array('\gfksx\thanksforposts\migrations\v_1_2_5');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('thanks_number_post', 10)),

			// Remove ACP module
			array('module.remove', array('acp', 'ACP_MESSAGES', 'ACP_THANKS')),
		);
	}
}
