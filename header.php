<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="<?php $this->options->charset(); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php if ($this->options->favicon): ?>
<link rel="shortcut icon" href="<?php $this->options->favicon(); ?>" />
<?php endif;
$options = Helper::options();
$currentPage = max(1, (int) $this->_currentPage);
$is404 = $this->is('archive', 404);

// 统一生成页面标题，分页必须包含页码，避免与第一页重复。
ob_start();
$this->archiveTitle(array(
'category'  =>  _t('分类 %s 下的文章'),
'search'    =>  _t('包含关键字 %s 的文章'),
'tag'       =>  _t('标签 %s 下的文章'),
'date'      =>  _t('在 %s 发布的文章'),
'author'    =>  _t('作者 %s 发布的文章')
), '', ' - ');
$pageTitle = ob_get_clean() . $options->title;
if ($currentPage > 1) {
    $pageTitle .= ' - ' . _t('第 %d 页', $currentPage);
} elseif ($this->is('index') && $options->subTitle) {
    $pageTitle .= ' - ' . $options->subTitle;
}

// 密码保护文章只公开标题，不从受保护正文提取摘要。
if ($this->is('post') || $this->is('page')) {
    $desc = !empty($this->fields->description)
        ? $this->fields->description
        : ($this->hidden ? $this->title : $this->excerpt);
} else {
    $desc = $options->description;
}
$desc = preg_replace('/\s+/u', ' ', strip_tags($desc));
$desc = mb_substr(trim($desc), 0, 160, 'UTF-8');

// 密码保护文章不从正文提取社交封面。
if ($this->is('post') || $this->is('page')) {
    if (!empty($this->fields->thumb) && !is_numeric($this->fields->thumb)) {
        $cover = $this->fields->thumb;
    } elseif (!$this->hidden && $options->autoFetchCover && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $this->content, $matches)) {
        $cover = $matches[1];
    } else {
        $cover = $options->defaultCover ?: $options->themeUrl . '/img/default-cover.webp';
    }
} elseif ($this->is('index')) {
    $cover = $options->homeCover ?: $options->themeUrl . '/img/home-cover.webp';
} else {
    $cover = $options->defaultCover ?: $options->themeUrl . '/img/default-cover.webp';
}

// 第一页使用 Typecho 归档地址，后续分页使用当前路径并移除查询参数。
if ($this->is('index') && $currentPage === 1) {
    $canonical = $options->siteUrl;
} elseif ($currentPage > 1 || $is404) {
    $canonical = strtok($this->request->getRequestUrl(), '?');
} else {
    $canonical = $this->getArchiveUrl();
}

$schemaTitle = ($this->is('post') || $this->is('page')) ? $this->title : $options->title;
$logo = $options->logoUrl ?: $options->themeUrl . '/img/logo.webp';
?>
<title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
<meta name="author" content="<?php $this->author(); ?>" />
<meta name="description" content="<?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="robots" content="<?php echo ($this->is('search') || $is404) ? 'noindex,follow' : 'index,follow'; ?>" />
<?php if (!$this->is('post') && !$this->is('page') && !$is404): ?>
<link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>" />
<?php endif; ?>
<meta property="og:type" content="<?php echo $this->is('post') ? 'article' : 'website'; ?>" />
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:description" content="<?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:url" content="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:image" content="<?php echo htmlspecialchars($cover, ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:site_name" content="<?php echo htmlspecialchars($options->title, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="twitter:description" content="<?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="twitter:image" content="<?php echo htmlspecialchars($cover, ENT_QUOTES, 'UTF-8'); ?>" />
<?php if ($this->is('post')): ?>
<meta property="article:author" content="<?php $this->author(); ?>" />
<meta property="article:published_time" content="<?php $this->date('c'); ?>" />
<meta property="article:modified_time" content="<?php echo date('c', $this->modified); ?>" />
<?php endif; ?>

<?php if ($this->is('index') || $this->is('post') || $this->is('page')):
$schema = array(
    '@context' => 'https://schema.org',
    '@type' => $this->is('post') ? 'BlogPosting' : ($this->is('page') ? 'WebPage' : 'WebSite'),
    'name' => $schemaTitle,
    'headline' => $schemaTitle,
    'description' => $desc,
    'url' => $canonical,
    'image' => $cover,
    'publisher' => array(
        '@type' => 'Organization',
        'name' => $options->title,
        'logo' => array('@type' => 'ImageObject', 'url' => $logo)
    )
);
if ($this->is('post') || $this->is('page')) {
    ob_start();
    $this->date('c');
    $schema['datePublished'] = ob_get_clean();
    $schema['dateModified'] = date('c', $this->modified);
    $schema['author'] = array(
        '@type' => 'Person',
        'name' => $this->author->screenName,
        'url' => $this->author->permalink
    );
}
?>
<script type="application/ld+json"><?php echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
<?php endif; ?>

<?php // description 和 social 由主题输出，避免与 Typecho 1.3 核心重复。
$this->header('description=&social=&generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&antiSpam=&atom='); ?>
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
<button id="nav-swith" onclick="Navswith()" aria-label="切换导航菜单"><span></span></button>
<nav id="nav">
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
</nav>
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
<main id="main">
