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

class v_2_0_6 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !isset($this->config['thanks_mod_version'])
			&& !isset($this->config['thanks_for_posts_version']);
	}

	static public function depends_on()
	{
		return ['\gfksx\thanksforposts\migrations\v_2_0_3'];
	}

	public function update_data()
	{
		return [
			// Remove stale configs
			['config.remove', ['thanks_for_posts_version']],
			['config.remove', ['thanks_mod_version']],
			['config.update', ['thanks_reput_image', 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif']],
			['config.update', ['thanks_reput_image_back', 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif']],
		];
	}
}
