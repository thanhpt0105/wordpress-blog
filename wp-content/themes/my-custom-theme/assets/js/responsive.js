(function () {
    const toggle = document.querySelector('.category-nav__toggle');
    const nav = document.getElementById('primary-category-nav');

    if (!toggle || !nav) {
        return;
    }

    const openClass = 'category-nav--open';
    const toggleOpenClass = 'pill-toggle--open';
    const label = toggle.querySelector('.pill-toggle__label');
    const closedLabel = toggle.getAttribute('data-label-closed') || '';
    const openLabel = toggle.getAttribute('data-label-open') || '';

    toggle.addEventListener('click', function () {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!expanded));
        nav.classList.toggle(openClass, !expanded);
        toggle.classList.toggle(toggleOpenClass, !expanded);

        if (label) {
            label.textContent = !expanded ? openLabel : closedLabel;
        }
    });

    // Close menu when focus leaves nav and toggle (for better accessibility).
    document.addEventListener('click', function (event) {
        if (!nav.classList.contains(openClass)) {
            return;
        }

        if (toggle.contains(event.target) || nav.contains(event.target)) {
            return;
        }

        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove(openClass);
        toggle.classList.remove(toggleOpenClass);

        if (label) {
            label.textContent = closedLabel;
        }
    });
})();

(function () {
    const sidebar = document.querySelector('[data-collapsible="sidebar"]');
    if (!sidebar) {
        return;
    }

    const toggle = sidebar.querySelector('.sidebar-toggle');
    const panel = sidebar.querySelector('.sidebar-widgets');

    if (!toggle || !panel) {
        return;
    }

    const toggleIconClass = 'pill-toggle--open';
    const labelElement = toggle.querySelector('.pill-toggle__label');
    const closedLabel = toggle.getAttribute('data-label-closed') || (labelElement ? labelElement.textContent : '');
    const openLabel = toggle.getAttribute('data-label-open') || closedLabel;
    let hideTimeout = null;

    if (labelElement) {
        labelElement.textContent = closedLabel;
    }

    const setHiddenAfterAnimation = () => {
        panel.hidden = true;
        panel.removeEventListener('transitionend', setHiddenAfterAnimation);
    };

    function setState(expanded) {
        toggle.setAttribute('aria-expanded', String(expanded));
        if (expanded) {
            if (hideTimeout) {
                clearTimeout(hideTimeout);
                hideTimeout = null;
            }
            panel.removeEventListener('transitionend', setHiddenAfterAnimation);
            panel.hidden = false;
            requestAnimationFrame(() => {
                panel.classList.add('sidebar-widgets--open');
            });
            toggle.classList.add(toggleIconClass);
            if (labelElement) {
                labelElement.textContent = openLabel;
            }
        } else {
            panel.classList.remove('sidebar-widgets--open');
            panel.removeEventListener('transitionend', setHiddenAfterAnimation);
            panel.addEventListener('transitionend', setHiddenAfterAnimation);
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                setHiddenAfterAnimation();
            } else {
                hideTimeout = window.setTimeout(() => {
                    if (!panel.hidden) {
                        setHiddenAfterAnimation();
                    }
                }, 300);
            }
            toggle.classList.remove(toggleIconClass);
            if (labelElement) {
                labelElement.textContent = closedLabel;
            }
        }
    }

    toggle.addEventListener('click', () => {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        setState(!expanded);
    });

    // Ensure desktop shows sidebar if needed.
    const mediaQuery = window.matchMedia('(min-width: 1025px)');
    function handleMediaChange(e) {
        if (e.matches) {
            panel.hidden = false;
            panel.classList.remove('sidebar-widgets--open');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add(toggleIconClass);
            panel.removeEventListener('transitionend', setHiddenAfterAnimation);
            if (hideTimeout) {
                clearTimeout(hideTimeout);
                hideTimeout = null;
            }
            if (labelElement) {
                labelElement.textContent = openLabel;
            }
        } else {
            toggle.setAttribute('aria-expanded', 'false');
            panel.classList.remove('sidebar-widgets--open');
            panel.hidden = true;
            toggle.classList.remove(toggleIconClass);
            if (hideTimeout) {
                clearTimeout(hideTimeout);
                hideTimeout = null;
            }
            if (labelElement) {
                labelElement.textContent = closedLabel;
            }
        }
    }

    mediaQuery.addEventListener('change', handleMediaChange);
    handleMediaChange(mediaQuery);
})();
