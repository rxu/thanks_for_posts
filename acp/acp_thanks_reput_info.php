<?php
/**
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: acp_thanks_reput.php,v 135 2012-10-10 10:02:51 Палыч $
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\ThanksForPosts\acp;

class acp_thanks_reput_info
{
	function module()
	{
		return array(
			'filename'	=> '\gfksx\ThanksForPosts\acp\acp_thanks_reput_module',
			'title'		=> 'ACP_THANKS_REPUT_SETTINGS',
			'version'	=> '1.3.4',
			'modes'		=> array(
				'thanks'			=> array('title' => 'ACP_THANKS_REPUT_SETTINGS', 'auth' => 'ext_gfksx/ThanksForPosts && acl_a_board', 'cat' => array('ACP_THANKS')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
