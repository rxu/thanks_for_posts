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

class v_2_0_6 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !isset($this->config['thanks_mod_version'])
			&& !isset($this->config['thanks_for_posts_version']);
	}

	static public function depends_on()
	{
			return array(
				'\gfksx\thanksforposts\migrations\v_2_0_5',
			);
	}

	public function update_data()
	{
		return array(
			// Remove stale configs
			array('config.remove', array('thanks_for_posts_version')),
			array('config.remove', array('thanks_mod_version')),
			array('config.update', array('thanks_reput_image', 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif')),
			array('config.update', array('thanks_reput_image_back', 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif')),
		);
	}
}
