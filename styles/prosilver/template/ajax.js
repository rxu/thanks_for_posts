/* global phpbb */

(function($) {  // Avoid conflicts with other libraries

'use strict';

phpbb.addAjaxCallback('handle_thanks', function(res) {

	var mode = res.mode;
	var postContentId = '#post_content' + res.post_id;
	var postReputId = '#div_post_reput' + res.post_id;
	var givenTitle = '<strong>' + res.l_given + res.l_colon + '</strong> ';
	var receivedTitle = '<strong>' + res.l_received + res.l_colon + '</strong> ';
	var thanksLinkId = '[id="lnk_thanks_post' + res.post_id + '"]';
	var thanksListId = '[id="list_thanks' + res.post_id + '"]';
	var userGiveId = '[data-user-give-id="' + res.from_id + '"]';
	var userReceiveId = '[data-user-receive-id="' + res.to_id + '"]';

	var l_thanks_received = res.l_thanks_received;
	var l_thanks_given = res.l_thanks_given;

	var u_received = '<a href="' + res.u_received + '">' + l_thanks_received + '</a>';
	var u_given = '<a href="' + res.u_given + '">' + l_thanks_given + '</a>';

	var thanksLink = $(thanksLinkId);
	var thanksList = $(thanksListId);
	var userGive = $(userGiveId);
	var userReceive = $(userReceiveId);

	thanksLink.blur();
	$('i',thanksLink).removeClass(mode == 'insert' ? 'fa-thumbs-o-up' : 'fa-thumbs-o-down').addClass(mode == 'insert' ? "fa-thumbs-o-down" : 'fa-thumbs-o-up');
	$('span', thanksLink).text(mode == 'insert' ? res.l_remove_thanks_short : res.l_thank_post_short);

	thanksLink.each(function() {
		this.href = this.href.replace(mode == 'insert' ? 'thanks' : 'rthanks', mode == 'insert' ? 'rthanks' : 'thanks');
		this.title = this.title.replace((mode == 'insert') ? res.l_thank_post : res.l_remove_thanks, (mode == 'insert') ? res.l_remove_thanks : res.l_thank_post);
	})

	if (mode == 'insert') { // Handle thanks addition
		if (res.received_count == 1) { // Handle received thanks count in posts miniprofiles
			userReceive.html(receivedTitle + u_received);
		} else {
			$('a', userReceive).html(l_thanks_received);
		}

		if (res.given_count == 1) { // Handle given thanks count in posts miniprofiles
			userGive.html(givenTitle + u_given);
		} else {
			$('a', userGive).html(l_thanks_given);
		}

		if (!res.s_remove_thanks) { // Remove un-thank button if thanks removal is not allowed
			thanksLink.parent('li').remove();
		}
	} else 	if (mode == 'delete') { // Handle thanks deletion
		if (res.received_count == 0) { // Handle received thanks count in posts miniprofiles
			userReceive.html('');
		} else {
			$('a', userReceive).html(l_thanks_received);
		}

		if (res.given_count == 0) { // Handle given thanks count in posts miniprofiles
			userGive.html('');
		} else {
			$('a', userGive).html(l_thanks_given);
		}
	}

	// Handle posts thanker lists and ratings
	thanksList.remove();
	$(postReputId).replaceWith(res.html);

	// Refresh existing post ratings on the page if leader post rating changes
	if (!$.isEmptyObject(res.post_reput_html)) {
		$.each(res.post_reput_html, function(key, value) {
			var postReputId = '#div_post_reput' + key;
			$(postReputId).replaceWith(value);
		});
	}
});

})(jQuery); // Avoid conflicts with other libraries
