<?php
/**
 *
 * Thanks for posts extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, rxu, www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace gfksx\thanksforposts\tests\functional;

/**
 * @group functional
 */
class acp_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('gfksx/thanksforposts');
	}

	public function test_update_counters_module()
	{
		$this->login();
		$this->admin_login();

		$this->add_lang_ext('gfksx/thanksforposts', 'info_acp_thanks');

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_refresh_module&mode=thanks");
		$this->assertStringContainsString($this->lang('WARNING'), $crawler->filter('div[class="errorbox"] > h3')->text());
		$this->assertStringContainsString('This can take a few minutes to complete. All incorrect thanks entries will be deleted!', $crawler->filter('div[class="errorbox"] > p')->text());

		$form = $crawler->selectButton('Refresh')->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('CONFIRM'), $crawler->filter('fieldset > h1')->text());

		$form = $crawler->selectButton('Yes')->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('NOTIFY'), $crawler->filter('div[class="successbox"] > h3')->text());
		$this->assertStringContainsString($this->lang('THANKS_REFRESHED_MSG'), $crawler->filter('div[class="successbox"] > p')->text());
	}

	public function test_clear_list_of_thanks_module()
	{
		$this->login();
		$this->admin_login();

		$this->add_lang_ext('gfksx/thanksforposts', 'info_acp_thanks');

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_truncate_module&mode=thanks");
		$this->assertStringContainsString($this->lang('WARNING'), $crawler->filter('div[class="errorbox"] > h3')->text());
		$this->assertStringContainsString('This procedure completely clears all thanks counters (removes all issued thanks).', $crawler->filter('div[class="errorbox"] > p')->text());

		$form = $crawler->selectButton('Clear')->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('ACP_THANKS_TRUNCATE'), $crawler->filter('fieldset > h1')->text());

		$form = $crawler->selectButton('Yes')->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('NOTIFY'), $crawler->filter('div[class="successbox"] > h3')->text());
		$this->assertStringContainsString($this->lang('TRUNCATE_THANKS_MSG'), $crawler->filter('div[class="successbox"] > p')->text());
	}
}
