<?php
/**
*
* Thanks For Posts extension for the phpBB Forum Software package.
*
* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACP_DELTHANKS'						=> 'Deleted recorded thanks',
	'ACP_POSTS'							=> 'סה"כ הודעות',
	'ACP_POSTSEND'						=> 'Remaining posts with thanks',
	'ACP_POSTSTHANKS'					=> 'סה"כ הודעות עם תודה',
	'ACP_THANKS'						=> 'Thanks for posts',
	'ACP_THANKS_MOD_VER'				=> 'Extension version: ',
	'ACP_THANKS_TRUNCATE'				=> 'Clear the list of thanks',
	'ACP_ALLTHANKS'						=> 'Thanks taken into account',
	'ACP_THANKSEND'						=> 'Thanks remaining to take into account',
	'ACP_THANKS_REPUT'					=> 'Rating Options',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Rating Options',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Set the default settings for the rating of posts, topics and forums, based on the thanks system here. <br /> Subject (post, topic or forum) which has the largest total number of thanks is given 100% rating.',
	'ACP_THANKS_SETTINGS'				=> 'Thanks Settings',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'ניתן לשנות כאן את הגדרות ברירת המחדל של תודות על הודעות.',
	'ACP_THANKS_REFRESH'				=> 'Update counters',
	'ACP_UPDATETHANKS'					=> 'Updated recorded thanks',
	'ACP_USERSEND'						=> 'Remaining users who thanked',
	'ACP_USERSTHANKS'					=> 'סה"כ משתמשים שהודו',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Images',
	'GRAPHIC_OPTIONS'					=> 'אפשרויות גרפיקה',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'To thank for the post',
	'IMG_REMOVETHANKS'					=> 'Cancel thanks',

	'LOG_CONFIG_THANKS'					=> 'Updated configuration of Thanks for post Extension',

	'REFRESH'							=> 'רענן',
	'REMOVE_THANKS'						=> 'הסרת תודה',
	'REMOVE_THANKS_EXPLAIN'				=> 'משתמשים יכולים להסיר תודה אם אפשרות זו זמינה.',

	'STEPR'								=> ' - executed, step %s',

	'THANKS_COUNTERS_VIEW'				=> 'מוני תודה',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'If enabled, the block information about the author will show the number of issued/received thanks.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'הצג דירוג פורומים',
	'THANKS_GLOBAL_POST'				=> 'תודה בהודעות גלובליות',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'If enabled, Thanks in Global Announce enabled.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'אם אפשרות זו מופעלת, דירוג הפורום יוצג ברשימת הפורומים.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'אם אפשרות זו מופעלת, דירוג הפורום יוצג ברשימת הפורומים.',
	'THANKS_INFO_PAGE'					=> 'הודעות אינפורמטיביות',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'אם אפשרות זו מופעלת, הודעות אינפורמטיביות יוצגו לאחר נתינה / הסרה של תודה על הודעה..',
	'THANKS_NOTICE_ON'					=> 'Notices are available',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'If enabled, notice are available and the user can configure the notification via your profile.',
	'THANKS_NUMBER'						=> 'מספר התודות ברשימה המוצגת בפרופיל המשתמש',
	'THANKS_NUMBER_EXPLAIN'				=> 'ציין את מספר התודות המרבי שיוצג בעת הצגת פרופיל המשתמש. <br /> <strong> זכור כי תורגש איטיות אם ערך זה מוגדר מעל 250. </strong>',
	'THANKS_NUMBER_DIGITS'				=> 'The number of decimal places for rating',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Specify the number of decimal places for the rating value.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'The number of rows in the toplist for rating',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Specify the number of rows to display in posts, topics and forums rating toplist.',
	'THANKS_NUMBER_POST'				=> 'מספר התודות המוצגות בהודעה',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'המספר המרבי של התודות המוצגים בעת הצגת הודעה. <br /> <strong> זכור כי תורגש איטיות אם ערך זה מוגדר מעל 250. </strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'רק עבור ההודעה הראשונה בנושא',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'אם אפשרות זו מופעלת, משתמשים יכולים להודות רק על ההודעה הראשונה בנושא.',
	'THANKS_POST_REPUT_VIEW'			=> 'הצג דירוג עבור הודעות',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'אם אפשרות זו מופעלת, דירוג ההודעות יוצג בעת הצגת הנושא.',
	'THANKS_POSTLIST_VIEW'				=> 'רשימת התודות בתוך הנושא',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'אם אפשרות זו מופעלת, תוצג רשימת המשתמשים שהודו למחבר על הודעתו. <br/> הערה: שים לב כי אפשרות זו פעילה רק אם מנהל המערכת איפשר את ההרשאה לתת תודה על הודעה.',
	'THANKS_PROFILELIST_VIEW'			=> 'רשימת התודות בפרופיל המשתמש',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'אם אפשרות זו מופעלת, תוצג רשימה מלאה של תודות, הכוללת את מספר התודות וההודעות שבהן הודה המשתמש.',
	'THANKS_REFRESH'					=> 'Update thanks counters',
	'THANKS_REFRESH_EXPLAIN'			=> 'Here you can update thanks counters after a mass removal of posts/topics/users, splitting/merging of topics, setting/removing Global Announcement, enabling/disabling option "Only for the first post in the topic", changing posts owners and etc. This may take some time.<br /><strong>Important: To work correctly, the refresh counters function needs MySQL version 4.1 or later!<br />Attention!<br /> - Refreshing will erase all thanks for the guest posts!<br /> - Refreshing will erase all thanks for the Global Announcements, if the option `Thanks in Global Announcements` is OFF!<br /> - Refreshing will erase all thanks for all positions excepting the first in the topic, if the option `Only for the first post in the topic` is ON!</strong>',
	'THANKS_REFRESH_MSG'				=> 'פעולה זו עשויה להימשך מספר דקות. כל הערכי התודות השגויים יימחקו! <br /> הפעולה אינה הפיכה!',
	'THANKS_REFRESHED_MSG'				=> 'Counters updated',
	'THANKS_REPUT_GRAPHIC'				=> 'תצוגה גרפית של הדירוג',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'אם מאופשר, ערך הדירוג יוצג באופן גרפי, תוך שימוש בתמונות שבהמשך.',
	'THANKS_REPUT_HEIGHT'				=> 'גובה גרפיקה',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Specify the height of the slider for the ranking in pixels. <br /> <strong> Attention! In order to display correctly, you should indicate the height equal to the height of the following image! </strong>',
	'THANKS_REPUT_IMAGE'				=> 'התמונה הראשית עבור המחוון',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Graphics Preview</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'The image itself and the path to the image can be seen here. Image size is 15x15 pixels. <br /> You can draw your own images for the foreground and background. <strong>The height and width of the image should be the same to ensure the correct construction of the graphical scale.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'The path - relative to the root folder of phpBB - to the graphic scale image.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'The main image for the graphical scale not found.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'תמונת הרקע עבור המחוון',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'The path - relative to the root phpBB install folder - to the graphic scale background image.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'The background image for the graphic scale not found.',
	'THANKS_REPUT_LEVEL'				=> 'Number of images in a graphic scale',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'The maximum number of images corresponding to 100% of the value of the rating scale in the graphic.',
	'THANKS_TIME_VIEW'					=> 'זמן נתינת התודה',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'אם מאופשר, ההודעה תציג את זמן נתינת התודה.',
	'THANKS_TOP_NUMBER'					=> 'מספר המשתמשים ברשימת הכי מומלצים',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'ציין את מספר המשתמשים שיוצגו באינדקס רשימת הכי מומלצים. 0 - כיבוי הצגת רשימת הכי מומלצים.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'הצג דירוג נושאים',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'אם אפשרות זו מופעלת, דירוג הנושא יוצג בעת הצגת הפורום.',
	'TRUNCATE'							=> 'נקה',
	'TRUNCATE_THANKS'					=> 'נקה את רשימת התודות',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'הליך זה מנקה לחלוטין את כל מוני התודה (מסיר את כל התודות שפורסמו). <br /> פעולה זו אינה הפיכה!',
	'TRUNCATE_THANKS_MSG'				=> 'Thanks counters cleared.',
	'REFRESH_THANKS_CONFIRM'			=> 'Do you really want to refresh the Thanks counters?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Do you really want to clear the Thanks counters?',
	'TRUNCATE_NO_THANKS'				=> 'Operation canceled',
	'ALLOW_THANKS_PM_ON'				=> 'Notify me PM if someone thanks my post',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Notify me e-mail if someone thanks my post',
));
