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
class thanks_acp_test extends \phpbb_functional_test_case
{
	public function test_update_counters_module()
	{
		$this->login();
		$this->admin_login();

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_refresh_module&mode=thanks");
		$this->assertContains('Warning', $crawler->filter('div[class="errorbox"] > h3')->text());
		$this->assertContains('This can take a few minutes to complete. All incorrect thanks entries will be deleted!', $crawler->filter('div[class="errorbox"] > p')->text());

		$form = $crawler->selectButton('Refresh')->form();
		$crawler = self::submit($form);
		$this->assertContains($this->lang('CONFIRM'), $crawler->filter('fieldset > h1')->text());

		$form = $crawler->selectButton('Yes')->form();
		$crawler = self::submit($form);
		$this->assertContains('Notification', $crawler->filter('div[class="successbox"] > h3')->text());
		$this->assertContains('Counters updated', $crawler->filter('div[class="successbox"] > p')->text());
	}

	public function test_clear_list_of_thanks_module()
	{
		$this->login();
		$this->admin_login();

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_truncate_module&mode=thanks");
		$this->assertContains('Warning', $crawler->filter('div[class="errorbox"] > h3')->text());
		$this->assertContains('This procedure completely clears all thanks counters (removes all issued thanks)', $crawler->filter('div[class="errorbox"] > p')->text());

		$form = $crawler->selectButton('Clear')->form();
		$crawler = self::submit($form);
		$this->assertContains('Clear the list of thanks', $crawler->filter('fieldset > h1')->text());

		$form = $crawler->selectButton('Yes')->form();
		$crawler = self::submit($form);
		$this->assertContains('Notification', $crawler->filter('div[class="successbox"] > h3')->text());
		$this->assertContains('Thanks counters cleared.', $crawler->filter('div[class="successbox"] > p')->text());
	}
}
