<?php
/**
*
* @package ThanksForPosts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\ThanksForPosts\migrations;

class v_1_2_6 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.6', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.6', '>='));
	}

	static public function depends_on()
	{
		return array('\gfksx\ThanksForPosts\migrations\v_1_2_5');
	}

	public function update_schema()
	{
		return array(
		);
	}

	public function revert_schema()
	{
		return array(
		);
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('thanks_number_post', 10)),

			// Current version
			array('config.add', array('thanks_for_posts_version', '1.2.6')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.6', '<')),
				array('config.update', array('thanks_for_posts_version', '1.2.6')),
			)),

			// Remove ACP module
			array('module.remove', array('acp', 'ACP_MESSAGES', 'ACP_THANKS')),
		);
	}
}
