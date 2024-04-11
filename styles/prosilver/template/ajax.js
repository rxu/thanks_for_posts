/* global phpbb */

(function($) {  // Avoid conflicts with other libraries

'use strict';

phpbb.addAjaxCallback('handle_thanks', function(res) {

	var thanksId = '#lnk_thanks_post' + res.post_id;
	var thanksListId = '#list_thanks' + res.post_id;
	var postReputId = '#div_post_reput' + res.post_id;
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

	if (mode == 'insert') { // Handle thanks addition
		if (res.received_count == 1) { // Handle received thanks count in posts miniprofiles
			$('[data-user-receive-id="' + res.to_id + '"]').html(received_title + u_received);
		} else {
			$('[data-user-receive-id="' + res.to_id + '"] > a').html(l_thanks_received);
		}

		if (res.given_count == 1) { // Handle given thanks count in posts miniprofiles
			$('[data-user-give-id="' + res.from_id + '"]').html(given_title + u_given);
		} else {
			$('[data-user-give-id="' + res.from_id + '"] > a').html(l_thanks_given);
		}

		// Handle posts thanker lists and ratings
		if (res.post_thanks_number == 1) {
			$(thanksListId).remove();
			$(postReputId).remove();
			$('#post_content' + res.post_id).after(res.html);
		} else {
		}

	} else 	if (mode == 'delete') { // Handle thanks deletion
		if (res.received_count == 0) { // Handle received thanks count in posts miniprofiles
			$('[data-user-receive-id="' + res.to_id + '"] > a').remove();
			$('[data-user-receive-id="' + res.to_id + '"] > strong').remove();
		} else {
			$('[data-user-receive-id="' + res.to_id + '"] > a').html(l_thanks_received);
		}

		if (res.given_count == 0) { // Handle given thanks count in posts miniprofiles
			$('[data-user-give-id="' + res.from_id + '"] > a').remove();
			$('[data-user-give-id="' + res.from_id + '"] > strong').remove();
		} else {
			$('[data-user-give-id="' + res.from_id + '"] > a').html(l_thanks_given);
		}

		// Handle posts thanker lists and ratings
		if (res.post_thanks_number == 0) {
			$(thanksListId).remove();
			$(postReputId).remove();
		} else {
			var index = $(thanksListId + ' a:contains("' + res.username + '")').closest('span').index(); // Find user queue index in the post thankers list
			$(thanksListId + ' a:contains("' + res.username + '")').closest('span').remove(); // Remove user from the post thankers list
			if (index >= 0) {
				$(thanksListId + ' dd').contents().filter(function() { return this.nodeType == 3; }).eq(index = 0 ? index : index - 1).remove(); // Remove unneeded comma
			}

			// Reduce the count of thanks in 'and X more user(s)' text
			var text = $(thanksListId + ' dd').contents().filter(function() { return this.nodeType == 3; }).last().text();
			var match = text.match(/\d+/);
			var replace = text.replace(text == res.l_further_thank ? res.l_further_thank : /\d+/, text == res.l_further_thank ? '' : match - 1);
			$(thanksListId + ' dd').contents().filter(function() { return this.nodeType == 3; }).last().replaceWith(match == 2 ? res.l_further_thank : replace);
			
			// Reduce the count of thanks in the post thankers list text
			var text = $(thanksListId + ' dt').contents().filter(function() { return this.nodeType == 3; }).eq(1).text().replace(/\d+/, res.post_thanks_number - 1);
			$(thanksListId + ' dt').contents().filter(function() { return this.nodeType == 3; }).eq(1).replaceWith(res.post_thanks_number == 1 ? res.l_thank_text_2 : text);
		}
	}
});

})(jQuery); // Avoid conflicts with other libraries
