<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_1_3_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.1', '>=')
				|| isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.3.1', '>=');
	}

	static public function depends_on()
	{
			return array('\phpbb\db\migration\data\v310\dev');
			return array('\ext\gfksx\thanks_for_posts\migrations\1.2.9');
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
			// Current version
			array('config.add', array('thanks_for_posts_version', '1.3.1')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.1', '<')),
				array('config.update', array('thanks_for_posts_version', '1.3.1')),
			)),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),

			// Add permissions
			array('permission.add', array('m_thanks', true)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_thanks', 'role', true)),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_thanks', 'group', true)),
		);
	}
}
