<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
if (!empty($this->options->Breadcrumbs) && in_array('Postshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs">
<a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->category(); ?> &raquo; <?php echo !empty($this->options->Breadcrumbs) && in_array('Text', $this->options->Breadcrumbs) ? '正文' : $this->title; ?>
</div>
<?php endif; ?>
<article class="post<?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?>">
<h1 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
<ul class="post-meta">
<li><?php $this->date(); ?></li>
<li><?php $this->category(','); ?></li>
<li><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无评论', '%d 条评论'); ?></a></li>
<li><?php Postviews($this); ?></li>
</ul>
<div class="post-content">
<!-- 回复可见开始 此处注释的为原版内容：?php $this->content(); ?>-->
<?php
$db = Typecho_Db::get();
$sql = $db->select()->from('table.comments')
    ->where('cid = ?',$this->cid)
    ->where('mail = ?', $this->remember('mail',true))
    ->where('status = ?', 'approved')
//只有通过审核的评论才能看回复可见内容
    ->limit(1);
$result = $db->fetchAll($sql);
if($this->user->hasLogin() || $result) {
    $content = preg_replace("/\[hidden\](.*?)\[\/hidden\]/sm",'<div class="reply2view">$1</div>',$this->content);
}
else{
    $content = preg_replace("/\[hidden\](.*?)\[\/hidden\]/sm",'<div class="reply2view">此处内容需要评论回复后方可阅读</div>',$this->content);
}
echo $content;
?>
<!-- 回复可见结束（审核通过） -->
</div>
<!-- 文章底部广告开始 -->
<?php if (isset($this->options->GoogleAdClient) && $this->options->GoogleAdClient && isset($this->options->GoogleAdSlotPost) && $this->options->GoogleAdSlotPost): ?>
<div id="gg-post-foot"<?php if (isset($this->options->GoogleAdPostStyle) && $this->options->GoogleAdPostStyle): ?> style="<?php $this->options->GoogleAdPostStyle(); ?>"<?php endif; ?>>
    <?php $this->options->GoogleAdSlotPost(); ?>
</div>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
<?php endif; ?>
<!-- 文章底部广告结束 -->
<?php if ($this->options->WeChat || $this->options->Alipay): ?>
<p class="rewards">打赏: <?php if ($this->options->WeChat): ?>
<a><img src="<?php $this->options->WeChat(); ?>" alt="微信收款二维码" />微信</a><?php endif; if ($this->options->WeChat && $this->options->Alipay): ?>, <?php endif; if ($this->options->Alipay): ?>
<a><img src="<?php $this->options->Alipay(); ?>" alt="支付宝收款二维码" />支付宝</a><?php endif; ?>
</p>
<?php endif; ?>
<p class="tags">标签: <?php $this->tags(', ', true, 'none'); ?></p>
<?php if ($this->options->LicenseInfo !== '0'): ?>
<p class="license"><?php echo $this->options->LicenseInfo ? $this->options->LicenseInfo : '本作品采用 <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="license nofollow">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可。' ?></p>
<?php endif; ?>
</article>
<?php $this->need('comments.php'); ?>
<ul class="post-near">
<li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
<li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
</ul>
</div>
<?php if (!$this->options->OneCOL): $this->need('sidebar.php'); endif; ?>
<?php $this->need('footer.php'); ?>