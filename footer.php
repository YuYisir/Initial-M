<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div>
</div>
<footer id="footer">
<div class="container">
<?php if (!empty($this->options->ShowLinks) && in_array('footer', $this->options->ShowLinks)): ?>
<ul class="links">
<?php Links($this->options->IndexLinksSort); ?>
<?php $page_links = FindContents('page-links.php', 'order', 'a', 1);
if ($page_links):
	$widget = Typecho_Widget::widget('Widget_Abstract_Contents');
	$widget->push($page_links[0]);
?>
<li><a href="<?php echo $widget->permalink; ?>">更多...</a></li>
<?php endif; ?>
</ul>
<?php endif; ?>
<p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a> &amp; <a href="http://www.offodd.com/17.html" target="_blank">Initial</a>.</p>
<!-- 备案开始 -->
<?php if ($this->options->ICPbeian || (isset($this->options->Gonganbeian) && $this->options->Gonganbeian)): ?>
<p>
<?php if ($this->options->ICPbeian): ?>
<a href="http://beian.miit.gov.cn" class="icpnum" target="_blank" rel="noreferrer"> <?php $this->options->ICPbeian(); ?></a>
<?php endif; ?>
<?php if ($this->options->ICPbeian && isset($this->options->Gonganbeian) && $this->options->Gonganbeian): ?> | <?php endif; ?>
<?php if (isset($this->options->Gonganbeian) && $this->options->Gonganbeian): ?>
<a href="https://beian.mps.gov.cn/#/query/webSearch" class="icpnum" target="_blank" rel="noreferrer"> <?php $this->options->Gonganbeian(); ?></a>
<?php endif; ?>
</p>
<!-- 备案结束 -->
<?php endif; if ($this->options->AjaxLoad): ?>
<input id="token" type="hidden" value="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl('Token'); ?>" readonly="readonly" />
<?php endif; ?>
</div>
</footer>
<?php if ($this->options->scrollTop || ($this->options->MusicSet && $this->options->MusicUrl)): ?>
<div id="cornertool">
<ul>
<?php if ($this->options->scrollTop): ?>
<li id="top" class="hidden"></li>
<?php endif; ?>
<?php if ($this->options->MusicSet && $this->options->MusicUrl): ?>
<li id="music" class="hidden">
<span><i></i></span>
<audio id="audio" data-src="<?php Playlist() ?>"<?php if ($this->options->MusicVol): ?> data-vol="<?php $this->options->MusicVol(); ?>"<?php endif; ?> preload="none"></audio>
</li>
<?php endif; ?>
</ul>
</div>
<?php endif; if ($this->options->PjaxOption || $this->options->AjaxLoad): ?>
<script src="//<?php if ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js<?php elseif ($this->options->cjCDN == 'sc'): ?>cdn.staticfile.org/jquery/2.1.4/jquery.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery@2.1.4/dist/jquery.min.js<?php endif; ?>"></script>
<?php endif; if ($this->options->PjaxOption): ?>
<script src="//<?php if ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js<?php elseif ($this->options->cjCDN == 'sc'): ?>cdn.staticfile.org/jquery.pjax/2.0.1/jquery.pjax.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.min.js<?php endif; ?>"></script>
<?php endif; if ($this->options->Highlight):?>
<script src="//<?php if ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/highlight.js/10.2.0/highlight.min.js<?php elseif ($this->options->cjCDN == 'sc'): ?>cdn.staticfile.org/highlight.js/10.2.0/highlight.min.js<?php else: ?>cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.2.0/build/highlight.min.js<?php endif; ?>"></script>
<?php endif; ?>
<script src="<?php cjUrl('main.min.js') ?>"></script>
<?php $this->footer(); ?>
<?php if ($this->options->CustomContent): $this->options->CustomContent(); ?>
<?php endif; ?>
<!-- 广告总引入开始 -->
<?php if (isset($this->options->GoogleAdClient) && $this->options->GoogleAdClient): ?>
<!-- 延迟加载广告主脚本，并在加载完成后手动 push 广告 -->
<script type="text/javascript">
  function downloadJSAtOnload() {
    var script = document.createElement("script");
    script.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php $this->options->GoogleAdClient(); ?>";
    script.async = true;
    script.crossOrigin = "anonymous";
    script.onload = function () {
      // 广告位会在各自位置自行初始化，无需在此处统一推送
    };
    document.body.appendChild(script);
  }
  if (window.addEventListener)
    window.addEventListener("load", downloadJSAtOnload, false);
  else if (window.attachEvent)
    window.attachEvent("onload", downloadJSAtOnload);
  else window.onload = downloadJSAtOnload;
</script>
<?php endif; ?>
<!-- 广告总引入结束 -->
<?php if (!isset($this->options->GoogleRecaptchaReplace) || $this->options->GoogleRecaptchaReplace): ?>
<!-- goog链接替换开始 -->
<script>
// 确保在DOM加载后执行
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('script[src*="www.google.com/recaptcha/"]').forEach(function(script) {
    script.src = script.src.replace('www.google.com/recaptcha/', 'www.recaptcha.net/recaptcha/');
  });
});
</script>
<!-- goog链接替换结束 -->
<?php endif; ?>
</body>
</html><?php if ($this->options->compressHtml): $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); endif; ?>