<?php
/**
 *
 * Thanks For Posts.
 * Adds the ability to thank the author and to use per posts/topics/forum rating system based on the count of thanks.
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace gfksx\thanksforposts\migrations;

class add_ajax_switch extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_ajax_enabled']);
	}

	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_2_0_8'];
	}

	public function update_data()
	{
		return [
			['config.add', ['thanks_ajax_enabled', 1]],
		];
	}
}
