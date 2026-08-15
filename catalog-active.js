(function () {
	'use strict';

	var controller = null;
	var requestFrame = window.requestAnimationFrame || function (callback) {
		return window.setTimeout(callback, 16);
	};
	var cancelFrame = window.cancelAnimationFrame || window.clearTimeout;

	function getTarget(hash) {
		var target = document.getElementById(hash);
		if (target) {
			return target;
		}

		var named = document.getElementsByName(hash);
		return named.length ? named[0] : null;
	}

	function initCatalogActiveHeading() {
		if (controller) {
			controller.destroy();
			controller = null;
		}

		var catalog = document.getElementById('catalog-col');
		var content = document.querySelector('.post-content');

		if (!catalog || !content) {
			return;
		}

		var links = catalog.querySelectorAll('a[href^="#cl-"]');
		var entries = [];

		for (var i = 0; i < links.length; i++) {
			var href = links[i].getAttribute('href');
			var hash = href ? href.slice(1) : '';
			var target = hash ? getTarget(hash) : null;

			if (target && content.contains(target)) {
				entries.push({
					hash: hash,
					link: links[i],
					target: target,
					item: links[i].parentNode
				});
			}
		}

		if (!entries.length) {
			return;
		}

		catalog.setAttribute('role', 'navigation');
		catalog.setAttribute('aria-label', '文章目录');

		var positions = [];
		var activeIndex = -1;
		var updateFrame = null;
		var measureFrame = null;
		var resizeObserver = null;
		var catalogButton = document.getElementById('catalog');
		var linkHandlers = [];

		function clearActiveState() {
			var marked = catalog.querySelectorAll(
				'.catalog-active-link, .catalog-active-item, .catalog-active-path'
			);

			for (var i = 0; i < marked.length; i++) {
				marked[i].classList.remove('catalog-active-link');
				marked[i].classList.remove('catalog-active-item');
				marked[i].classList.remove('catalog-active-path');
			}

			for (var j = 0; j < entries.length; j++) {
				entries[j].link.removeAttribute('aria-current');
			}
		}

		function ensureActiveVisible(link) {
			if (!catalog.classList.contains('catalog')) {
				return;
			}

			var catalogRect = catalog.getBoundingClientRect();
			var linkRect = link.getBoundingClientRect();
			var topEdge = catalogRect.top + 12;
			var bottomEdge = catalogRect.bottom - 12;

			if (linkRect.top < topEdge) {
				catalog.scrollTop -= topEdge - linkRect.top;
			} else if (linkRect.bottom > bottomEdge) {
				catalog.scrollTop += linkRect.bottom - bottomEdge;
			}
		}

		function setActive(index, reveal) {
			if (index < 0 || index >= entries.length) {
				return;
			}

			if (activeIndex !== index) {
				clearActiveState();
				activeIndex = index;

				var entry = entries[index];
				entry.link.classList.add('catalog-active-link');
				entry.link.setAttribute('aria-current', 'location');

				if (entry.item && entry.item.nodeType === 1) {
					entry.item.classList.add('catalog-active-item');
					var ancestor = entry.item.parentNode;

					while (ancestor && ancestor !== catalog) {
						if (ancestor.tagName && ancestor.tagName.toLowerCase() === 'li') {
							ancestor.classList.add('catalog-active-path');
						}
						ancestor = ancestor.parentNode;
					}
				}
			}

			if (reveal) {
				ensureActiveVisible(entries[index].link);
			}
		}

		function updateActive() {
			updateFrame = null;

			if (!positions.length) {
				return;
			}

			var scrollTop = window.pageYOffset
				|| document.documentElement.scrollTop
				|| document.body.scrollTop
				|| 0;
			var activeLine = scrollTop + 12;
			var index = 0;

			for (var i = 0; i < positions.length; i++) {
				if (positions[i] <= activeLine) {
					index = i;
				} else {
					break;
				}
			}

			var documentHeight = Math.max(
				document.body.scrollHeight,
				document.documentElement.scrollHeight
			);

			if (scrollTop + window.innerHeight >= documentHeight - 2) {
				index = entries.length - 1;
			}

			setActive(index, true);
		}

		function scheduleUpdate() {
			if (updateFrame !== null) {
				return;
			}

			updateFrame = requestFrame(updateActive);
		}

		function measurePositions() {
			measureFrame = null;
			var scrollTop = window.pageYOffset
				|| document.documentElement.scrollTop
				|| document.body.scrollTop
				|| 0;

			positions = [];
			for (var i = 0; i < entries.length; i++) {
				positions.push(entries[i].target.getBoundingClientRect().top + scrollTop);
			}

			scheduleUpdate();
		}

		function scheduleMeasure() {
			if (measureFrame !== null) {
				return;
			}

			measureFrame = requestFrame(measurePositions);
		}

		function updateCatalogButton() {
			if (!catalogButton) {
				return;
			}

			catalogButton.setAttribute(
				'aria-expanded',
				catalog.classList.contains('catalog') ? 'true' : 'false'
			);
		}

		function handleCatalogButtonClick() {
			window.setTimeout(function () {
				updateCatalogButton();
				if (activeIndex >= 0) {
					ensureActiveVisible(entries[activeIndex].link);
				}
			}, 220);
		}

		function handleCatalogButtonKeydown(event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				catalogButton.click();
			}
		}

		function handleHashChange() {
			var hash = window.location.hash ? window.location.hash.slice(1) : '';

			for (var i = 0; i < entries.length; i++) {
				if (entries[i].hash === hash) {
					setActive(i, true);
					break;
				}
			}

			window.setTimeout(scheduleUpdate, 0);
		}

		for (var i = 0; i < entries.length; i++) {
			(function (index) {
				var handler = function () {
					setActive(index, false);
					window.setTimeout(function () {
						updateCatalogButton();
						scheduleUpdate();
					}, 0);
				};

				entries[index].link.addEventListener('click', handler);
				linkHandlers.push({
					link: entries[index].link,
					handler: handler
				});
			}(i));
		}

		if (catalogButton) {
			catalogButton.setAttribute('role', 'button');
			catalogButton.setAttribute('tabindex', '0');
			catalogButton.setAttribute('aria-label', '切换文章目录');
			catalogButton.setAttribute('aria-controls', 'catalog-col');
			updateCatalogButton();
			catalogButton.addEventListener('click', handleCatalogButtonClick);
			catalogButton.addEventListener('keydown', handleCatalogButtonKeydown);
		}

		window.addEventListener('scroll', scheduleUpdate);
		window.addEventListener('resize', scheduleMeasure);
		window.addEventListener('load', scheduleMeasure);
		window.addEventListener('hashchange', handleHashChange);

		if (window.ResizeObserver) {
			resizeObserver = new window.ResizeObserver(scheduleMeasure);
			resizeObserver.observe(content);
		}

		measurePositions();
		handleHashChange();

		controller = {
			destroy: function () {
				if (updateFrame !== null) {
					cancelFrame(updateFrame);
				}
				if (measureFrame !== null) {
					cancelFrame(measureFrame);
				}
				if (resizeObserver) {
					resizeObserver.disconnect();
				}

				window.removeEventListener('scroll', scheduleUpdate);
				window.removeEventListener('resize', scheduleMeasure);
				window.removeEventListener('load', scheduleMeasure);
				window.removeEventListener('hashchange', handleHashChange);

				if (catalogButton) {
					catalogButton.removeEventListener('click', handleCatalogButtonClick);
					catalogButton.removeEventListener('keydown', handleCatalogButtonKeydown);
				}

				for (var i = 0; i < linkHandlers.length; i++) {
					linkHandlers[i].link.removeEventListener(
						'click',
						linkHandlers[i].handler
					);
				}
			}
		};
	}

	function init() {
		initCatalogActiveHeading();

		if (window.jQuery) {
			window.jQuery(document)
				.off('pjax:end.catalogActiveHeading')
				.on('pjax:end.catalogActiveHeading', initCatalogActiveHeading);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
}());
