(function () {
	'use strict';

	var storageKey = 'initial-theme';
	var themes = ['light', 'dark', 'auto'];
	var labels = {
		light: '浅色',
		dark: '深色',
		auto: '跟随系统'
	};
	var root = document.documentElement;
	var switcher = document.querySelector('.theme-switcher');
	var toggle = document.getElementById('theme-switcher-toggle');
	var menu = document.getElementById('theme-switcher-menu');
	var themeColor = document.getElementById('theme-color-meta');
	var systemTheme = window.matchMedia
		? window.matchMedia('(prefers-color-scheme: dark)')
		: null;

	if (!switcher || !toggle || !menu) {
		return;
	}

	var options = menu.querySelectorAll('[data-theme-value]');

	function normalizeTheme(theme) {
		return themes.indexOf(theme) === -1 ? 'auto' : theme;
	}

	function resolveTheme(theme) {
		if (theme !== 'auto') {
			return theme;
		}

		return systemTheme && systemTheme.matches ? 'dark' : 'light';
	}

	function updateControls(theme, scheme) {
		for (var i = 0; i < options.length; i++) {
			var active = options[i].getAttribute('data-theme-value') === theme;

			options[i].classList.toggle('is-active', active);
			options[i].setAttribute('aria-checked', active ? 'true' : 'false');
		}

		var label = labels[theme];
		if (theme === 'auto') {
			label += '（当前' + labels[scheme] + '）';
		}

		toggle.setAttribute('aria-label', '配色模式：' + label);
		toggle.setAttribute('title', '配色模式：' + label);
	}

	function applyTheme(theme, persist) {
		theme = normalizeTheme(theme);
		var scheme = resolveTheme(theme);

		root.setAttribute('data-theme', theme);
		root.setAttribute('data-color-scheme', scheme);
		root.classList.remove('theme-light');
		root.classList.remove('theme-dark');
		root.classList.add('theme-' + scheme);
		root.style.colorScheme = scheme;

		if (themeColor) {
			themeColor.setAttribute(
				'content',
				scheme === 'dark' ? '#111315' : '#ffffff'
			);
		}

		if (persist) {
			try {
				window.localStorage.setItem(storageKey, theme);
			} catch (error) {}
		}

		updateControls(theme, scheme);
	}

	function getCurrentOption() {
		return menu.querySelector(
			'[data-theme-value="' + root.getAttribute('data-theme') + '"]'
		);
	}

	function openMenu() {
		menu.hidden = false;
		toggle.setAttribute('aria-expanded', 'true');

		window.setTimeout(function () {
			var current = getCurrentOption();
			(current || options[0]).focus();
		}, 0);
	}

	function closeMenu(returnFocus) {
		menu.hidden = true;
		toggle.setAttribute('aria-expanded', 'false');

		if (returnFocus) {
			toggle.focus();
		}
	}

	function moveFocus(direction) {
		var currentIndex = Array.prototype.indexOf.call(
			options,
			document.activeElement
		);

		if (currentIndex < 0) {
			currentIndex = 0;
		}

		currentIndex = (currentIndex + direction + options.length) % options.length;
		options[currentIndex].focus();
	}

	toggle.addEventListener('click', function () {
		if (menu.hidden) {
			openMenu();
		} else {
			closeMenu(false);
		}
	});

	for (var i = 0; i < options.length; i++) {
		options[i].addEventListener('click', function () {
			applyTheme(this.getAttribute('data-theme-value'), true);
			closeMenu(true);
		});
	}

	menu.addEventListener('keydown', function (event) {
		if (event.key === 'ArrowDown') {
			event.preventDefault();
			moveFocus(1);
		} else if (event.key === 'ArrowUp') {
			event.preventDefault();
			moveFocus(-1);
		} else if (event.key === 'Home') {
			event.preventDefault();
			options[0].focus();
		} else if (event.key === 'End') {
			event.preventDefault();
			options[options.length - 1].focus();
		} else if (
			(event.key === 'Enter' || event.key === ' ') &&
			event.target.hasAttribute('data-theme-value')
		) {
			event.preventDefault();
			event.target.click();
		}
	});

	document.addEventListener('click', function (event) {
		if (!menu.hidden && !switcher.contains(event.target)) {
			closeMenu(false);
		}
	});

	document.addEventListener('focusin', function (event) {
		if (!menu.hidden && !switcher.contains(event.target)) {
			closeMenu(false);
		}
	});

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && !menu.hidden) {
			event.preventDefault();
			closeMenu(true);
		}
	});

	function handleSystemThemeChange() {
		if (root.getAttribute('data-theme') === 'auto') {
			applyTheme('auto', false);
		}
	}

	if (systemTheme) {
		if (systemTheme.addEventListener) {
			systemTheme.addEventListener('change', handleSystemThemeChange);
		} else if (systemTheme.addListener) {
			systemTheme.addListener(handleSystemThemeChange);
		}
	}

	window.addEventListener('storage', function (event) {
		if (event.key !== storageKey) {
			return;
		}

		var fallback = root.getAttribute('data-theme-default') || 'auto';
		applyTheme(event.newValue || fallback, false);
	});

	applyTheme(root.getAttribute('data-theme'), false);
})();
