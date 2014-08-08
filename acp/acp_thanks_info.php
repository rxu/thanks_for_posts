<?php
/**
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: acp_thanks.php,v 135 2012-10-10 10:02:51 Палыч$
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\ThanksForPosts\acp;

class acp_thanks_info
{
	function module()
	{
		return array(
			'filename'	=> '\gfksx\ThanksForPosts\acp\acp_thanks_module',
			'title'		=> 'ACP_THANKS_SETTINGS',
			'version'	=> '1.3.4',
			'modes'		=> array(
				'thanks'			=> array('title' => 'ACP_THANKS_SETTINGS', 'auth' => 'ext_gfksx/ThanksForPosts && acl_a_board', 'cat' => array('ACP_THANKS')),
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

?>