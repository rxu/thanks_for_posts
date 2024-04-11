/* global phpbb */

(function($) {  // Avoid conflicts with other libraries

'use strict';

phpbb.addAjaxCallback('handle_thanks', function(res) {

	var mode = res.mode;
	var postContentId = '#post_content' + res.post_id;
	var postReputId = '#div_post_reput' + res.post_id;
	var givenTitle = '<strong>' + res.l_given + res.l_colon + '</strong> ';
	var receivedTitle = '<strong>' + res.l_received + res.l_colon + '</strong> ';
	var thanksId = '#lnk_thanks_post' + res.post_id;
	var thanksListId = '#list_thanks' + res.post_id;
	var userGiveId = '[data-user-give-id="' + res.from_id + '"]';
	var userReceiveId = '[data-user-receive-id="' + res.to_id + '"]';

	var l_thanks_received = res.l_thanks_received;
	var l_thanks_given = res.l_thanks_given;

	var u_received = '<a href="' + res.u_received + '">' + l_thanks_received + '</a>';
	var u_given = '<a href="' + res.u_given + '">' + l_thanks_given + '</a>';

	$(thanksId).blur();
	$(thanksId + ' > i').removeClass(mode == 'insert' ? 'fa-thumbs-o-up' : 'fa-thumbs-o-down').addClass(mode == 'insert' ? "fa-thumbs-o-down" : 'fa-thumbs-o-up');

	var url = $(thanksId).attr('href');
	url = url.replace(mode == 'insert' ? 'thanks' : 'rthanks', mode == 'insert' ? 'rthanks' : 'thanks');
	$(thanksId).attr('href', url);

	if (mode == 'insert') { // Handle thanks addition
		if (res.received_count == 1) { // Handle received thanks count in posts miniprofiles
			$(userReceiveId).html(receivedTitle + u_received);
		} else {
			$(userReceiveId + ' > a').html(l_thanks_received);
		}

		if (res.given_count == 1) { // Handle given thanks count in posts miniprofiles
			$(userGiveId).html(givenTitle + u_given);
		} else {
			$(userGiveId + ' > a').html(l_thanks_given);
		}

		// Handle posts thanker lists and ratings
		$(thanksListId).remove();
		$(postReputId).remove();
		$(postContentId).after(res.html);

	} else 	if (mode == 'delete') { // Handle thanks deletion
		if (res.received_count == 0) { // Handle received thanks count in posts miniprofiles
			$(userReceiveId).html('');
		} else {
			$(userReceiveId + ' > a').html(l_thanks_received);
		}

		if (res.given_count == 0) { // Handle given thanks count in posts miniprofiles
			$(userGiveId).html('');
		} else {
			$(userGiveId + res.from_id + ' > a').html(l_thanks_given);
		}

		// Handle posts thanker lists and ratings
		$(thanksListId).remove();
		$(postReputId).remove();
		$(postContentId).after(res.html);
	}
});

})(jQuery); // Avoid conflicts with other libraries
