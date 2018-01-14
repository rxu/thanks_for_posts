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
class controller_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('gfksx/thanksforposts');
	}

	public function test_thanklist()
	{
		$this->create_user('user1');
		$this->add_user_group('ADMINISTRATORS', array('user1'));
		$this->login('user1');

		// Create a post
		$topic = $this->create_topic(2, 'Test Topic 1', 'This is a first test topic posted by the testing framework.');
		$post = $this->create_post(2, $topic['topic_id'], 'Re: Test Topic 1', 'This is a reply to the first test topic posted by the testing framework.');

		// Logout user1
		$this->logout();
		// Login as admin
		$this->login();

		// Create a thank for the post
		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}&p={$post['post_id']}#p{$post['post_id']}");
		$thanks_link = str_replace('./', '', html_entity_decode($crawler->filter('#lnk_thanks_post' . $post['post_id'])->attr('href')));
		$crawler = self::request('GET', $thanks_link);

		$this->add_lang_ext('gfksx/thanksforposts', 'thanks_mod');

		$crawler = self::request('GET', 'app.php/thankslist');
		$this->assertContains($this->lang('THANKS_USER'), $crawler->filter('h2')->text());
		$this->assertContains('2 users', $crawler->filter('div[class="pagination"]')->text());
		$this->assertContains('user1', $crawler->filter('a[class="username"]')->text());
		$this->assertContains('admin', $crawler->filter('a[class="username-coloured"]')->text());
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
		$this->assertContains($this->lang('CONFIG_UPDATED'), $crawler->filter('.successbox')->text());

		$crawler = self::request('GET', 'app.php/toplist');
		$this->assertContains($this->lang('TOPLIST'), $crawler->filter('h2')->text());
		$this->assertContains($this->lang('RATING_TOP_POST'), $crawler->filter('h3')->eq(0)->text());
		$this->assertContains($this->lang('RATING_TOP_TOPIC'), $crawler->filter('h3')->eq(1)->text());
		$this->assertContains($this->lang('RATING_TOP_FORUM'), $crawler->filter('h3')->eq(2)->text());

		$this->assertContains('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_back.gif)', $crawler->filter('dd[class="lastpost"] > span > span')->eq(0)->attr('style'));
		$this->assertContains('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif)', $crawler->filter('dd[class="lastpost"] > span > span > span')->eq(0)->attr('style'));
		$this->assertContains('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_back.gif)', $crawler->filter('dd[class="lastpost"] > span > span')->eq(1)->attr('style'));
		$this->assertContains('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif)', $crawler->filter('dd[class="lastpost"] > span > span > span')->eq(1)->attr('style'));
		$this->assertContains('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_back.gif)', $crawler->filter('dd[class="lastpost"] > span > span')->eq(2)->attr('style'));
		$this->assertContains('background: url(http://localhost/ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif)', $crawler->filter('dd[class="lastpost"] > span > span > span')->eq(2)->attr('style'));

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-gfksx-thanksforposts-acp-acp_thanks_reput_module&mode=thanks");
		$form = $crawler->selectButton('Submit')->form();
		$values = $form->getValues();
		// Disable all rating options
		$values['config[thanks_post_reput_view]'] = false;
		$values['config[thanks_topic_reput_view]'] = false;
		$values['config[thanks_forum_reput_view]'] = false;
		$form->setValues($values);
		$crawler = self::submit($form);
		$this->assertContains($this->lang('CONFIG_UPDATED'), $crawler->filter('.successbox')->text());

		$crawler = self::request('GET', 'app.php/toplist');
		$this->assertContains($this->lang('RATING_VIEW_TOPLIST_NO'), $crawler->filter('html')->text());
		$this->assertNotContains($this->lang('TOPLIST'), $crawler->filter('ul[class="dropdown-contents"]')->text());
		$this->assertCount(0, $crawler->filter('.fa-star-o'));
	}
}
