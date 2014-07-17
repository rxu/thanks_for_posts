<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_1_3_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.2', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.3.2', '>='));
	}

	static public function depends_on()
	{
			return array('\gfksx\thanks_for_posts\migrations\v_1_3_1');
	}

	public function update_schema()
	{
		return 	array(
		);
	}

	public function revert_schema()
	{
		return 	array(
		);
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('thanks_forum_reput_view_column', 0)),
			array('config.add', array('thanks_topic_reput_view_column', 0)),

			// Current version
			array('config.add', array('thanks_for_posts_version', '1.3.2')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.2', '<')),
				array('config.update', array('thanks_for_posts_version', '1.3.2')),
			)),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),
		);
	}
}
