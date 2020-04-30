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

class v_2_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !$this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_allow_thanks_email')
			&& !$this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_allow_thanks_pm');
	}

	static public function depends_on()
	{
			return [
				'\gfksx\thanksforposts\migrations\v_2_0_0',
				'\phpbb\db\migration\data\v310\notifications_use_full_name',
			];
	}

	public function update_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'users' => [
					'user_allow_thanks_email',
					'user_allow_thanks_pm',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_allow_thanks_email'	=> ['BOOL', 0],
					'user_allow_thanks_pm'		=> ['BOOL', 0],
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// Update notification names
			['custom', [[$this, 'update_notifications_name']]],
		];
	}

	public function update_notifications_name()
	{
		// New notification_type_name and re-enable
		$sql_ary[] = [
			'notification_type_name'	=> 'gfksx.thanksforposts.notification.type.thanks',
			'notification_type_enabled'	=> 1,
		];
		$sql_ary[] = [
			'notification_type_name'	=> 'gfksx.thanksforposts.notification.type.thanks_remove',
			'notification_type_enabled'	=> 1,
		];

		foreach ($sql_ary as $sql)
		{
			$notification_type_name = explode('type.', $sql['notification_type_name']);

			$sql_update = 'UPDATE ' . NOTIFICATION_TYPES_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql) . "
				WHERE notification_type_name = '" . $this->db->sql_escape($notification_type_name[1]) . "'";
			$this->db->sql_query($sql_update);

			$sql_update = 'UPDATE ' . USER_NOTIFICATIONS_TABLE . "
				SET item_type = '" . $this->db->sql_escape($sql['notification_type_name']) . "'
				WHERE item_type = '" . $this->db->sql_escape($notification_type_name[1]) . "'";
			$this->db->sql_query($sql_update);
		}
	}
}
