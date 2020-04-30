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

class v_2_0_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_global_post']);
	}

	static public function depends_on()
	{
		return ['\gfksx\thanksforposts\migrations\v_2_0_1'];
	}

	public function update_data()
	{
		return [
			// This config value was missing from the original MOD ver. 1.3.4
			// installation script, so fix and add that
			['config.add', ['thanks_global_post', 0]],
		];
	}
}
