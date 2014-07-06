<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_1_3_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.3', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.3.3', '>='));
	}

	static public function depends_on()
	{
		return array('\gfksx\thanks_for_posts\migrations\v_1_3_2');
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
			array('config.add', array('thanks_notice_on', 0)),

			// Current version
			array('config.add', array('thanks_for_posts_version', '1.3.3')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version'])),
				array('config.update', array('thanks_for_posts_version', '1.3.3')),
			)),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_thanks', 'role', true)),
		);
	}
}
