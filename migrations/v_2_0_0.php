<?php
/**
*
* @package thanks_for_posts
* @copyright (c) 2014 gfksx
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\migrations;

class v_2_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.0', '>=');
	}

	static public function depends_on()
	{
			return array('\ext\gfksx\thanks_for_posts\migrations\1.3.4');
	}

	public function update_schema()
	{
		return 	array(
		);
	}

	public function revert_schema()
	{
		return 	array(
		);
	}

	public function update_data()
	{
		return array(

			// Current version
			array('config.add', array('thanks_for_posts_version', '2.0.0')),
			array('if', array(
				(isset($this->config['thanks_for_posts_version']) && version_compare($this->config['thanks_for_posts_version'], '2.0.0', '<')),
				array('config.update', array('thanks_for_posts_version', '2.0.0')),
			)),

			// Remove phpBB 3.0 Thanks for posts MOD config entry
			array('if', array(
				(isset($this->config['thanks_mod_version'])),
				array('config.remove', array('thanks_mod_version')),
			)),

			// Add ACP modules
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_THANKS')),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_module',
					'module_langname'	=> 'ACP_THANKS_SETTINGS',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_refresh_module',
					'module_langname'	=> 'ACP_THANKS_REFRESH',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_truncate_module',
					'module_langname'	=> 'ACP_THANKS_TRUNCATE',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_THANKS', array(
					'module_basename'	=> '\gfksx\thanks_for_posts\acp\acp_thanks_reput_module',
					'module_langname'	=> 'ACP_THANKS_REPUT_SETTINGS',
					'module_mode'		=> 'thanks',
					'module_auth'		=> 'ext_gfksx/thanks_for_posts && acl_a_board',
			))),
		);
	}
}
