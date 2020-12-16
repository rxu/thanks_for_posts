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

namespace gfksx\thanksforposts\tests\functional;

/**
 * @group functional
 */
class thanking_test extends \phpbb_functional_test_case
{
	public function test_toplist_on_index()
	{
		$this->login();
		$this->admin_login();

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_module&mode=thanks");
		$form = $crawler->selectButton('Submit')->form();
		$values = $form->getValues();
		// Specify the number of users to show in the toplist on index page
		$values['config[thanks_top_number]'] = 5;
		$form->setValues($values);
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('CONFIG_UPDATED'), $crawler->filter('.successbox')->text());

		// Now test toplist on index exists
		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');
		$crawler = self::request('GET', "index.php?sid={$this->sid}");
		$this->assertStringContainsString($this->lang('REPUT_TOPLIST', 5), $crawler->filter('div[class="stat-block thanks-list"]')->text());
	}

	public function test_profile_info()
	{
		$this->login();

		// Test if user profile info displayed
		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');
		$crawler = self::request('GET', "memberlist.php?mode=viewprofile&un=user1");

		$this->assertStringContainsString($this->lang('GRATITUDES'), $crawler->filter('div[class="panel bg1"] > div > h3')->text());
		$this->assertStringContainsString(html_entity_decode($this->lang('RECEIVED')) . ': 2 times', $crawler->filter('div[class="panel bg1"] > div > div[class="column2"] > dl > dt')->text());
		$this->assertStringContainsString($this->lang('THANKS_LIST'), $crawler->filter('div[class="panel bg1"] > div > div[class="column2"] > dl > dd > a')->text());
		$this->assertStringContainsString('./memberlist.php?mode=viewprofile&u=2', $crawler->filter('div[id="show_thanked"] > span > a')->attr('href'));
		$this->assertStringContainsString('admin', $crawler->filter('div[id="show_thanked"] > span > a')->text());
		$this->assertStringContainsString($this->lang('FOR_MESSAGE'), $crawler->filter('div[id="show_thanked"] > span > a')->eq(1)->text());
	}

	public function test_remove_thank()
	{
		$this->login();

		$this->get_db();
		$sql = 'SELECT post_id, topic_id FROM ' . POSTS_TABLE . '
			ORDER BY post_id DESC';
		$result = $this->db->sql_query_limit($sql, 1);
		$post = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');

		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}");
		$thanks_button_title = $crawler->filter('a[id="lnk_thanks_post' . $post['post_id'] . '"]')->attr('title');
		$thanks_link = str_replace('./', '', html_entity_decode($crawler->filter('a[id="lnk_thanks_post' . $post['post_id'] . '"]')->attr('href')));
		$this->assertStringContainsString($this->lang('THANK_TEXT_1'), $crawler->filter('div[id="list_thanks' . $post['post_id'] . '"]')->text());
		$this->assertEquals($this->lang('REMOVE_THANKS') . 'user1', $thanks_button_title);

		// Test thanking process
		$crawler = self::request('GET', $thanks_link);
		$this->assertStringContainsString($this->lang('REMOVE_THANKS'), $crawler->filter('h2')->text());

		$form = $crawler->selectButton('Yes')->form();
		$crawler = self::submit($form);

		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}&p={$post['post_id']}#p{$post['post_id']}");

		$thanks_button_title = $crawler->filter('#lnk_thanks_post' . $post['post_id'])->attr('title');
		$this->assertEquals($this->lang('THANK_POST') . 'user1', $thanks_button_title);
	}
}
