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

class v_2_0_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !isset($this->config['thanks_forum_reput_view_column'])
			&& !isset($this->config['thanks_topic_reput_view_column']);
	}

	static public function depends_on()
	{
		return ['\gfksx\thanksforposts\migrations\v_2_0_2'];
	}

	public function update_data()
	{
		return [
			['config.remove', ['thanks_topic_reput_view_column']],
			['config.remove', ['thanks_forum_reput_view_column']],
		];
	}
}
