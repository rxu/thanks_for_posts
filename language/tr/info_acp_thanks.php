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

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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

$lang = array_merge($lang, [
	'ACP_DELTHANKS'						=> 'Kayıtlı teşekkürler silindi',
	'ACP_POSTS'							=> 'Toplam mesaj',
	'ACP_POSTSEND'						=> 'Remaining posts with thanks',
	'ACP_POSTSTHANKS'					=> 'Teşekkür alan toplam mesajlar',
	'ACP_THANKS'						=> 'Mesajlar için teşekkür',
	'ACP_THANKS_MOD_VER'				=> 'Versiyon: ',
	'ACP_THANKS_TRUNCATE'				=> 'Teşekkür listesini temizle',
	'ACP_ALLTHANKS'						=> 'Teşekkürler dikkate alındı',
	'ACP_THANKSEND'						=> 'Dikkate almak için kalan teşekkürler',
	'ACP_THANKS_REPUT'					=> 'Değerlendirme Seçenekleri',
	'ACP_THANKS_REPUT_SETTINGS'			=> 'Değerlendirme Seçenekleri',
	'ACP_THANKS_REPUT_SETTINGS_EXPLAIN'	=> 'Buradaki teşekkür sistemine dayanarak gönderilerin, konuların ve forumların derecelendirmesine ilişkin varsayılan ayarları yapın. <br /> Toplam teşekkür sayısına en çok sahip olan konu (gönderim, konu veya forum) %100 puan alır.',
	'ACP_THANKS_SETTINGS'				=> 'Teşekkür ayarları',
	'ACP_THANKS_SETTINGS_EXPLAIN'		=> 'Varsayılan Mesajlar için teşekkürler ayarları buradan değiştirebilirsiniz.',
	'ACP_THANKS_REFRESH'				=> 'Sayaçları güncelle',
	'ACP_UPDATETHANKS'					=> 'Kayıtlı teşekkürler güncellendi',
	'ACP_USERSEND'						=> 'Teşekkür eden diğer kullanıcılar',
	'ACP_USERSTHANKS'					=> 'Teşekkür edern toplam kullanıcılar',

	'GRAPHIC_BLOCK_BACK'				=> 'ext/gfksx/thanksforposts/images/rating/reput_block_back.gif',
	'GRAPHIC_BLOCK_RED'					=> 'ext/gfksx/thanksforposts/images/rating/reput_block_red.gif',
	'GRAPHIC_DEFAULT'					=> 'Resimler',
	'GRAPHIC_OPTIONS'					=> 'Grafik Seçenekleri',
	'GRAPHIC_STAR_BACK'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_back.gif',
	'GRAPHIC_STAR_BLUE'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_blue.gif',
	'GRAPHIC_STAR_GOLD'					=> 'ext/gfksx/thanksforposts/images/rating/reput_star_gold.gif',

	'IMG_THANKPOSTS'					=> 'Mesaja teşekkür et',
	'IMG_REMOVETHANKS'					=> 'Teşekkürü iptal et',

	'LOG_CONFIG_THANKS'					=> 'Eklenti sonrası için teşekkür yapılandırması güncellendi',

	'REFRESH'							=> 'Yenile',
	'REMOVE_THANKS'						=> 'Teşekkürleri kaldır',
	'REMOVE_THANKS_EXPLAIN'				=> 'Bu seçenek etkinse, kullanıcılar teşekkürlerini kaldırabilir.',

	'STEPR'								=> ' - düzenle, adım %s',

	'THANKS_COUNTERS_VIEW'				=> 'Teşekkür sayacı',
	'THANKS_COUNTERS_VIEW_EXPLAIN'		=> 'Etkinleştirilirse, yazar hakkındaki blok bilgileri, verilen/ alınan teşekkür sayısını gösterir.',
	'THANKS_FORUM_REPUT_VIEW'			=> 'Forum derecelendirmesini göster',
	'THANKS_GLOBAL_POST'				=> 'Genel duyurulara teşekkürü aç',
	'THANKS_GLOBAL_POST_EXPLAIN'		=> 'Etkinleştirilirse, Ggenel duyurularda teşekkür verme etkin olur.',
	'THANKS_FORUM_REPUT_VIEW_EXPLAIN'	=> 'Etkinleştirilirse, forum listesinde forum derecelendirmeleri görüntülenir.',
	'THANKS_INFO_PAGE'					=> 'Bilgilendirici mesajlar',
	'THANKS_INFO_PAGE_EXPLAIN'			=> 'Etkinleştirilirse, mesaj için teşekkür ettikten/ çıkardıktan sonra bilgilendirici mesajlar görüntülenir.',
	'THANKS_NOTICE_ON'					=> 'Mevcut bildirimler',
	'THANKS_NOTICE_ON_EXPLAIN'			=> 'Etkinleştirilirse, bildirim kullanılabilir ve kullanıcı bildirimi profiliniz üzerinden yapılandırabilir.',
	'THANKS_NUMBER'						=> 'Profilde gösterilen teşekkürlerin sayısı',
	'THANKS_NUMBER_EXPLAIN'				=> 'Bir profili görüntülerken görüntülenen maksimum teşekkür sayısı. <br /> <strong>Bu değer 250\'nin üzerine ayarlanırsa yavaşlama olabileceğini unutmayın.</strong>',
	'THANKS_NUMBER_DIGITS'				=> 'Derecelendirme için ondalık basamak sayısı',
	'THANKS_NUMBER_DIGITS_EXPLAIN'		=> 'Derecelendirme değeri için ondalık basamak sayısını belirtin.',
	'THANKS_NUMBER_ROW_REPUT'			=> 'Değerlendirme için üst listedeki satır sayısı',
	'THANKS_NUMBER_ROW_REPUT_EXPLAIN'	=> 'Mesajlarda, konularda ve forumlarda en çok oy alan forumlarda gösterilecek satır sayısını belirtin.',
	'THANKS_NUMBER_POST'				=> 'Bir mesajda listelenen teşekkürlerin sayısı',
	'THANKS_NUMBER_POST_EXPLAIN'		=> 'Bir mesajı görüntülerken görüntülenen maksimum teşekkür sayısı. <br /> <strong>Bu değer 250\'nin üzerine ayarlanırsa yavaşlama olabileceğini unutmayın.</strong>',
	'THANKS_ONLY_FIRST_POST'			=> 'Sadece konudaki ilk gönderi için',
	'THANKS_ONLY_FIRST_POST_EXPLAIN'	=> 'Etkinleştirilirse, kullanıcılar yalnızca konudaki ilk gönderim için teşekkür edebilir.',
	'THANKS_POST_REPUT_VIEW'			=> 'Gönderiler için derecelendirmeyi göster',
	'THANKS_POST_REPUT_VIEW_EXPLAIN'	=> 'Etkinleştirilirse, bir konuyu görüntülerken gönderiler derecelendirme görüntülenir.',
	'THANKS_POSTLIST_VIEW'				=> 'Mesajlarda teşekkür listesi',
	'THANKS_POSTLIST_VIEW_EXPLAIN'		=> 'Etkinleştirildiğinde, gönderim için yazara teşekkür eden kullanıcıların listesi görüntülenir. <br/> Bu seçeneğin yalnızca yönetici bu forumdaki yayın için teşekkür izni verme izni verdiğinde etkili olacağını unutmayın.',
	'THANKS_PROFILELIST_VIEW'			=> 'Profilde teşekkür listesi',
	'THANKS_PROFILELIST_VIEW_EXPLAIN'	=> 'Etkinleştirilirse, teşekkür sayısı ve bir kullanıcının teşekkür ettiği mesajları içeren eksiksiz bir teşekkür listesi görüntülenir.',
	'THANKS_REFRESH'					=> 'Teşekkür sayaçlarını güncelle',
	'THANKS_REFRESH_EXPLAIN'			=> 'Burada, gönderilerin/ konuların/ kullanıcıların toplu olarak kaldırılması, konuların bölünmesi/ birleştirilmesi, Global Duyurunun ayarlanması/ kaldırılması, "Yalnızca bu konudaki ilk yazı için" seçeneğinin etkinleştirilmesi/ devre dışı bırakılması, yayın sahiplerinin değiştirilmesi vb. işlemlerden sonra teşekkür sayaçlarını güncelleyebilirsiniz. Bu biraz zaman alabilir.<br /><strong>Önemli: Düzgün çalışabilmesi için sayaç yenileme işlevinin MySQL sürüm 4.1 veya daha yüksek sürümüne ihtiyacı var!<br />Dikkat!<br /> - Yenileme, konuk gönderileriniz için tüm teşekkürleri silecek!<br /> - Global Duyurularda Teşekkürler seçeneği KAPALI ise, yenileme Genel Duyurular için tüm teşekkürleri siler!<br /> - Yalnızca konudaki ilk yazı için seçeneği AÇIK ise, yenileme, konudaki ilk hariç tüm konumlar için tüm teşekkürleri siler!</strong>',
	'THANKS_REFRESH_MSG'				=> 'Bu işlemin tamamlanması birkaç dakika sürebilir. Tüm yanlış teşekkürler girişleri silinecek!<br />İşlem iptal edildi!',
	'THANKS_REFRESHED_MSG'				=> 'Sayaçlar güncellendi',
	'THANKS_REPUT_GRAPHIC'				=> 'Derecelendirmenin grafik görüntüsü',
	'THANKS_REPUT_GRAPHIC_EXPLAIN'		=> 'Etkinleştirilirse, derecelendirme değeri aşağıdaki resimler kullanılarak grafik olarak gösterilir.',
	'THANKS_REPUT_HEIGHT'				=> 'Grafik yüksekliği',
	'THANKS_REPUT_HEIGHT_EXPLAIN'		=> 'Sıralamanın kaydırıcısının yüksekliğini piksel cinsinden belirtin.<br /><strong>Dikkat! Doğru görüntülemek için, aşağıdaki görüntünün yüksekliğine eşit bir yükseklik belirtmelisiniz!</strong>',
	'THANKS_REPUT_IMAGE'				=> 'Kaydırıcının ana görüntüsü',
	'THANKS_REPUT_IMAGE_DEFAULT'		=> '<strong>Grafik Önizlemesi</strong>',
	'THANKS_REPUT_IMAGE_DEFAULT_EXPLAIN' => 'Görüntünün kendisi ve görüntünün yolu burada görülebilir. Resim boyutu 15x15 pikseldir.<br />Ön ve arka plan için kendi resimlerinizi çizebilirsiniz.<strong>Görüntünün yüksekliği ve genişliği, grafiksel ölçeğin doğru bir şekilde oluşturulmasını sağlamak için aynı olmalıdır.</strong>',
	'THANKS_REPUT_IMAGE_EXPLAIN'		=> 'Yol - phpBB\'nin kök klasörüne göre - grafik ölçeği görüntüsüne.',
	'THANKS_REPUT_IMAGE_NOEXIST'		=> 'Grafik skalası için ana görüntü bulunamadı.',
	'THANKS_REPUT_IMAGE_BACK'			=> 'Kaydırıcının arka plan resmi',
	'THANKS_REPUT_IMAGE_BACK_EXPLAIN'	=> 'Kök phpBB kurulum klasörüne göre yol - grafik ölçeği arka plan görüntüsüne.',
	'THANKS_REPUT_IMAGE_BACK_NOEXIST'	=> 'Grafik ölçeğinin arka plan görüntüsü bulunamadı.',
	'THANKS_REPUT_LEVEL'				=> 'Grafik ölçeğinde görüntü sayısı',
	'THANKS_REPUT_LEVEL_EXPLAIN'		=> 'Grafikteki derecelendirme ölçeğinin değerinin% 100\'üne karşılık gelen maksimum görüntü sayısı.',
	'THANKS_TIME_VIEW'					=> 'Teşekkür zamanı',
	'THANKS_TIME_VIEW_EXPLAIN'			=> 'Etkinleştirildiğinde, mesajda teşekkür süresini gösterir.',
	'THANKS_TOP_NUMBER'					=> 'toplistteki kullanıcı sayısı',
	'THANKS_TOP_NUMBER_EXPLAIN'			=> 'Dizin listesindeki toplistte gösterilecek kullanıcı sayısını belirtin. 0 (sıfır) toplisti kapatır.',
	'THANKS_TOPIC_REPUT_VIEW'			=> 'Konu derecelendirmesini göster',
	'THANKS_TOPIC_REPUT_VIEW_EXPLAIN'	=> 'Etkinleştirilirse, bir forumu görüntülerken konu değerlendirmesi görüntülenecektir.',
	'TRUNCATE'							=> 'Temizle',
	'TRUNCATE_THANKS'					=> 'Teşekkür elistesini temizle',
	'TRUNCATE_THANKS_EXPLAIN'			=> 'Bu prosedür tüm teşekkür sayaçlarını tamamen siler (verilen tüm teşekkürleri siler).<br />Bu eylem geri alınamaz!',
	'TRUNCATE_THANKS_MSG'				=> 'Teşekkür sayaçları temizlendi.',
	'REFRESH_THANKS_CONFIRM'			=> 'Teşekkür sayaçlarını gerçekten yenilemek istiyor musunuz?',
	'TRUNCATE_THANKS_CONFIRM'			=> 'Teşekkür sayaçlarını gerçekten temizlemek istiyor musunuz?',
	'TRUNCATE_NO_THANKS'				=> 'İşlem iptal edildi',
	'ALLOW_THANKS_PM_ON'				=> 'Mesajıma teşekkür edilirse ÖM ile bildir',
	'ALLOW_THANKS_EMAIL_ON'				=> 'Mesajıma teşekkür edilirse email ile bildir',
]);
