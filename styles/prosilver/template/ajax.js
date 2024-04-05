/* global phpbb */

(function($) {  // Avoid conflicts with other libraries

'use strict';

phpbb.addAjaxCallback('handle_thanks', function(res) {

	var thanksId = '#lnk_thanks_post' + res.post_id;
	var mode = res.mode;
	var l_thanks_received = res.l_thanks_received;
	var l_thanks_given = res.l_thanks_given;
	var received_title = '<strong>' + res.l_received + res.l_colon + '</strong> ';
	var u_received = '<a href="' + res.u_received + '">' + l_thanks_received + '</a>';
	var given_title = '<strong>' + res.l_given + res.l_colon + '</strong> ';
	var u_given = '<a href="' + res.u_given + '">' + l_thanks_given + '</a>';

	$(thanksId).blur();
	$(thanksId + ' > i').removeClass(mode == 'insert' ? 'fa-thumbs-o-up' : 'fa-thumbs-o-down').addClass(mode == 'insert' ? "fa-thumbs-o-down" : 'fa-thumbs-o-up');

	var url = $(thanksId).attr('href');
	url = url.replace(mode == 'insert' ? 'thanks' : 'rthanks', mode == 'insert' ? 'rthanks' : 'thanks');
	$(thanksId).attr('href', url);

	if (mode == 'insert') {
		if (res.received_count == 0) {
			$('[data-user-receive-id="' + res.to_id + '"]').html(received_title + u_received);
		} else {
			$('[data-user-receive-id="' + res.to_id + '"] > a').html(l_thanks_received);
		}

		if (res.given_count == 0) {
			$('[data-user-give-id="' + res.from_id + '"]').html(given_title + u_given);
		} else {
			$('[data-user-give-id="' + res.from_id + '"] > a').html(l_thanks_given);
		}
	} else 	if (mode == 'delete') {
		if (res.received_count == 1) {
			$('[data-user-receive-id="' + res.to_id + '"] > a').remove();
			$('[data-user-receive-id="' + res.to_id + '"] > strong').remove();
		} else {
			$('[data-user-receive-id="' + res.to_id + '"] > a').html(l_thanks_received);
		}

		if (res.given_count == 1) {
			$('[data-user-give-id="' + res.from_id + '"] > a').remove();
			$('[data-user-give-id="' + res.from_id + '"] > strong').remove();
		} else {
			$('[data-user-give-id="' + res.from_id + '"] > a').html(l_thanks_given);
		}
	}
});

})(jQuery); // Avoid conflicts with other libraries
