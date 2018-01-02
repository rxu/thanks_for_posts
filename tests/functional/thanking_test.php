<?php
/**
 *
 * Thanks for posts extension. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, rxu, www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace gfksx\ThanksForPosts\tests\functional;

/**
 * @group functional
 */
class thanking_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('gfksx/ThanksForPosts');
	}

	public function test_thanking()
	{
		$user1_id = $this->create_user('user1');

		$this->add_user_group('ADMINISTRATORS', array('user1'));

		$this->login('user1');

		// Create a topic
		$topic = $this->create_topic(2, 'Test Topic 1', 'This is a first test topic posted by the testing framework.');
		$post = $this->create_post(2, $topic['topic_id'], 'Re: Test Topic 1', 'This is a reply to the first test topic posted by the testing framework.');

		// Logout user1 and login as admin
		$this->logout();
		$this->login();

		// Now test thanks button exist
		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}&p={$post['post_id']}#p{$post['post_id']}");

		$thanks_button_title = $crawler->filter('a[id="lnk_thanks_post' . $post['post_id'] . '"]')->attr('title');
		$thanks_link = html_entity_decode($crawler->filter('#lnk_thanks_post' . $post['post_id'])->attr('href'));
		$this->assertEquals('Say Thanks to the author of the post: user1', $thanks_button_title);

		// Test thanking process
		$crawler = self::request('GET', $thanks_link);
		sleep(10);
		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}&p={$post['post_id']}#p{$post['post_id']}");
		$this->assertContains('These users thanked the author', $crawler->filter('html')->text());

		$thanks_button_title = $crawler->filter('#lnk_thanks_post' . $post['post_id'])->attr('title');
		$this->assertEquals('Remove your thanks: user1', $thanks_button_title);


/*		$form = $crawler->selectButton('Submit')->form();
		$form->setValues(array('message' => 'This is a post which SHOULD BE merged with the previous one.'));
		$crawler = self::submit($form);

		$this->assertContains('Added in', $crawler->filter('html')->text());*/
	}
/*
	public function test_ignore_merging_posts()
	{
		$this->login();

		// Create a topic
		$post = $this->create_topic(2, 'Test Topic 2', 'This is a second test topic posted by the testing framework.');

		// Test the ignore option checkbox is present
		$crawler = self::request('GET', "posting.php?mode=reply&f=2&t={$post['topic_id']}&sid={$this->sid}");
		$this->assertContains('Do not merge with previous post', $crawler->filter('html')->text());

		// Test option to ignore merging posts
		$post2 = $this->create_post(2, $post['topic_id'], 'Re: Test Topic 2', 'This is a post which should NOT be merged with the previous one.', array('posts_merging_option' => true));

		$crawler = self::request('GET', "viewtopic.php?t={$post2['topic_id']}&sid={$this->sid}");
		$this->assertNotContains('Added in', $crawler->filter('html')->text());
	}*/
}
