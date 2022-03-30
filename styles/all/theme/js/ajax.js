;(() => {
	/** @typedef {{ fadeOut: (ms: number) => JQuery }} JQuery */

	/**
	 * @type {{
	 * 	phpbb: {
	 * 		alertTime: number,
	 * 		loadingIndicator: () => JQuery,
	 * 		alert: (title: string, message: string) => JQuery,
	 * 		confirm: (msg: string, callback: (val: boolean) => void) => JQuery,
	 * 		clearLoadingTimeout: () => void,
	 * 	},
	 * 	thanksForPosts: { l10n: { errorTitle: string, errorMessage: string } },
	 * }}
	 */
	const { phpbb, thanksForPosts: { l10n } } = window

	/**
	 * @param {HTMLAnchorElement} $link
	 * @param {Document} replacementDoc
	 */
	const getReplacerForLink = ($link, replacementDoc) => {
		const $post = $link.closest('.post')
		const $replacement = replacementDoc.getElementById($post.id)

		if ($replacement) {
			$replacement
				.querySelector('.content')
				.replaceWith($post.querySelector('.content'))

			return () => {
				const $focused = window.document.activeElement

				$post.replaceWith($replacement)

				// UX - re-focus active element within replacement DOM
				if ($post.contains($focused)) {
					;[...$replacement.querySelectorAll('*')]
						.find(
							($el) =>
								($el.id && $el.id === $focused.id) ||
								($el.href && $el.href === $focused.href),
						)
						?.focus()
				}
			}
		}

		return null
	}

	/** @param {HTMLAnchorElement} $link */
	const thankHandler = async ($link) => {
		const $loadingIndicator = phpbb.loadingIndicator()
		const res = await fetch($link.href)

		if (res.ok) {
			const res = await fetch(window.location.href)
			const text = await res.text()

			const resDoc = new DOMParser().parseFromString(text, 'text/html')

			getReplacerForLink($link, resDoc)?.()
		} else {
			phpbb.alert(l10n.errorTitle, l10n.errorMessage)
		}

		phpbb.clearLoadingTimeout()
		$loadingIndicator.fadeOut(phpbb.alertTime)
	}

	/** @param {HTMLAnchorElement} $link */
	const unthankHandler = ($link) => {
		const $loadingIndicator = phpbb.loadingIndicator()

		const $iframe = Object.assign(document.createElement('iframe'), {
			src: $link.href,
			sandbox: 'allow-same-origin allow-forms allow-scripts',
			// Firefox will not submit form if iframe is `hidden` or
			// `display: none`, so we place it out of view instead
			style: 'width: 1; height: 1; position: fixed; top: -10000px',
			// a11y - hide from assistive technology etc.
			ariaHidden: 'true',
		})

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
				const $confirm = $clone.querySelector('.inner') ?? $clone

				// must be <input type=button name=confirm/cancel>
				// in order for phpbb.confirm to recognize clicks
				for (const $btn of $confirm.querySelectorAll('[type=submit]')) {
					$btn.type = 'button'
				}

				phpbb.confirm($confirm.innerHTML, (val) => {
					if (val) {
						$confirmBtn.click()

						phpbb.loadingIndicator()
					} else {
						$iframe.remove()
					}
				})

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

	document.body.addEventListener('click', (e) => {
		/** @type {HTMLAnchorElement} $link */
		let $link

		if (($link = e.target.closest('a[href*="&thanks="]'))) {
			e.preventDefault()
			thankHandler($link)
		} else if (($link = e.target.closest('a[href*="&rthanks="]'))) {
			e.preventDefault()
			unthankHandler($link)
		}
	})
})()
