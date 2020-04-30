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

class v_1_3_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_topic_reput_view_column']) && isset($this->config['thanks_topic_reput_view_column']);
	}

	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_1_3_1'];
	}

	public function update_data()
	{
		return [
			// Add configs
			['config.add', ['thanks_forum_reput_view_column', 0]],
			['config.add', ['thanks_topic_reput_view_column', 0]],
		];
	}
}
