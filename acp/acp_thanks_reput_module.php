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
class acp_thanks_reput_module
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

		/** @var string $phpbb_root_path phpbb_root_path */
		$phpbb_root_path = $phpbb_container->getParameter('core.root_path');

		$submit = $request->is_set_post('submit');

		$form_key = 'acp_thanks_reput';
		add_form_key($form_key);

		/**
		 *	Validation types are:
		 *		string, int, bool,
		 *		script_path (absolute path in url - beginning with / and no trailing slash),
		 *		rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
		 */
		$display_vars = [
			'title'	=> 'ACP_THANKS_REPUT_SETTINGS',
			'vars'	=> [
				'legend'					=> 'GENERAL_OPTIONS',
				'thanks_post_reput_view'	=> ['lang' => 'THANKS_POST_REPUT_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_topic_reput_view'	=> ['lang' => 'THANKS_TOPIC_REPUT_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_forum_reput_view'	=> ['lang' => 'THANKS_FORUM_REPUT_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_number_digits'		=> ['lang' => 'THANKS_NUMBER_DIGITS', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true],
				'thanks_number_row_reput'	=> ['lang' => 'THANKS_NUMBER_ROW_REPUT', 'validate' => 'int:0', 'type' => 'text:4:6', 'explain' => true],
				'legend1'					=> 'GRAPHIC_OPTIONS',
				'thanks_reput_graphic'		=> ['lang' => 'THANKS_REPUT_GRAPHIC', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'thanks_reput_height'		=> ['lang' => 'THANKS_REPUT_HEIGHT', 'validate' => 'int:1:25', 'type' => 'text:4:6', 'explain' => true, 'append' => ' ' . $language->lang('PIXEL')],
				'thanks_reput_level'		=> ['lang' => 'THANKS_REPUT_LEVEL', 'validate' => 'int:4:13', 'type' => 'text:4:4', 'explain' => true],
				'thanks_reput_image'		=> ['lang' => 'THANKS_REPUT_IMAGE', 'validate' => 'string', 'type' => 'text:25:255', 'explain' => true, 'append' => '<br /><img src="' . (($config['thanks_reput_image']) ? $phpbb_root_path . $config['thanks_reput_image'] : '') . '" alt="' . $language->lang('THANKS_REPUT_IMAGE') . '"/>'],
				'thanks_reput_image_back'	=> ['lang' => 'THANKS_REPUT_IMAGE_BACK', 'validate' => 'string', 'type' => 'text:25:255', 'explain' => true, 'append' => '<br /><img src="' . (($config['thanks_reput_image_back']) ? $phpbb_root_path . $config['thanks_reput_image_back'] : '') . '" alt="' . $language->lang('THANKS_REPUT_IMAGE_BACK') . '"/>'],
				'legend2'					=> 'GRAPHIC_DEFAULT',
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
		if (!empty($cfg_array['thanks_reput_image']) && !file_exists($phpbb_root_path . $config['thanks_reput_image']))
		{
			$error[] = $language->lang('THANKS_REPUT_IMAGE_NOEXIST');
		}
		if (!empty($cfg_array['thanks_reput_image_back']) && !file_exists($phpbb_root_path . $config['thanks_reput_image_back']))
		{
			$error[] = $language->lang('THANKS_REPUT_IMAGE_BACK_NOEXIST');
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

		$this->tpl_name = 'acp_thanks_reput';
		$this->page_title = $display_vars['title'];

		$template->assign_vars([
			'L_TITLE'					=> $language->lang($display_vars['title']),
			'L_TITLE_EXPLAIN'			=> $language->lang($display_vars['title'] . '_EXPLAIN'),
			'GRAPHIC_STAR_BLUE_EXAMPLE' => $phpbb_root_path . $language->lang('GRAPHIC_STAR_BLUE'),
			'GRAPHIC_STAR_GOLD_EXAMPLE' => $phpbb_root_path . $language->lang('GRAPHIC_STAR_GOLD'),
			'GRAPHIC_STAR_BACK_EXAMPLE' => $phpbb_root_path . $language->lang('GRAPHIC_STAR_BACK'),
			'GRAPHIC_BLOCK_RED_EXAMPLE' => $phpbb_root_path . $language->lang('GRAPHIC_BLOCK_RED'),
			'GRAPHIC_BLOCK_BACK_EXAMPLE'=> $phpbb_root_path . $language->lang('GRAPHIC_BLOCK_BACK'),
			'S_ERROR'					=> (sizeof($error)) ? true : false,
			'ERROR_MSG'					=> implode('<br />', $error),
			'U_ACTION'					=> $this->u_action
		]);

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
					'S_LEGEND'	=> true,
					'LEGEND'	=> $language->lang($vars),
				]);

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
			]);

			unset($display_vars['vars'][$config_key]);
		}
	}
}
