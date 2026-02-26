<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?php $this->options->charset(); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php if ($this->options->favicon): ?>
<link rel="shortcut icon" href="<?php $this->options->favicon(); ?>" />
<?php endif; ?>
<title><?php $this->archiveTitle(array(
'category'  =>  _t('分类 %s 下的文章'),
'search'    =>  _t('包含关键字 %s 的文章'),
'tag'       =>  _t('标签 %s 下的文章'),
'date'      =>  _t('在 %s 发布的文章'),
'author'    =>  _t('作者 %s 发布的文章')
), '', ' - '); ?><?php $this->options->title(); if ($this->is('index') && $this->options->subTitle): ?> - <?php $this->options->subTitle(); endif; ?></title>
<meta name="author" content="<?php $this->author(); ?>" />
<!-- Robots Meta Tag -->
<meta name="robots" content="index, follow" />
<?php
/** * 1. 统一描述 (Description) 获取与清洗逻辑 
 */
$desc = '';
if ($this->is('post') || $this->is('page')) {
    // 优先从自定义字段 description 读取，否则取摘要
    $desc = !empty($this->fields->description) ? $this->fields->description : $this->excerpt;
} else {
    $desc = $this->options->description;
}
// 清洗数据：去掉 HTML 标签、换行符、多余空格，并转义双引号防止 JSON 报错
$desc = str_replace(["\r", "\n", "\t", '"'], ' ', strip_tags($desc));
$desc = mb_substr(trim($desc), 0, 150, 'utf-8'); // 限制 150 字以内

/** * 2. 统一封面图 (Image) 获取逻辑 
 */
$cover = '';
if ($this->is('post') || $this->is('page')) {
    if (!empty($this->fields->thumb)) {
        $cover = $this->fields->thumb;
    } elseif ($this->options->autoFetchCover && preg_match('/<img.*?src="(.*?)"/', $this->content, $matches)) {
        $cover = $matches[1];
    } else {
        $cover = $this->options->defaultCover ? $this->options->defaultCover : $this->options->themeUrl . '/img/default-cover.webp';
    }
} elseif ($this->is('index')) {
    $cover = $this->options->homeCover ? $this->options->homeCover : $this->options->themeUrl . '/img/home-cover.webp';
} else {
    $cover = $this->options->defaultCover ? $this->options->defaultCover : $this->options->themeUrl . '/img/default-cover.webp';
}
?>

<meta name="description" content="<?php echo $desc; ?>" />
<meta property="og:image" content="<?php echo $cover; ?>" />

<?php if ($this->is('index') || $this->is('post') || $this->is('page')): ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "<?php echo $this->is('post') ? 'BlogPosting' : ($this->is('page') ? 'WebPage' : 'WebSite'); ?>",
  "name": "<?php $this->archiveTitle('', '', ''); ?>",
  "description": "<?php echo $desc; ?>",
  "url": "<?php $this->permalink(); ?>",
  "image": "<?php echo $cover; ?>",
  "publisher": {
    "@type": "Organization",
    "name": "<?php $this->options->title(); ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo $this->options->logoUrl ? $this->options->logoUrl : $this->options->siteUrl . 'logo.png'; ?>"
    }
  }
  <?php if ($this->is('post') || $this->is('page')): ?>
  ,"datePublished": "<?php $this->date('c'); ?>",
  "dateModified": "<?php echo date('c', $this->modified); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php $this->author(); ?>"
  }
  <?php endif; ?>
}
</script>
<?php endif; ?>

<?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&antiSpam=&atom='); ?>
<link rel="stylesheet" href="<?php cjUrl('style.min.css') ?>" />
<?php if ($this->options->CustomCSS): ?>
<style type="text/css"><?php $this->options->CustomCSS(); ?></style>
<?php endif; ?>
</head>
<body class="<?php if ($this->options->OneCOL): ?>one-col<?php else: ?>bd<?php endif; if ($this->options->HeadFixed): ?> head-fixed<?php endif; ?>">
<!--[if lt IE 9]>
<div class="browsehappy">当前网页可能 <strong>不支持</strong> 您正在使用的浏览器. 为了正常的访问, 请 <a href="https://browsehappy.com/">升级您的浏览器</a>.</div>
<![endif]-->
<header id="header">
<div class="container clearfix">
<div class="site-name">
<<?php echo $this->is('post') || $this->is('page') ? 'p' : 'h1' ?> class="site-title">
<a id="logo" href="<?php $this->options->siteUrl(); ?>" rel="home"><?php if ($this->options->logoUrl && ($this->options->titleForm == 'logo' || $this->options->titleForm == 'all')): ?><img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" title="<?php $this->options->title() ?>" /><?php endif; ($this->options->titleForm == 'logo' && $this->options->logoUrl) ? '' : ($this->options->customTitle ? $this->options->customTitle() : $this->options->title()) ?>
</a>
</<?php echo $this->is('post') || $this->is('page') ? 'p' : 'h1' ?>>
</div>
<script>function Navswith(){document.getElementById("header").classList.toggle("on")}</script>
<button id="nav-swith" onclick="Navswith()"><span></span></button>
<div id="nav">
<div id="site-search">
<form id="search" method="post" action="<?php $this->options->siteUrl(); ?>">
<input type="text" id="s" name="s" class="text" placeholder="输入关键字搜索" required />
<button type="submit"></button>
</form>
</div>
<ul class="nav-menu">
<li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
<?php if (!empty($this->options->Navset) && in_array('ShowCategory', $this->options->Navset)): if (in_array('AggCategory', $this->options->Navset)): ?>
<li class="menu-parent"><a><?php echo $this->options->CategoryText ? $this->options->CategoryText : '分类' ?></a>
<ul>
<?php
endif;
$this->widget('Widget_Metas_Category_List')->to($categorys);
while($categorys->next()):
if ($categorys->levels == 0):
$children = $categorys->getAllChildren($categorys->mid);
if (empty($children)):
?>
<li><a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?></a></li>
<?php else: ?>
<li class="menu-parent">
<a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?></a>
<ul class="menu-child">
<?php foreach ($children as $mid) {
$child = $categorys->getCategory($mid); ?>
<li><a href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?></a></li>
<?php } ?>
</ul>
</li>
<?php
endif;
endif;
endwhile;
?>
<?php if (in_array('AggCategory', $this->options->Navset)): ?>
</ul>
</li>
<?php
endif;
endif;
if (!empty($this->options->Navset) && in_array('ShowPage', $this->options->Navset)):
if (in_array('AggPage', $this->options->Navset)):
?>
<li class="menu-parent"><a><?php echo $this->options->PageText ? $this->options->PageText : '其他' ?></a>
<ul>
<?php
endif;
$this->widget('Widget_Contents_Page_List')->to($pages);
while($pages->next()):
?>
<li><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
<?php endwhile;
if (in_array('AggPage', $this->options->Navset)): ?>
</ul>
</li>
<?php endif;
endif; ?>
</ul>
</div>
</div>
</header>
<?php if ($this->options->Announcement && $this->options->AnnouncementContent): ?>
<div class="announcement">
	<div class="container">
		<?php echo $this->options->AnnouncementContent; ?>
	</div>
</div>
<?php endif; ?>
<div id="body"<?php if ($this->options->PjaxOption): ?> in-pjax<?php endif; ?>>
<div class="container clearfix">
<div id="main">
