;(() => {
	/** @typedef {{ fadeOut: (ms: number) => JQuery }} JQuery */

	/**
	 * @type {{
	 * 	phpbb: {
	 * 		alertTime: number,
	 * 		loadingIndicator: () => JQuery,
	 * 		alert: (title: string, message: string) => JQuery,
	 * 		confirm: (
	 *			msg: string,
	 * 			callback: (val: boolean) => void,
	 * 			fadedark?: boolean,
	 * 		) => JQuery,
	 * 		clearLoadingTimeout: () => void,
	 * 	},
	 * 	thanksForPosts: {
	 * 		l10n: {
	 * 			errorTitle: string,
	 * 			errorMessage: string,
	 * 		},
	 * 	},
	 * }}
	 */
	const { phpbb, thanksForPosts: { l10n } } = window

	/**
	 * @param {HTMLAnchorElement} $link
	 * @param {Document} doc
	 */
	const getReplacerForLink = ($link, doc) => {
		const $post = $link.closest('.post')
		const $replacement = doc.getElementById($post.id)

		if ($replacement) {
			$replacement.querySelector('.content').replaceWith(
				$post.querySelector('.content'),
			)

			return () => $post.replaceWith($replacement)
		}

		return null
	}

	document.body.addEventListener('click', async (e) => {
		/** @type {HTMLAnchorElement} link */
		let $link

		if ($link = e.target.closest('a[href*="&thanks="]')) {
			e.preventDefault()

			const $loadingIndicator = phpbb.loadingIndicator()
			const res = await fetch($link.href)

			if (res.ok) {
				const res = await fetch(window.location.href)
				const text = await res.text()

				const doc = new DOMParser().parseFromString(text, 'text/html')

				getReplacerForLink($link, doc)?.()
			} else {
				phpbb.alert(l10n.errorTitle, l10n.errorMessage)
			}

			phpbb.clearLoadingTimeout()
			$loadingIndicator.fadeOut(phpbb.alertTime)
		} else if ($link = e.target.closest('a[href*="&rthanks="]')) {
			e.preventDefault()

			const $loadingIndicator = phpbb.loadingIndicator()

			const $iframe = document.createElement('iframe')
			$iframe.src = $link.href
			$iframe.hidden = true
			document.body.appendChild($iframe)

			$iframe.addEventListener('load', () => {
				// 'load' will fire multiple times, due to in-frame navigation;
				// we check for presence of elements on the page to determine
				// which load event we're inside of

				const $form = $iframe.contentDocument.querySelector('form#confirm')
				const $confirmBtn = $form?.querySelector('[name=confirm]')

				// is confirmation form
				if ($confirmBtn) {
					const $clone = $form.cloneNode(true)

					const $confirmContent = $clone.querySelector('.inner') ?? $clone

					// must be <input type=button name=confirm/cancel>
					// in order for phpbb.confirm to recognize clicks
					for (const $btn of $confirmContent.querySelectorAll('[type=submit]')) {
						$btn.type = 'button'
					}

					phpbb.confirm(
						$confirmContent.innerHTML,
						(val) => {
							if (val) {
								$confirmBtn.click()

								phpbb.loadingIndicator()
							} else {
								$iframe.remove()
							}
						},
					)

					return
				}

				const replacer = getReplacerForLink($link, $iframe.contentDocument)

				// is navigation back to own page
				if (replacer) {
					replacer()

					phpbb.clearLoadingTimeout()
					$loadingIndicator.fadeOut(phpbb.alertTime)

					$iframe.remove()

					return
				}
			})
		}
	})
})()
