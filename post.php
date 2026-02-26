<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
// 确保$cover变量存在
if (!isset($cover)) {
    $cover = '';
    if ($this->is('post') || $this->is('page')) {
        if (!empty($this->fields->thumb)) {
            $cover = $this->fields->thumb;
        } elseif ($this->options->autoFetchCover && preg_match('/<img.*?src="(.*?)"/', $this->content, $matches)) {
            $cover = $matches[1];
        } else {
            $cover = $this->options->defaultCover ? $this->options->defaultCover : $this->options->themeUrl . '/img/default-cover.webp';
        }
    }
}
$this->need('header.php');
if (!empty($this->options->Breadcrumbs) && in_array('Postshow', $this->options->Breadcrumbs)): ?>
<?php
// 简化的面包屑导航实现
$categoryName = '未分类';
$categoryPermalink = '';
// 尝试获取第一个分类
if (isset($this->categories) && count($this->categories) > 0) {
    $firstCategory = reset($this->categories);
    $categoryName = $firstCategory['name'];
    $categoryPermalink = $firstCategory['permalink'];
}
?>
<div class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<a href="<?php $this->options->siteUrl(); ?>" itemprop="item"><span itemprop="name">首页</span></a>
<meta itemprop="position" content="1" />
</span> &raquo; 
<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<?php if (!empty($categoryPermalink)): ?>
<a href="<?php echo $categoryPermalink; ?>" itemprop="item"><span itemprop="name"><?php echo $categoryName; ?></span></a>
<?php else: ?>
<span itemprop="name"><?php echo $categoryName; ?></span>
<?php endif; ?>
<meta itemprop="position" content="2" />
</span> &raquo; 
<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<span itemprop="name"><?php echo !empty($this->options->Breadcrumbs) && in_array('Text', $this->options->Breadcrumbs) ? '正文' : $this->title; ?></span>
<meta itemprop="position" content="3" />
</span>
</div>
<?php endif; ?>
<article class="post<?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?>" itemscope itemtype="https://schema.org/Article">
<meta itemprop="image" content="<?php echo $cover; ?>" />
<div itemprop="author" itemscope itemtype="https://schema.org/Person">
<meta itemprop="name" content="<?php $this->author(); ?>" />
<meta itemprop="url" content="<?php $this->author->permalink(); ?>" />
</div>
<h1 class="post-title" itemprop="headline"><a href="<?php $this->permalink() ?>" itemprop="url"><?php $this->title() ?></a></h1>
<ul class="post-meta">
<li itemprop="datePublished" content="<?php $this->date('c'); ?>"><?php $this->date(); ?></li>
<li><?php $this->category(','); ?></li>
<li><a href="<?php $this->permalink() ?>#comments" itemprop="commentCount"><?php $this->commentsNum('暂无评论', '%d 条评论'); ?></a></li>
<li><?php Postviews($this); ?></li>
<li>最后更新：<span itemprop="dateModified" content="<?php echo date('c', $this->modified); ?>"><?php echo date('Y-m-d', $this->modified); ?></span></li>
</ul>
<div class="post-content" itemprop="articleBody">
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
} else{
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
<div class="license-box">
    <p>最后更新于 <?php echo date('Y-m-d', $this->modified); ?> 「部分内容存在时效性，如有失效请留言反馈」</p>
    <p>除注明外为 <?php $this->options->title(); ?> 原创文章，转载请注明出处。</p>
    <p><?php echo $this->options->LicenseInfo ? $this->options->LicenseInfo : '本作品采用 <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="license nofollow">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可。' ?></p>
    <p>本文链接：<a href="<?php $this->permalink(); ?>" target="_blank"><?php $this->permalink(); ?></a></p>
</div>
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