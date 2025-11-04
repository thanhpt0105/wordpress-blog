const doc = document;

const acmeDomReady = (callback) => {
	if (doc.readyState === 'interactive' || doc.readyState === 'complete') {
		callback();
	} else {
		doc.addEventListener('DOMContentLoaded', callback, { once: true });
	}
};

const acmeClamp = (value, min, max) => Math.min(Math.max(value, min), max);

acmeDomReady(() => {
	const body = doc.body;
	const root = doc.documentElement;
	const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
	const progressBar = doc.querySelector('.acme-reading-progress__bar');
	const darkToggle = doc.querySelector('[data-dark-mode-toggle]');
	const shareWrapper = doc.querySelector('.acme-floating-share');
	const loadMoreButton = doc.querySelector('[data-load-more]');
	let loadMorePage = 1;
	let totalPages = Number(loadMoreButton?.dataset.totalPages || 1);

	const applyTheme = (mode) => {
		const isDark = mode === 'dark';
		body.classList.toggle('is-dark-mode', isDark);
		root.classList.toggle('is-dark-mode', isDark);
		root.style.colorScheme = isDark ? 'dark' : 'light';

		if (darkToggle) {
			darkToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
			darkToggle.dataset.mode = isDark ? 'dark' : 'light';
			darkToggle.classList.toggle('is-dark', isDark);
			const icon = darkToggle.querySelector('[data-mode-icon]');
			if (icon) {
				icon.textContent = isDark ? '🌙' : '💡';
			}

			darkToggle.querySelector('[data-mode-label]').textContent = isDark ? acmeTheme.strings.dark : acmeTheme.strings.light;
		}
	};

	const initTheme = () => {
		const stored = window.localStorage.getItem('acme-color-mode');

		if (stored === 'dark' || stored === 'light') {
			applyTheme(stored);
		} else {
			applyTheme(prefersDark.matches ? 'dark' : 'light');
		}
	};

	const toggleTheme = () => {
		const isDark = body.classList.contains('is-dark-mode');
		const nextMode = isDark ? 'light' : 'dark';
		applyTheme(nextMode);
		window.localStorage.setItem('acme-color-mode', nextMode);
	};

	if (darkToggle) {
		darkToggle.addEventListener('click', () => toggleTheme());
		darkToggle.addEventListener('keydown', (event) => {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				toggleTheme();
			}
		});
	}

	const handleSystemThemeChange = (event) => {
		const stored = window.localStorage.getItem('acme-color-mode');
		if (stored !== 'dark' && stored !== 'light') {
			applyTheme(event.matches ? 'dark' : 'light');
		}
	};

	if (typeof prefersDark.addEventListener === 'function') {
		prefersDark.addEventListener('change', handleSystemThemeChange);
	} else if (typeof prefersDark.addListener === 'function') {
		prefersDark.addListener(handleSystemThemeChange);
	}

	initTheme();

	const updateProgress = () => {
		if (!progressBar) {
			return;
		}

		const scrollElement = doc.scrollingElement || doc.documentElement;
		const max = scrollElement.scrollHeight - window.innerHeight;
		if (max <= 0) {
			progressBar.style.width = '0%';
			return;
		}

		const value = acmeClamp((scrollElement.scrollTop / max) * 100, 0, 100);
		progressBar.style.width = `${value}%`;
	};

	window.addEventListener('scroll', updateProgress, { passive: true });
	window.addEventListener('resize', updateProgress);
	updateProgress();

	const buildShareUrl = (network) => {
		const url = encodeURIComponent(window.location.href);
		const title = encodeURIComponent(doc.title);

		switch (network) {
			case 'twitter':
				return `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
			case 'facebook':
				return `https://www.facebook.com/sharer/sharer.php?u=${url}`;
			case 'linkedin':
				return `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${title}`;
			default:
				return url;
		}
	};

	if (shareWrapper) {
		shareWrapper.addEventListener('click', async (event) => {
			const target = event.target.closest('[data-share]');
			if (!target) {
				return;
			}

			const network = target.dataset.share;

			if (network === 'copy') {
				try {
					await navigator.clipboard.writeText(window.location.href);
					target.setAttribute('data-feedback', acmeTheme.strings.shareCopy);
					target.classList.add('is-success');
					setTimeout(() => {
						target.removeAttribute('data-feedback');
						target.classList.remove('is-success');
					}, 2000);
				} catch (error) {
					target.setAttribute('data-feedback', acmeTheme.strings.shareFail);
					setTimeout(() => target.removeAttribute('data-feedback'), 2000);
				}
				return;
			}

			if (network === 'native' && navigator.share) {
				event.preventDefault();
				try {
					await navigator.share({
						title: doc.title,
						url: window.location.href,
					});
				} catch (error) {
					// sharing cancelled
				}
				return;
			}

			const shareUrl = buildShareUrl(network);
			if (shareUrl) {
				window.open(shareUrl, '_blank', 'noopener,noreferrer,width=600,height=600');
			}
		});
	}

	const renderPostCard = (post) => {
		const featured = post._embedded?.['wp:featuredmedia']?.[0];
		const thumbnail = featured?.media_details?.sizes?.medium_large?.source_url || featured?.source_url || '';
		const categories = post._embedded?.['wp:term']?.[0] || [];
		const firstCategory = categories[0];

		return `
			<article class="wp-block-post acme-post-card">
				${thumbnail ? `<figure class="wp-block-post-featured-image"><img src="${thumbnail}" alt="${featured?.alt_text || ''}" loading="lazy"></figure>` : ''}
				<div class="acme-post-card__meta">
					${firstCategory ? `<span class="acme-post-card__category">${firstCategory.name}</span>` : ''}
					<time datetime="${post.date_gmt}">${new Date(post.date).toLocaleDateString()}</time>
				</div>
				<h2 class="wp-block-post-title"><a href="${post.link}">${post.title.rendered}</a></h2>
				<p class="acme-post-card__excerpt">${post.excerpt.rendered.replace(/<[^>]+>/g, '').slice(0, 160)}...</p>
			</article>
		`;
	};

	const loadMorePosts = async () => {
		if (!loadMoreButton || loadMoreButton.disabled) {
			return;
		}

		if (loadMorePage >= totalPages) {
			loadMoreButton.textContent = acmeTheme.strings.noMore;
			loadMoreButton.disabled = true;
			return;
		}

		loadMoreButton.disabled = true;
		const template = doc.querySelector('.wp-block-post-template');
		if (!template) {
			return;
		}

		const nextPage = loadMorePage + 1;

		loadMoreButton.textContent = acmeTheme.strings.loading;

		const perPage = Number(loadMoreButton.dataset.perPage || 6);

		try {
			const response = await fetch(`${acmeTheme.restUrl}?page=${nextPage}&per_page=${perPage}&_embed=1&context=view&acme_context=minimal-list`, {
				headers: {
					'X-WP-Nonce': acmeTheme.restNonce,
					'Accept': 'application/json',
				},
			});

			totalPages = Number(response.headers.get('X-WP-TotalPages')) || totalPages;

			if (!response.ok) {
				throw new Error(response.statusText);
			}

			const data = await response.json();

			if (!data.length) {
				loadMoreButton.textContent = acmeTheme.strings.noMore;
				loadMoreButton.disabled = true;
				return;
			}

			const markup = data.map(renderPostCard).join('');
			template.insertAdjacentHTML('beforeend', markup);

			loadMorePage = nextPage;
			if (loadMorePage >= totalPages) {
				loadMoreButton.textContent = acmeTheme.strings.noMore;
				loadMoreButton.disabled = true;
			} else {
				loadMoreButton.textContent = acmeTheme.strings.loadMore;
				loadMoreButton.disabled = false;
			}
		} catch (error) {
			loadMoreButton.textContent = acmeTheme.strings.loadMore;
			loadMoreButton.disabled = false;
		}
	};

	if (loadMoreButton) {
		loadMoreButton.addEventListener('click', loadMorePosts);
	}
});
