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

class acp_thanks_info
{
	function module()
	{
		return [
			'filename'	=> '\gfksx\thanksforposts\acp\acp_thanks_module',
			'title'		=> 'ACP_THANKS_SETTINGS',
			'version'	=> '2.0.7',
			'modes'		=> [
				'thanks'	=> ['title' => 'ACP_THANKS_SETTINGS', 'auth' => 'ext_gfksx/thanksforposts && acl_a_board', 'cat' => ['ACP_THANKS']],
			],
		];
	}
}
