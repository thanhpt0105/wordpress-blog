(function () {
    const toggle = document.querySelector('.category-nav__toggle');
    const nav = document.getElementById('primary-category-nav');

    if (!toggle || !nav) {
        return;
    }

    const openClass = 'category-nav--open';
    const toggleOpenClass = 'category-nav__toggle--open';
    const label = toggle.querySelector('.category-nav__toggle-label');
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
