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

class v_1_2_8 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_top_number']);
	}

	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_1_2_6'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'thanks' => [
					'topic_id'		=> ['UINT', 0],
					'forum_id'		=> ['UINT', 0],
					'thanks_time'	=> ['UINT:11', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'thanks' => [
					'topic_id',
					'forum_id',
					'thanks_time',
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// Add configs
			['config.add', ['thanks_post_reput_view', 1]],
			['config.add', ['thanks_topic_reput_view', 1]],
			['config.add', ['thanks_forum_reput_view', 0]],
			['config.add', ['thanks_reput_height', 15]],
			['config.add', ['thanks_reput_level', 10]],
			['config.add', ['thanks_number_digits', 2]],
			['config.add', ['thanks_number_row_reput', 5]],
			['config.add', ['thanks_reput_graphic', 1]],
			['config.add', ['thanks_reput_image', 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif']],
			['config.add', ['thanks_reput_image_back', 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif']],
			['config.add', ['thanks_time_view', 1]],
			['config.add', ['thanks_top_number', 0]],

			// Add permissions
			['permission.add', ['u_viewtoplist', true]],

			// Add permissions sets
			['permission.permission_set', ['REGISTERED', 'u_viewtoplist', 'group', true]],
			['permission.permission_set', ['ROLE_USER_STANDARD', 'u_viewtoplist', 'role', true]],

			// Update thanks for posts table
			['custom', [[$this, 'update_thanks_table']]],
		];
	}

	public function update_thanks_table()
	{
		$thanks_table = $this->table_prefix . 'thanks';

		$sql = 'UPDATE '. $thanks_table . ' t
			LEFT JOIN ' . POSTS_TABLE . ' p ON  t.post_id = p.post_id
			SET t.forum_id = p.forum_id, t.topic_id = p.topic_id
			WHERE t.post_id = p.post_id';

		if ($this->db->get_sql_layer() == 'postgres')
		{
			$sql = 'UPDATE '. $thanks_table . ' t
				SET forum_id = p.forum_id, topic_id = p.topic_id 
				FROM ' . POSTS_TABLE . ' p
				WHERE t.post_id = p.post_id';
		}
		else if ($this->db->get_sql_layer() == 'sqlite3')
		{
			$sql = 'UPDATE '. $thanks_table . '
				SET
					forum_id = (SELECT p.forum_id FROM ' . POSTS_TABLE . ' p, ' . $thanks_table . ' t WHERE t.post_id = p.post_id),
					topic_id = (SELECT p.topic_id FROM ' . POSTS_TABLE . ' p, ' . $thanks_table . ' t WHERE t.post_id = p.post_id)
				WHERE EXISTS (SELECT p.* FROM ' . POSTS_TABLE . ' p, ' . $thanks_table . ' t WHERE t.post_id = p.post_id)';
		}
		else if ($this->db->get_sql_layer() == 'mssql' || $this->db->get_sql_layer() == 'mssqlnative')
		{
			$sql = 'UPDATE t
				SET t.forum_id = p.forum_id, t.topic_id = p.topic_id
				FROM ' . POSTS_TABLE . ' p, ' . $thanks_table . ' t
				WHERE t.post_id = p.post_id';
		}

		$this->db->sql_query($sql);
	}
}
