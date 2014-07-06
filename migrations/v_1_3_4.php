<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_1_3_4 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.3.4', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.3.4', '>='));
	}

	static public function depends_on()
	{
		return array('\gfksx\thanks_for_posts\migrations\v_1_3_3');
	}

	public function update_schema()
	{
		return array(
			'add_index'		=> array(
				$this->table_prefix . 'thanks'			=> array(
					'post_id'		=> array('post_id'),
					'topic_id'		=> array('topic_id'),
					'forum_id'		=> array('forum_id'),
					'user_id'		=> array('user_id'),
					'poster_id'		=> array('poster_id'),
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
			// Add configs
			array('config.add', array('thanks_global_announce', 1)),

			// Current version
			array('config.add', array('thanks_for_posts_version', '1.3.4')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version'])),
				array('config.update', array('thanks_for_posts_version', '1.3.4')),
			)),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),

			// Add permissions sets
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_POLLS', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_LIMITED', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_FORUM_LIMITED_POLLS', 'f_thanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_viewtoplist', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_viewthanks', 'role', true)),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_viewthanks', 'role', true)),
		);
	}
}
