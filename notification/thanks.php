<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace gfksx\ThanksForPosts\notification;

/**
* Thanks for posts notifications class
* This class handles notifying users when they have been thanked for a post
*/

class thanks extends \phpbb\notification\type\base
{
	/**
	* Get notification type name
	*
	* @return string
	*/
	public function get_type()
	{
		return 'gfksx.thanksforposts.notification.type.thanks';
	}

	/**
	* Language key used to output the text
	*
	* @var string
	*/
	protected $language_key = 'NOTIFICATION_THANKS_GIVE';

	/**
	* Notification option data (for outputting to the user)
	*
	* @var bool|array False if the service should use it's default data
	* 					Array of data (including keys 'id', 'lang', and 'group')
	*/
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_THANKS_GIVE',
		'group'	=> 'NOTIFICATION_GROUP_MISCELLANEOUS',
	);

	/** @var string */
	protected $notifications_table;

	/** @var \phpbb\user_loader */
	protected $user_loader;

	public function set_notifications_table($notifications_table)
	{
		$this->notifications_table = $notifications_table;
	}

	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	/**
	* Is available
	*/
	public function is_available()
	{
		return true;
	}

	/**
	* Get the id of the item
	*
	* @param array $thanks_data The data from the thank
	*/
	public static function get_item_id($thanks_data)
	{
		return (int) $thanks_data['post_id'];
	}

	/**
	* Get the id of the parent
	*
	* @param array $thanks_data The data from the thank
	*/
	public static function get_item_parent_id($thanks_data)
	{
		return (int) $thanks_data['topic_id'];
	}

	/**
	* Find the users who want to receive notifications
	*
	* @param array $thanks_data The data from the thank
	* @param array $options Options for finding users for notification
	*
	* @return array
	*/
	public function find_users_for_notification($thanks_data, $options = array())
	{
		$options = array_merge(array(
			'ignore_users'		=> array(),
		), $options);

		$users = array((int) $thanks_data['poster_id']);
		return $this->check_user_notification_options($users, $options);
	}

	/**
	* Get the user's avatar
	*/
	public function get_avatar()
	{
		$thankers = $this->get_data('thankers');
		return (sizeof($thankers) == 1) ? $this->user_loader->get_avatar($thankers[0]['user_id']) : '';
	}

	/**
	* Get the HTML formatted title of this notification
	*
	* @return string
	*/
	public function get_title()
	{
		$thankers = $this->get_data('thankers');
		$usernames = array();

		if (!is_array($thankers))
		{
			$thankers = array();
		}

		$thankers_cnt = sizeof($thankers);
		$thankers = $this->trim_user_ary($thankers);
		$trimmed_thankers_cnt = $thankers_cnt - sizeof($thankers);

		foreach ($thankers as $thanker)
		{
			$usernames[] = $this->user_loader->get_username($thanker['user_id'], 'no_profile');
		}

		if ($trimmed_thankers_cnt > 20)
		{
			$usernames[] = $this->language->lang('NOTIFICATION_MANY_OTHERS');
		}
		else if ($trimmed_thankers_cnt)
		{
			$usernames[] = $this->language->lang('NOTIFICATION_X_OTHERS', $trimmed_thankers_cnt);
		}

		return $this->language->lang(
			$this->language_key,
			phpbb_generate_string_list($usernames, $this->user),
			$thankers_cnt
		);
	}

	/**
	* Users needed to query before this notification can be displayed
	*
	* @return array Array of user_ids
	*/
	public function users_to_query()
	{
		$thankers = $this->get_data('thankers');
		$users = array(
			$this->get_data('user_id'),
		);

		if (is_array($thankers))
		{
			foreach ($thankers as $thanker)
			{
				$users[] = $thanker['user_id'];
			}
		}

		return $users;
	}

	/**
	* Get the url to this item
	*
	* @return string URL
	*/
	public function get_url()
	{
		return append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, "p={$this->item_id}#p{$this->item_id}");
	}

	/**
	* {inheritDoc}
	*/
	public function get_redirect_url()
	{
		return $this->get_url();
	}

	/**
	* Get email template
	*
	* @return string|bool
	*/
	public function get_email_template()
	{
		return '@gfksx_ThanksForPosts/user_thanks';
	}

	/**
	* Get the HTML formatted reference of the notification
	*
	* @return string
	*/
	public function get_reference()
	{
		return $this->language->lang(
			'NOTIFICATION_REFERENCE',
			censor_text($this->get_data('post_subject'))
		);
	}

	/**
	* Trim the user array passed down to 3 users if the array contains
	* more than 4 users.
	*
	* @param array $users Array of users
	* @return array Trimmed array of user_ids
	*/
	public function trim_user_ary($users)
	{
		if (sizeof($users) > 4)
		{
			array_splice($users, 3);
		}
		return $users;
	}

	/**
	* Get email template variables
	*
	* @return array
	*/
	public function get_email_template_variables()
	{
		$username = $this->user_loader->get_username($this->get_data('poster_id'), 'username');

		return array(
				'THANKS_SUBG'	=> htmlspecialchars_decode($this->language->lang('THANKS_PM_SUBJECT_'. $this->get_data('lang_act'))),
				'USERNAME'		=> htmlspecialchars_decode($this->user->data['username']),
				'POST_SUBJECT'	=> htmlspecialchars_decode(censor_text($this->get_data('post_subject'))),
				'POST_THANKS'	=> htmlspecialchars_decode($this->language->lang('THANKS_PM_MES_'. $this->get_data('lang_act'))),
				'POSTER_NAME'	=> htmlspecialchars_decode($username),
				'U_POST_THANKS'	=> generate_board_url() . '/viewtopic.' . $this->php_ext . "?p={$this->item_id}#p{$this->item_id}",
		);
	}

	/**
	* Function for preparing the data for insertion in an SQL query
	* (The service handles insertion)
	*
	* @param array $thanks_data Data from insert_thanks
	* @param array $pre_create_data Data from pre_create_insert_array()
	*
	* @return array Array of data ready to be inserted into the database
	*/
	public function create_insert_array($thanks_data, $pre_create_data = array())
	{
		$thankers = (isset($thanks_data['thankers'])) ? $thanks_data['thankers'] : array();
		$thankers = array_merge(
			array(array('user_id' => $thanks_data['user_id'])),
			$thankers
		);
		$this->set_data('thankers', $thankers);

		$this->set_data('post_id', $thanks_data['post_id']);
		$this->set_data('lang_act', $thanks_data['lang_act']);
		$this->set_data('post_subject', $thanks_data['post_subject']);
		$this->set_data('poster_id', $thanks_data['poster_id']);

		parent::create_insert_array($thanks_data, $pre_create_data);
	}

	/**
	* Function for preparing the data for update in an SQL query
	* (The service handles insertion)
	*
	* @param array $thanks_data Data unique to this notification type
	* @return array Array of data ready to be updated in the database
	*/
	public function create_update_array($thanks_data)
	{
		$sql = 'SELECT notification_data
			FROM ' . $this->notifications_table . '
			WHERE notification_type_id = ' . (int) $this->notification_type_id . '
				AND item_id = ' . (int) self::get_item_id($thanks_data);
		$result = $this->db->sql_query($sql);
		if ($row = $this->db->sql_fetchrow($result))
		{
			$data = unserialize($row['notification_data']);
			$thanks_data['thankers'] = (!empty($data['thankers'])) ? $data['thankers'] : array();
		}

		$this->create_insert_array($thanks_data);
		return $this->get_insert_array();
	}
}
