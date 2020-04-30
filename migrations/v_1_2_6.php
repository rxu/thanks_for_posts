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

class v_1_2_6 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_number_post']);
	}

	static public function depends_on()
	{
		return ['\gfksx\thanksforposts\migrations\v_1_2_5'];
	}

	public function update_data()
	{
		return [
			// Add configs
			['config.add', ['thanks_number_post', 10]],

			// Remove ACP module
			['module.remove', ['acp', 'ACP_MESSAGES', 'ACP_THANKS']],
		];
	}
}
