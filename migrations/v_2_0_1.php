<?php
/**
*
* @package ThanksForPosts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\ThanksForPosts\migrations;

class v_2_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.1', '>=');
	}

	static public function depends_on()
	{
			return array('\gfksx\ThanksForPosts\migrations\v_2_0_0');
	}

	public function update_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_allow_thanks_email',
					'user_allow_thanks_pm',
				),
			),
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
			// Current version
			array('config.update', array('thanks_for_posts_version', '2.0.1')),
		);
	}
}
