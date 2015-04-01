<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\ThanksForPosts\migrations;

class v_1_2_8 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return (isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.8', '>='))
				|| (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.8', '>='));
	}

	static public function depends_on()
	{
			return array('\gfksx\ThanksForPosts\migrations\v_1_2_6');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'thanks' => array(
					'topic_id'		=> array('UINT', 0),
					'forum_id'		=> array('UINT', 0),
					'thanks_time'	=> array('UINT:11', 0),
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
			array('config.add', array('thanks_post_reput_view', 1)),
			array('config.add', array('thanks_topic_reput_view', 1)),
			array('config.add', array('thanks_forum_reput_view', 0)),
			array('config.add', array('thanks_reput_height', 15)),
			array('config.add', array('thanks_reput_level', 10)),
			array('config.add', array('thanks_number_digits', 2)),
			array('config.add', array('thanks_number_row_reput', 5)),
			array('config.add', array('thanks_reput_graphic', 1)),
			array('config.add', array('thanks_reput_image', 'ext/gfksx/ThanksForPosts/images/rating/reput_star_gold.gif')),
			array('config.add', array('thanks_reput_image_back', 'ext/gfksx/ThanksForPosts/images/rating/reput_star_back.gif')),
			array('config.add', array('thanks_time_view', 1)),
			array('config.add', array('thanks_top_number', 0)),

			// Current version
			array('config.add', array('thanks_for_posts_version', '1.2.8')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '1.2.8', '<')),
				array('config.update', array('thanks_for_posts_version', '1.2.8')),
			)),

			// Add permissions
			array('permission.add', array('u_viewtoplist', true)),

			// Add permissions sets
			array('permission.permission_set', array('REGISTERED', 'u_viewtoplist', 'group', true)),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_viewtoplist', 'role', true)),

			// Update thanks for posts table
			array('custom', array(array($this, 'update_thanks_table'))),
		);
	}

	public function update_thanks_table()
	{
		$thanks_table = $this->table_prefix . 'thanks';

		$sql = 'UPDATE '. $thanks_table . ' t
			LEFT JOIN ' . POSTS_TABLE . ' p ON  t.post_id = p.post_id
			SET t.forum_id = p.forum_id, t.topic_id = p.topic_id
			WHERE t.post_id = p.post_id';
		$this->db->sql_query($sql);
	}
}
