<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\thanksforposts;

/**
* Extension class for custom enable/disable/purge actions
*
* NOTE TO EXTENSION DEVELOPERS:
* Normally it is not necessary to define any functions inside the ext class below.
* The ext class may contain special (un)installation commands in the methods
* enable_step(), disable_step() and purge_step(). As it is, these methods are defined
* in phpbb_extension_base, which this class extends, but you can overwrite them to
* give special instructions for those cases. This extension must do this because it uses
* the notifications system, which requires the methods enable_notifications(),
* disable_notifications() and purge_notifications() be run to properly manage the
* notifications created by it when enabling, disabling or deleting this extension.
*/
class ext extends \phpbb\extension\base
{
	/**
	* Overwrite enable_step to enable notifications
	* before any included migrations are installed.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	function enable_step($old_state)
	{
		if ($this->rename_extension('gfksx/ThanksForPosts', 'gfksx/thanksforposts'))
		{
			return 0;
		}

		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Enable notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('gfksx.thanksforposts.notification.type.thanks');
				$phpbb_notifications->enable_notifications('gfksx.thanksforposts.notification.type.thanks_remove');
				return 'notifications';

			break;

			default:

				// Run parent enable step method
				return parent::enable_step($old_state);

			break;
		}
	}

	/**
	* Overwrite disable_step to disable notifications
	* before the extension is disabled.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Disable notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('gfksx.thanksforposts.notification.type.thanks');
				$phpbb_notifications->disable_notifications('gfksx.thanksforposts.notification.type.thanks_remove');
				return 'notifications';

			break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

			break;
		}
	}

	/**
	* Overwrite purge_step to purge notifications before
	* any included and installed migrations are reverted.
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Purge notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('gfksx.thanksforposts.notification.type.thanks');
				$phpbb_notifications->purge_notifications('gfksx.thanksforposts.notification.type.thanks_remove');
				return 'notifications';

			break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

			break;
		}
	}

	/**
	* Rename extension
	*
	* @param string Old vendor/name
	* @param string New vendor/name
	* @return null
	*/
	function rename_extension($old_name, $new_name)
	{
		$renaming = false;
		// For some fields vendor\name is used instead of vendor/name
		$old_name_revert_separator = str_replace('/', '\\', $old_name);
		$new_name_revert_separator = str_replace('/', '\\', $new_name);

		$db = $this->container->get('dbal.conn');
		$result = $db->sql_query('SELECT ext_active FROM ' . EXT_TABLE . " WHERE ext_name = '" . $db->sql_escape($old_name) . "'");

		if ($db->sql_fetchrow($result))
		{
			$db->sql_transaction('begin');

			$sql_migrations = 'UPDATE ' . MIGRATIONS_TABLE . " SET
				migration_name = REPLACE(migration_name, '" . $db->sql_escape($old_name_revert_separator) . "', '" .  $db->sql_escape($new_name_revert_separator) . "'),
				migration_depends_on = REPLACE(migration_depends_on, '" . $db->sql_escape($old_name_revert_separator) . "', '" .  $db->sql_escape($new_name_revert_separator) . "')
				ORDER BY migration_name DESC";
			$db->sql_query($sql_migrations);

			$sql_modules = 'UPDATE ' . MODULES_TABLE . " SET
				module_basename = REPLACE(module_basename, '" . $db->sql_escape($old_name_revert_separator) . "', '" .  $db->sql_escape($new_name_revert_separator) . "'),
				module_auth = REPLACE(module_auth, '" . $db->sql_escape($old_name) . "', '" .  $db->sql_escape($new_name) . "')
				ORDER BY module_basename DESC";
			$db->sql_query($sql_modules);

			$sql_ext = 'UPDATE ' . EXT_TABLE . " SET
				ext_name = REPLACE(ext_name, '" . $db->sql_escape($old_name) . "', '" .  $db->sql_escape($new_name) . "')
				ORDER BY ext_name DESC";
			$db->sql_query($sql_ext);

			$sql_notification_types = 'UPDATE ' . NOTIFICATION_TYPES_TABLE . " SET
				notification_type_name = REPLACE(notification_type_name, '" . $db->sql_escape(str_replace('/', '.', $old_name)) . "', '" .  $db->sql_escape(str_replace('/', '.', $new_name)) . "')
				ORDER BY notification_type_name DESC";
			$db->sql_query($sql_notification_types);

			$db->sql_transaction('commit');

			$this->container->get('cache')->purge();
			$this->migrator->load_migration_state();
			$renaming = true;
		}
		$db->sql_freeresult($result);
		return $renaming;
	}
}
