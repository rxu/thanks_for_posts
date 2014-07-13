<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_1_2_9 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.9', '>=')
				|| isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.9', '>=');
	}
	static public function depends_on()
	{
			return array('\phpbb\db\migration\data\v310\dev');
			return array('\ext\gfksx\thanks_for_posts\migrations\1.2.8');
	}

	public function update_schema()
	{
		return 	array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_allow_thanks_email'	=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array('user_allow_thanks_email'),
			),
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('thanks_for_posts_version', '1.2.9')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.9', '<')),
				array('config.update', array('thanks_for_posts_version', '1.2.9')),
			)),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),
		);
	}
}
