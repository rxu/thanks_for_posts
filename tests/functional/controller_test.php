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
class controller_test extends \phpbb_functional_test_case
{
	public function test_thanklist()
	{
		$this->create_user('user1');
		$this->add_user_group('ADMINISTRATORS', ['user1']);
		$this->login('user1');

		// Create 2 posts for user1
		$topic = $this->create_topic(2, 'Test Topic 1', 'This is a first test topic posted by user1.');
		$post = $this->create_post(2, $topic['topic_id'], 'Re: Test Topic 1', 'This is a first reply to the topic posted by user1.');

		// Create a thank by user1 for admin's post
		$crawler = self::request('GET', "viewtopic.php?f=2&t=1&sid={$this->sid}");
		$thanks_link = str_replace('./', '', html_entity_decode($crawler->filter('#lnk_thanks_post1')->attr('href')));
		self::request('GET', $thanks_link);

		// Logout user1
		$this->logout();
		// Login as admin
		$this->login();

		// Create a thank for every user1's post
		$crawler = self::request('GET', "viewtopic.php?f=2&t={$topic['topic_id']}&sid={$this->sid}");
		$thanks_link1 = str_replace('./', '', html_entity_decode($crawler->filter('#lnk_thanks_post' . ((int) $post['post_id'] - 1))->attr('href')));
		self::request('GET', $thanks_link1);
		$thanks_link2 = str_replace('./', '', html_entity_decode($crawler->filter('#lnk_thanks_post' . $post['post_id'])->attr('href')));
		self::request('GET', $thanks_link2);

		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');

		// At this point:
		// admin has: received thanks - 1, given thanks - 2
		// user1 has: received thanks - 2, given thanks - 1
		$crawler = self::request('GET', 'app.php/thankslist');
		$this->assertStringContainsString($this->lang('THANKS_USER'), $crawler->filter('h2')->text());
		$this->assertStringContainsString('2 users', $crawler->filter('div[class="pagination"]')->text());
		$this->assertStringContainsString('user1', $crawler->filter('a[class="username"]')->text());
		$this->assertStringContainsString('admin', $crawler->filter('a[class="username-coloured"]')->text());
	}

	public function test_thanklist_sorting()
	{
		$this->login();

		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');

		// Default sorting: username desc
		$crawler = self::request('GET', 'app.php/thankslist');
		$this->assertStringContainsString('user1', $crawler->filter('tbody')->filter('tr')->eq(0)->filter('td > a')->text());
		$this->assertStringContainsString('admin', $crawler->filter('tbody')->filter('tr')->eq(1)->filter('td > a')->text());

		// Sorting by `Has thanked` desc
		$crawler = self::request('GET', 'app.php/thankslist?sk=f&sd=d');
		$this->assertStringContainsString('admin', $crawler->filter('tbody')->filter('tr')->eq(0)->filter('td > a')->text());
		$this->assertStringContainsString('user1', $crawler->filter('tbody')->filter('tr')->eq(1)->filter('td > a')->text());

		// Sorting by `Has thanked` asc
		$crawler = self::request('GET', 'app.php/thankslist?sk=f&sd=a');
		$this->assertStringContainsString('user1', $crawler->filter('tbody')->filter('tr')->eq(0)->filter('td > a')->text());
		$this->assertStringContainsString('admin', $crawler->filter('tbody')->filter('tr')->eq(1)->filter('td > a')->text());

		// Sorting by `Been thanked` desc
		$crawler = self::request('GET', 'app.php/thankslist?sk=e&sd=d');
		$this->assertStringContainsString('user1', $crawler->filter('tbody')->filter('tr')->eq(0)->filter('td > a')->text());
		$this->assertStringContainsString('admin', $crawler->filter('tbody')->filter('tr')->eq(1)->filter('td > a')->text());

		// Sorting by `Been thanked` asc
		$crawler = self::request('GET', 'app.php/thankslist?sk=e&sd=a');
		$this->assertStringContainsString('admin', $crawler->filter('tbody')->filter('tr')->eq(0)->filter('td > a')->text());
		$this->assertStringContainsString('user1', $crawler->filter('tbody')->filter('tr')->eq(1)->filter('td > a')->text());
	}

	public function test_toplist()
	{
		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');

		$this->login();

		$this->admin_login();
		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_reput_module&mode=thanks");
		$form = $crawler->selectButton('Submit')->form();
		$values = $form->getValues();
		// Enable forum rating rating options (post and topic ones are enabled by default)
		$values['config[thanks_forum_reput_view]'] = true;
		$form->setValues($values);
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('CONFIG_UPDATED'), $crawler->filter('.successbox')->text());

		$crawler = self::request('GET', 'app.php/toplist');
		$this->assertStringContainsString($this->lang('TOPLIST'), $crawler->filter('h2')->text());
		$this->assertStringContainsString($this->lang('RATING_TOP_POST'), $crawler->filter('h3')->eq(0)->text());
		$this->assertStringContainsString($this->lang('RATING_TOP_TOPIC'), $crawler->filter('h3')->eq(1)->text());
		$this->assertStringContainsString($this->lang('RATING_TOP_FORUM'), $crawler->filter('h3')->eq(2)->text());

		$this->assertStringContainsString('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_back.gif)', $crawler->filter('dd[class="lastpost"] > span > span')->eq(0)->attr('style'));
		$this->assertStringContainsString('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif)', $crawler->filter('dd[class="lastpost"] > span > span > span')->eq(0)->attr('style'));
		$this->assertStringContainsString('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_back.gif)', $crawler->filter('dd[class="lastpost"] > span > span')->eq(1)->attr('style'));
		$this->assertStringContainsString('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif)', $crawler->filter('dd[class="lastpost"] > span > span > span')->eq(1)->attr('style'));
		$this->assertStringContainsString('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_back.gif)', $crawler->filter('dd[class="lastpost"] > span > span')->eq(2)->attr('style'));
		$this->assertStringContainsString('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif)', $crawler->filter('dd[class="lastpost"] > span > span > span')->eq(2)->attr('style'));

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_reput_module&mode=thanks");
		$form = $crawler->selectButton('Submit')->form();
		$values = $form->getValues();
		// Disable all rating options
		$values['config[thanks_post_reput_view]'] = false;
		$values['config[thanks_topic_reput_view]'] = false;
		$values['config[thanks_forum_reput_view]'] = false;
		$form->setValues($values);
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('CONFIG_UPDATED'), $crawler->filter('.successbox')->text());

		$crawler = self::request('GET', 'app.php/toplist');
		$this->assertStringContainsString($this->lang('RATING_VIEW_TOPLIST_NO'), $crawler->filter('html')->text());
		$this->assertStringNotContainsString($this->lang('TOPLIST'), $crawler->filter('ul[class="dropdown-contents"]')->text());
		$this->assertCount(0, $crawler->filter('.fa-star-o'));
	}
}
