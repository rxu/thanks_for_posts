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

class v_2_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.0', '>=');
	}

	static public function depends_on()
	{
			return ['\gfksx\thanksforposts\migrations\v_1_3_4'];
	}

	public function update_data()
	{
		// Remove phpBB 3.0 Thanks for posts ACP modules
		$remove_modules = [
				['module.remove', ['acp', 'ACP_THANKS', [
						'module_basename'	=> 'thanks',
						'module_langname'	=> 'ACP_THANKS_SETTINGS',
						'module_mode'		=> 'thanks',
						'module_auth'		=> 'acl_a_board',
				]]],
				['module.remove', ['acp', 'ACP_THANKS', [
						'module_basename'	=> 'thanks_refresh',
						'module_langname'	=> 'ACP_THANKS_REFRESH',
						'module_mode'		=> 'thanks',
						'module_auth'		=> 'acl_a_board',
				]]],
				['module.remove', ['acp', 'ACP_THANKS', [
						'module_basename'	=> 'thanks_truncate',
						'module_langname'	=> 'ACP_THANKS_TRUNCATE',
						'module_mode'		=> 'thanks',
						'module_auth'		=> 'acl_a_board',
				]]],
		];
		if (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.8', '>='))
		{
			$remove_modules = array_merge(
				$remove_modules,
				[
					['module.remove', ['acp', 'ACP_THANKS', [
							'module_basename'	=> 'thanks_reput',
							'module_langname'	=> 'ACP_THANKS_REPUT_SETTINGS',
							'module_mode'		=> 'thanks',
							'module_auth'		=> 'acl_a_board',
					]]],
				]
			);
		}
		$remove_modules = array_merge(
			$remove_modules,
			[
				['module.remove', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_THANKS']],
			]
		);

		// Add ACP modules
		$add_modules = [
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_THANKS']],
			['module.add', ['acp', 'ACP_THANKS', [
					'module_basename'	=> '\gfksx\thanksforposts\acp\acp_thanks_module',
					'module_langname'	=> 'ACP_THANKS_SETTINGS',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanksforposts && acl_a_board',
			]]],
			['module.add', ['acp', 'ACP_THANKS', [
					'module_basename'	=> '\gfksx\thanksforposts\acp\acp_thanks_refresh_module',
					'module_langname'	=> 'ACP_THANKS_REFRESH',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanksforposts && acl_a_board',
			]]],
			['module.add', ['acp', 'ACP_THANKS', [
					'module_basename'	=> '\gfksx\thanksforposts\acp\acp_thanks_truncate_module',
					'module_langname'	=> 'ACP_THANKS_TRUNCATE',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanksforposts && acl_a_board',
			]]],
			['module.add', ['acp', 'ACP_THANKS', [
					'module_basename'	=> '\gfksx\thanksforposts\acp\acp_thanks_reput_module',
					'module_langname'	=> 'ACP_THANKS_REPUT_SETTINGS',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanksforposts && acl_a_board',
			]]],
		];

		// Update config values
		$update_config =  [
			// Remove phpBB 3.0 Thanks for posts MOD config entry
			['config.remove', ['thanks_mod_version']],
		];

		return (isset($this->config['thanks_mod_version']) && version_compare($this->config['thanks_mod_version'], '1.2.7', '>=')) ?
			array_merge($remove_modules, $add_modules, $update_config) : array_merge($add_modules, $update_config);
	}
}
