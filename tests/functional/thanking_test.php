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
	public function test_thanking()
	{
		// user1 account, its post and a thank should have been created in controller_test.php

		$this->login();

		$this->get_db;
		$sql = 'SELECT post_id, topic_id FROM ' . POSTS_TABLE . '
			ORDER BY post_id DESC LIMIT 1';
		$result = $this->db->sql_query($sql);
		$post = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// Now test thanks button exist
		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}&p={$post['post_id']}#p{$post['post_id']}");
		$thanks_button_title = $crawler->filter('a[id="lnk_thanks_post' . $post['post_id'] . '"]')->attr('title');
		$thanks_link = str_replace('./', '', html_entity_decode($crawler->filter('a[id="lnk_thanks_post' . $post['post_id'] . '"]')->attr('href')));
		$this->assertContains('These users thanked the author', $crawler->filter('div[id="list_thanks' . $post['post_id'] . '"]')->text());
		$this->assertEquals('Remove your thanks: user1', $thanks_button_title);

		// Test thanking process
		$crawler = self::request('GET', $thanks_link);
		$this->assertContains('Remove your thanks:', $crawler->filter('h2')->text());

		$form = $crawler->selectButton('Yes')->form();
		$crawler = self::submit($form);

		$crawler = self::request('GET', "viewtopic.php?f=2&t={$post['topic_id']}&sid={$this->sid}&p={$post['post_id']}#p{$post['post_id']}");

		$thanks_button_title = $crawler->filter('#lnk_thanks_post' . $post['post_id'])->attr('title');
		$this->assertEquals('Say Thanks to the author of the post: user1', $thanks_button_title);
	}
}
