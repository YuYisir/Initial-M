(function () {
	'use strict';
	var codeBlockStyle = window.codeBlockStyle;
	var languageNames = {
		bash: 'Bash',
		c: 'C',
		cpp: 'C++',
		csharp: 'C#',
		css: 'CSS',
		dockerfile: 'Dockerfile',
		go: 'Go',
		html: 'HTML',
		http: 'HTTP',
		java: 'Java',
		javascript: 'JavaScript',
		js: 'JavaScript',
		json: 'JSON',
		kotlin: 'Kotlin',
		markdown: 'Markdown',
		md: 'Markdown',
		nginx: 'Nginx',
		php: 'PHP',
		plaintext: '纯文本',
		python: 'Python',
		py: 'Python',
		ruby: 'Ruby',
		rust: 'Rust',
		shell: 'Shell',
		sql: 'SQL',
		swift: 'Swift',
		text: '纯文本',
		ts: 'TypeScript',
		typescript: 'TypeScript',
		xml: 'XML',
		yaml: 'YAML',
		yml: 'YAML'
	};

	function detectLanguage(code, pre) {
		var className = (code.className + ' ' + pre.className).trim();
		var match = className.match(/(?:language|lang)-([a-z0-9_+-]+)/i);
		var language = match ? match[1] : '';

		if (!language && code.result && code.result.language) {
			language = code.result.language;
		}

		if (!language) {
			return '代码';
		}

		language = language.toLowerCase();
		return languageNames[language] || language.toUpperCase();
	}

	function fallbackCopy(text) {
		var textarea = document.createElement('textarea');

		textarea.value = text;
		textarea.setAttribute('readonly', '');
		textarea.style.position = 'fixed';
		textarea.style.top = '-9999px';
		textarea.style.opacity = '0';
		document.body.appendChild(textarea);
		textarea.select();

		var copied = false;

		try {
			copied = document.execCommand('copy');
		} catch (error) {
			copied = false;
		}

		document.body.removeChild(textarea);
		return copied ? Promise.resolve() : Promise.reject();
	}

	function copyText(text) {
		if (
			navigator.clipboard &&
			window.isSecureContext
		) {
			return navigator.clipboard.writeText(text).catch(function () {
				return fallbackCopy(text);
			});
		}

		return fallbackCopy(text);
	}

	function setCopyState(button, state) {
		var label = state === 'success'
			? '已复制'
			: (state === 'error' ? '复制失败' : '复制');

		button.textContent = label;
		button.classList.toggle('is-success', state === 'success');
		button.classList.toggle('is-error', state === 'error');
		button.setAttribute('aria-label', label + '代码');

		if (state !== 'idle') {
			window.setTimeout(function () {
				setCopyState(button, 'idle');
			}, 2500);
		}
	}

	function enhanceCodeBlock(code) {
		var pre = code.parentElement;

		if (
			!pre ||
			pre.tagName.toLowerCase() !== 'pre' ||
			pre.parentElement.classList.contains('code-block')
		) {
			return;
		}

		var wrapper = document.createElement('div');
		var toolbar = document.createElement('div');
		var language = document.createElement('span');
		var copyButton = document.createElement('button');

		wrapper.className = 'code-block';
		if (codeBlockStyle === 0) {
			wrapper.classList.add('code-block--classic');
		}
		toolbar.className = 'code-block__toolbar';
		language.className = 'code-block__language';
		copyButton.className = 'code-block__copy';
		copyButton.type = 'button';

		language.textContent = detectLanguage(code, pre);
		setCopyState(copyButton, 'idle');

		copyButton.addEventListener('click', function () {
			copyText(code.textContent).then(function () {
				setCopyState(copyButton, 'success');
			}).catch(function () {
				setCopyState(copyButton, 'error');
			});
		});

		toolbar.appendChild(language);
		toolbar.appendChild(copyButton);
		pre.parentNode.insertBefore(wrapper, pre);
		wrapper.appendChild(toolbar);
		wrapper.appendChild(pre);
	}

	function initCodeBlocks(root) {
		var container = root || document;
		var blocks = container.querySelectorAll('.post-content pre > code');

		for (var i = 0; i < blocks.length; i++) {
			enhanceCodeBlock(blocks[i]);
		}
	}

	function init() {
		initCodeBlocks(document);

		if (window.jQuery) {
			window.jQuery(document)
				.off('pjax:complete.codeBlockTools')
				.on('pjax:complete.codeBlockTools', function () {
					initCodeBlocks(document);
				});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
