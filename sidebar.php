<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="secondary"<?php if ($this->options->SidebarFixed): ?> sidebar-fixed<?php endif; ?>>
<?php if (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper)): ?>
<section class="widget">
<?php Whisper(1); ?>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowHotPosts', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">热门文章</h3>
<ul class="widget-list rec-post-list">
<?php Contents_Post_Initial($this->options->postsListSize, 'commentsNum'); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">最新文章</h3>
<ul class="widget-list rec-post-list">
<?php Contents_Post_Initial($this->options->postsListSize); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRandomPosts', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">随机文章</h3>
<ul class="widget-list rec-post-list">
<?php Contents_Post_Random($this->options->postsListSize); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">最近回复</h3>
<ul class="widget-list rec-com-list">
<?php $this->widget('Initial_Widget_Comments_Recent', in_array('IgnoreAuthor', $this->options->sidebarBlock) ? 'ignoreAuthor=1' : '')->to($comments); ?>
<?php if($comments->have()): ?>
<?php while($comments->next()): ?>
<?php 
$content_row = FindContent($comments->cid);
$content_widget = null;
if ($content_row) {
	$content_widget = Typecho_Widget::widget('Widget_Abstract_Contents');
	$content_widget->push($content_row);
}
$is_hidden = $content_widget && $content_widget->hidden;
$is_published = $content_widget && $content_widget->status == 'publish';
$is_whisper_template = $content_widget && $content_widget->template == 'page-whisper.php';
$show_link = !($is_hidden && $this->options->PjaxOption) && (!(!$is_published && !$is_whisper_template && $this->authorId !== $this->user->uid && !$this->user->pass('editor', true)));
$title_text = (!$is_published && !$is_whisper_template && $this->authorId !== $this->user->uid && !$this->user->pass('editor', true)) ? '此内容被作者隐藏' : $comments->title;
?>
<li><a <?php echo $show_link ? 'href="'.$comments->permalink.'" ' : '' ?>title="来自: <?php echo $title_text; ?>"><span class="comment-author-name"><?php $comments->author(false); ?></span><span class="comment-text">: <?php $comments->excerpt(35, '...'); ?></span></a></li>
<?php endwhile; ?>
<?php else: ?>
<li>暂无回复</li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">分类</h3>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Category_List')
->parse('<li><a href="{permalink}">{name}</a></li>'); ?>
</ul>
</section>
<?php endif; ?>
<!-- 侧边栏广告开始 -->
<?php if (isset($this->options->GoogleAdClient) && $this->options->GoogleAdClient && isset($this->options->GoogleAdSlotSidebar) && $this->options->GoogleAdSlotSidebar): ?>
<div class="gg-container  widget"<?php if (isset($this->options->GoogleAdSidebarStyle) && $this->options->GoogleAdSidebarStyle): ?> style="<?php $this->options->GoogleAdSidebarStyle(); ?>"<?php endif; ?>>
    <?php $this->options->GoogleAdSlotSidebar(); ?>
</div>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
<?php endif; ?>
<!-- 侧边栏广告结束 -->
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowTag', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">标签</h3>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
<?php if($tags->have()): ?>
<?php while($tags->next()): ?>
<li><a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a></li>
<?php endwhile; ?>
<?php else: ?>
<li>暂无标签</li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">归档</h3>
<ul class="widget-list">
<?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 n 月')
->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->ShowLinks) && in_array('sidebar', $this->options->ShowLinks)): ?>
<section class="widget">
<h3 class="widget-title">链接</h3>
<ul class="widget-tile">
<?php Links($this->options->IndexLinksSort); ?>
<?php $page_links = FindContents('page-links.php', 'order', 'a', 1);
if ($page_links):
	$widget = Typecho_Widget::widget('Widget_Abstract_Contents');
	$widget->push($page_links[0]);
?>
<li class="more"><a href="<?php echo $widget->permalink; ?>">查看更多...</a></li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowSiteStats', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">站点统计</h3>
<ul class="widget-list site-stats">
<?php $stats = getSiteStats(); ?>
<li>文章数量：<?php echo $stats['posts']; ?></li>
<li>评论数量：<?php echo $stats['comments']; ?></li>
<li>已运行：<?php echo $stats['runtime']; ?></li>
<li>总计码字：<?php echo $stats['words']; ?></li>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
<section class="widget">
<h3 class="widget-title">其它</h3>
<ul class="widget-list">
<li><a href="<?php $this->options->feedUrl(); ?>" target="_blank">文章 RSS</a></li>
<li><a href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank">评论 RSS</a></li>
<?php if($this->user->hasLogin()): ?>
<li><a href="<?php $this->options->adminUrl(); ?>" target="_blank">进入后台 (<?php $this->user->screenName(); ?>)</a></li>
<li><a href="<?php $this->options->logoutUrl(); ?>"<?php if ($this->options->PjaxOption): ?> no-pjax<?php endif; ?>>退出</a></li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
</div>
