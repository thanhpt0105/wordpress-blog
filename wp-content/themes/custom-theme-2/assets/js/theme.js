(function () {
	const settings = window.acmeThemeSettings || {};
	const toggles = Object.assign(
		{
			darkMode: true,
			readingProgress: true,
			tableOfContents: true,
			copyHeadings: true,
			readingTime: 'minutes'
		},
		settings.toggles || {}
	);

	document.addEventListener('DOMContentLoaded', () => {
		const docEl = document.documentElement;
		const body = document.body;

		/* Dark mode toggle */
		if (toggles.darkMode) {
			const storageKey = 'acme-theme-scheme';
			const toggle = document.querySelector('[data-acme-toggle="dark-mode"]');
			const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');

			const applyScheme = (scheme) => {
				if (!scheme || scheme === 'auto') {
					scheme = prefersDark.matches ? 'dark' : 'light';
				}

				docEl.classList.toggle('is-dark-theme', scheme === 'dark');
				docEl.dataset.acmeTheme = scheme;
				toggle && (toggle.setAttribute('aria-pressed', String(scheme === 'dark')));
			};

			let storedScheme = null;
			try {
				storedScheme = localStorage.getItem(storageKey);
			} catch (error) {
				storedScheme = null;
			}

			applyScheme(storedScheme || 'auto');

			prefersDark.addEventListener('change', () => {
				const current = docEl.dataset.acmeTheme || 'auto';
				if (current === 'auto') {
					applyScheme('auto');
				}
			});

			if (toggle) {
				toggle.addEventListener('click', () => {
					const current = docEl.classList.contains('is-dark-theme') ? 'dark' : 'light';
					const next = current === 'dark' ? 'light' : 'dark';
					applyScheme(next);
					try {
						localStorage.setItem(storageKey, next);
					} catch (error) {
						// Ignore storage issues (private mode).
					}
				});

				toggle.addEventListener('keydown', (event) => {
					if (event.key === 'Enter' || event.key === ' ') {
						event.preventDefault();
						toggle.click();
					}
				});
			}
		}

		/* Mobile navigation */
		const menuToggle = document.querySelector('[data-acme-mobile-toggle]');
		const offcanvas = document.querySelector('.acme-offcanvas');
		const overlay = document.querySelector('.acme-offcanvas-overlay');

		if (menuToggle && offcanvas && overlay) {
			offcanvas.setAttribute('aria-hidden', 'true');
			overlay.setAttribute('aria-hidden', 'true');
			menuToggle.setAttribute('aria-expanded', 'false');
			let lastFocus = null;

			const focusableSelectors = 'a[href], button:not([disabled]), textarea, input, select, [tabindex="0"]';

			const setExpanded = (state) => {
				menuToggle.setAttribute('aria-expanded', String(state));
				offcanvas.setAttribute('aria-hidden', String(!state));
				overlay.setAttribute('aria-hidden', String(!state));
			};

			const trapFocus = (event) => {
				const focusable = offcanvas.querySelectorAll(focusableSelectors);
				if (!focusable.length) {
					return;
				}

				const first = focusable[0];
				const last = focusable[focusable.length - 1];

				if (event.key === 'Tab') {
					if (event.shiftKey && document.activeElement === first) {
						event.preventDefault();
						last.focus();
					} else if (!event.shiftKey && document.activeElement === last) {
						event.preventDefault();
						first.focus();
					}
				}
			};

			const closeMenu = () => {
				offcanvas.classList.remove('is-open');
				overlay.classList.remove('is-active');
				docEl.classList.remove('acme-lock-scroll');
				offcanvas.removeEventListener('keydown', trapFocus);
				overlay.removeEventListener('click', closeMenu);
				document.removeEventListener('keydown', escListener);
				setExpanded(false);
				if (lastFocus) {
					lastFocus.focus();
				}
			};

			const escListener = (event) => {
				if (event.key === 'Escape') {
					closeMenu();
				}
			};

			const openMenu = () => {
				lastFocus = document.activeElement;
				offcanvas.classList.add('is-open');
				overlay.classList.add('is-active');
				docEl.classList.add('acme-lock-scroll');
				offcanvas.addEventListener('keydown', trapFocus);
				overlay.addEventListener('click', closeMenu);
				document.addEventListener('keydown', escListener);
				setExpanded(true);
				const focusable = offcanvas.querySelectorAll(focusableSelectors);
				if (focusable.length) {
					focusable[0].focus();
				}
			};

			menuToggle.addEventListener('click', () => {
				if (offcanvas.classList.contains('is-open')) {
					closeMenu();
				} else {
					openMenu();
				}
			});
		}

		/* Reading progress bar */
		if (toggles.readingProgress) {
			const progressBar = document.createElement('div');
			progressBar.className = 'acme-progress';
			progressBar.setAttribute('aria-hidden', 'true');
			body.appendChild(progressBar);

			const updateProgress = () => {
				const article = document.querySelector('article');
				if (!article) {
					return;
				}

				const scrollTop = window.scrollY || document.documentElement.scrollTop;
				const top = article.getBoundingClientRect().top + scrollTop;
				const height = article.offsetHeight;
				const divisor = Math.max(height - window.innerHeight, 1);
				const progress = Math.min(1, Math.max(0, (scrollTop - top) / divisor));
				progressBar.style.width = `${progress * 100}%`;
			};

			updateProgress();
			window.addEventListener('scroll', updateProgress, { passive: true });
			window.addEventListener('resize', updateProgress);
		}

		/* Copy heading links */
		if (toggles.copyHeadings) {
			const headings = document.querySelectorAll('.entry-content h2, .entry-content h3, .entry-content h4');
			headings.forEach((heading) => {
				if (!heading.id) {
					heading.id = heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-');
				}

				heading.classList.add('has-acme-copy');
				heading.style.position = 'relative';

				const button = document.createElement('button');
				button.type = 'button';
				button.className = 'acme-copy-heading';
				button.setAttribute('aria-label', 'Copy link to heading');
				button.innerHTML = '<span aria-hidden="true">#</span>';
				heading.appendChild(button);

				button.addEventListener('click', async () => {
					const url = `${window.location.origin}${window.location.pathname}#${heading.id}`;
					try {
						await navigator.clipboard.writeText(url);
						button.classList.add('is-copied');
						setTimeout(() => button.classList.remove('is-copied'), 1200);
					} catch (error) {
						const temp = document.createElement('input');
						temp.value = url;
						document.body.appendChild(temp);
						temp.select();
						document.execCommand('copy');
						temp.remove();
					}
				});
			});
		}

		/* Table of contents */
		if (toggles.tableOfContents) {
			const tocContainer = document.querySelector('[data-acme-toc]');
			if (tocContainer) {
				const headings = document.querySelectorAll('.entry-content h2, .entry-content h3');
				const list = document.createElement('ol');
				list.className = 'acme-toc__list';
				let count = 0;

				headings.forEach((heading) => {
					if (!heading.id) {
						heading.id = heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-');
					}

					const item = document.createElement('li');
					if (heading.tagName.toLowerCase() === 'h3') {
						item.style.paddingInlineStart = '1rem';
					}

					const link = document.createElement('a');
					link.href = `#${heading.id}`;
					link.textContent = heading.textContent;
					item.appendChild(link);
					list.appendChild(item);
					count += 1;
				});

				if (count > 1) {
					tocContainer.innerHTML = '';
					const title = document.createElement('p');
					title.className = 'acme-toc__title';
					title.textContent = 'On this page';
					tocContainer.appendChild(title);
					tocContainer.appendChild(list);
				} else {
					tocContainer.style.display = 'none';
				}
			}
		}

		/* Share copy */
		const shareCopyLinks = document.querySelectorAll('[data-acme-share-copy]');
		shareCopyLinks.forEach((link) => {
			link.addEventListener('click', (event) => {
				event.preventDefault();
				const text = link.getAttribute('data-acme-share-copy');
				if (!text) {
					return;
				}
				navigator.clipboard.writeText(text).catch(() => {
					const temp = document.createElement('input');
					temp.value = text;
					document.body.appendChild(temp);
					temp.select();
					document.execCommand('copy');
					temp.remove();
				});
			});
		});

		/* Gallery lightbox */
		const galleryLinks = document.querySelectorAll('a[data-acme-lightbox]');
		if (galleryLinks.length) {
			const overlay = document.createElement('div');
			overlay.className = 'acme-lightbox';
			overlay.innerHTML = '<button class="acme-lightbox__close" aria-label="Close gallery">×</button><img class="acme-lightbox__image" alt="" /><p class="acme-lightbox__caption"></p>';
			document.body.appendChild(overlay);
			const image = overlay.querySelector('.acme-lightbox__image');
			const caption = overlay.querySelector('.acme-lightbox__caption');
			const closeBtn = overlay.querySelector('.acme-lightbox__close');

			const close = () => {
				overlay.classList.remove('is-active');
				document.removeEventListener('keydown', onKeydown);
			};

			const onKeydown = (event) => {
				if (event.key === 'Escape') {
					close();
				}
			};

			galleryLinks.forEach((link) => {
				link.addEventListener('click', (event) => {
					event.preventDefault();
					const url = link.getAttribute('href');
					const alt = link.querySelector('img')?.getAttribute('alt') || '';
					image.src = url;
					image.alt = alt;
					caption.textContent = alt;
					overlay.classList.add('is-active');
					document.addEventListener('keydown', onKeydown);
				});
			});

			closeBtn.addEventListener('click', close);
			overlay.addEventListener('click', (event) => {
				if (event.target === overlay) {
					close();
				}
			});
		}
	});
})();
