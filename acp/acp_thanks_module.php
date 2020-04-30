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

namespace gfksx\thanksforposts\acp;

/**
* @package acp
*/
class acp_thanks_module
{
	var $u_action;
	var $new_config = [];

	function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbb\config\config $config Config object */
		$config = $phpbb_container->get('config');

		/** @var \phpbb\language\language $language Language object */
		$language = $phpbb_container->get('language');

		/** @var \phpbb\request\request $request Request object */
		$request  = $phpbb_container->get('request');

		/** @var \phpbb\template\template $template Template object */
		$template = $phpbb_container->get('template');

		/** @var \phpbb\user $user User object */
		$user = $phpbb_container->get('user');

		$submit = $request->is_set_post('submit');

		$form_key = 'acp_thanks';
		add_form_key($form_key);

		/**
		 *	Validation types are:
		 *		string, int, bool,
		 *		script_path (absolute path in url - beginning with / and no trailing slash),
		 *		rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
		 */
		$display_vars = [
			'title'	=> 'ACP_THANKS_SETTINGS',
			'vars'	=> [
				'legend'					=> 'GENERAL_OPTIONS',
				'remove_thanks'				=> ['lang' => 'REMOVE_THANKS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_only_first_post'	=> ['lang' => 'THANKS_ONLY_FIRST_POST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_global_post'		=> ['lang' => 'THANKS_GLOBAL_POST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_info_page'			=> ['lang' => 'THANKS_INFO_PAGE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_postlist_view'		=> ['lang' => 'THANKS_POSTLIST_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_number_post'		=> ['lang' => 'THANKS_NUMBER_POST', 'validate' => 'int:1:250', 'type' => 'text:4:6', 'explain' => true],
				'thanks_time_view'			=> ['lang' => 'THANKS_TIME_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_counters_view'		=> ['lang' => 'THANKS_COUNTERS_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_profilelist_view'	=> ['lang' => 'THANKS_PROFILELIST_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_number'				=> ['lang' => 'THANKS_NUMBER', 'validate' => 'int:1',	'type' => 'text:4:4', 'explain' => true],
				'thanks_top_number'			=> ['lang' => 'THANKS_TOP_NUMBER', 'validate' => 'int:0', 'type' => 'text:4:6', 'explain' => true],
			]
		];

		if (isset($display_vars['lang']))
		{
			$language->add_lang($display_vars['lang']);
		}

		$this->new_config = $config;
		$cfg_array = ($request->is_set('config')) ? $request->variable('config', ['' => ''], true) : $this->new_config;
		$error = [];

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $language->lang('FORM_INVALID');
		}
		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				$config->set($config_name, $config_value);

			}
		}

		if ($submit)
		{
			$phpbb_log = $phpbb_container->get('log');
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_CONFIG_' . strtoupper($mode));

			trigger_error($language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$this->tpl_name = 'acp_thanks';
		$this->page_title = $display_vars['title'];

		$template->assign_vars([
			'L_TITLE'			=> $language->lang($display_vars['title']),
			'L_TITLE_EXPLAIN'	=> $language->lang($display_vars['title'] . '_EXPLAIN'),

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action,
			]
		);

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', [
					'S_LEGEND'		=> true,
					'LEGEND'		=> $language->lang($vars),
					]
				);

				continue;
			}
			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = $language->lang($vars['lang_explain']);
			}
			else if ($vars['explain'])
			{
				$l_explain = $language->lang($vars['lang'] . '_EXPLAIN');
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', [
				'KEY'			=> $config_key,
				'TITLE'			=> $language->lang($vars['lang']),
				'S_EXPLAIN'		=> $vars['explain'],
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> $content,
				]
			);

			unset($display_vars['vars'][$config_key]);
		}
	}
}
