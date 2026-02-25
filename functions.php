<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
error_reporting(0);
define('INITIAL_VERSION_NUMBER', '3.1.0');
if (Helper::options()->GravatarUrl) define('__TYPECHO_GRAVATAR_PREFIX__', Helper::options()->GravatarUrl);

function themeConfig($form) {
	$logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点标题 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以显示网站标题 LOGO'));
	$form->addInput($logoUrl);

	$customTitle = new Typecho_Widget_Helper_Form_Element_Text('customTitle', NULL, NULL, _t('自定义站点标题'), _t('仅用于替换页面头部位置的“标题”显示，和Typecho后台设置的站点名称不冲突，留空则显示默认站点名称'));
	$form->addInput($customTitle);

	$titleForm = new Typecho_Widget_Helper_Form_Element_Radio('titleForm', 
	array('title' => _t('仅文字'),
	'logo' => _t('仅LOGO'),
	'all' => _t('LOGO+文字')),
	'title', _t('站点标题显示内容'), _t('默认仅显示文字标题，若要显示LOGO，请在上方添加 LOGO 地址'));
	$form->addInput($titleForm);

	$subTitle = new Typecho_Widget_Helper_Form_Element_Text('subTitle', NULL, NULL, _t('自定义站点副标题'), _t('浏览器副标题，仅在当前页面为首页时显示，显示格式为：<b>标题 - 副标题</b>，留空则不显示副标题'));
	$form->addInput($subTitle);

	$favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('Favicon 地址'), _t('在这里填入一个图片 URL 地址, 以添加一个Favicon，留空则不单独设置Favicon'));
	$form->addInput($favicon);

	$CustomCSS = new Typecho_Widget_Helper_Form_Element_Textarea('CustomCSS', NULL, NULL, _t('自定义样式'), _t('在这里填入你的自定义样式（直接填入css，无需&lt;style&gt;标签）'));
	$form->addInput($CustomCSS);

	$cjcdnAddress = new Typecho_Widget_Helper_Form_Element_Text('cjcdnAddress', NULL, NULL, _t('主题静态文件（css和js）的链接地址替换'), _t('请输入你的CDN云存储地址，例如：<b class="notice">//cdn.jsdelivr.net/gh/jielive/initial/</b><br><b>被替换的原地址为主题文件位置，即：http://www.example.com/usr/themes/initial/</b>'));
	$form->addInput($cjcdnAddress);

	$AttUrlReplace = new Typecho_Widget_Helper_Form_Element_Textarea('AttUrlReplace', NULL, NULL, _t('文章内的链接地址替换（建议用在图片等静态资源的链接上）'), _t('按照格式输入你的CDN链接以替换原链接，格式：<br><b class="notice">原地址=替换地址</b><br>原地址与新地址之间用等号“=”分隔，例如：<br><b>http://www.example.com/usr/uploads/=http://cdn.example.com/usr/uploads/</b><br>可设置多个规则，换行即可，一行一个'));
	$form->addInput($AttUrlReplace);

	$Navset = new Typecho_Widget_Helper_Form_Element_Checkbox('Navset', 
	array('ShowCategory' => _t('显示分类'),
	'AggCategory' => _t('↪合并分类'),
	'ShowPage' => _t('显示页面'),
	'AggPage' => _t('↪合并页面')),
	array('ShowCategory', 'AggCategory', 'ShowPage'), _t('导航栏显示'), _t('默认显示合并的分类，显示页面'));
	$form->addInput($Navset->multiMode());

	$CategoryText = new Typecho_Widget_Helper_Form_Element_Text('CategoryText', NULL, NULL, _t('导航栏-分类 下拉菜单显示名称（使用“导航栏显示-合并分类”时生效）'), _t('在这里输入导航栏<b>分类</b>下拉菜单的显示名称,留空则默认显示为“分类”'));
	$form->addInput($CategoryText);

	$PageText = new Typecho_Widget_Helper_Form_Element_Text('PageText', NULL, NULL, _t('导航栏-页面 下拉菜单显示名称（使用“导航栏显示-合并页面”时生效）'), _t('在这里输入导航栏<b>页面</b>下拉菜单的显示名称,留空则默认显示为“其他”'));
	$form->addInput($PageText);

	$Breadcrumbs = new Typecho_Widget_Helper_Form_Element_Checkbox('Breadcrumbs', 
	array('Postshow' => _t('文章内显示'),
	'Text' => _t('↪文章标题替换为“正文”'),
	'Pageshow' => _t('页面内显示')),
	array('Postshow', 'Text', 'Pageshow'), _t('面包屑导航显示'), _t('默认在文章与页面内显示，并将文章标题替换为“正文”'));
	$form->addInput($Breadcrumbs->multiMode());

	$WeChat = new Typecho_Widget_Helper_Form_Element_Text('WeChat', NULL, NULL, _t('微信打赏二维码（建议图片尺寸不低于240*240）'), _t('在这里填入一个图片 URL 地址, 以添加一个微信打赏二维码，留空则不设置微信打赏'));
	$form->addInput($WeChat);

	$Alipay = new Typecho_Widget_Helper_Form_Element_Text('Alipay', NULL, NULL, _t('支付宝打赏二维码（建议图片尺寸不低于240*240）'), _t('在这里填入一个图片 URL 地址, 以添加一个支付宝打赏二维码，留空则不设置支付宝打赏'));
	$form->addInput($Alipay);

	$LicenseInfo = new Typecho_Widget_Helper_Form_Element_Text('LicenseInfo', NULL, NULL, _t('文章许可信息'), _t('填入后将在文章底部显示你填入的许可信息（支持HTML标签，输入数字“0”可关闭显示），留空则默认使用 (CC BY-SA 4.0)国际许可协议。'));
	$form->addInput($LicenseInfo);

	$HeadFixed = new Typecho_Widget_Helper_Form_Element_Radio('HeadFixed', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('浮动显示头部'), _t('默认关闭'));
	$form->addInput($HeadFixed);

	$SidebarFixed = new Typecho_Widget_Helper_Form_Element_Radio('SidebarFixed', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('动态显示侧边栏'), _t('默认关闭'));
	$form->addInput($SidebarFixed);

	$cjCDN = new Typecho_Widget_Helper_Form_Element_Radio('cjCDN', 
	array('jd' => _t('jsDelivr'),
	'sc' => _t('Staticfile'),
	'cf' => _t('CDNJS')),
	'cf', _t('公共静态资源来源'), _t('默认CDNJS，若JS文件异常，可尝试切换来源'));
	$form->addInput($cjCDN);

	$GravatarUrl = new Typecho_Widget_Helper_Form_Element_Radio('GravatarUrl', 
	array(false => _t('官方源'),
	'https://cravatar.com/avatar/' => _t('国内源'),
	'https://weavatar.com/avatar/' => _t('weavatar源'),
	'https://gravatar.loli.net/avatar/' => _t('loli源'),
	'https://cdn.sep.cc/avatar/' => _t('sep源'),
	'https://dn-qiniu-avatar.qbox.me/avatar/' => _t('七牛源')),
	'https://cravatar.com/avatar/', _t('Gravatar头像源'), _t('默认国内源，若头像显示异常，可尝试切换来源'));
	$form->addInput($GravatarUrl);

	$compressHtml = new Typecho_Widget_Helper_Form_Element_Radio('compressHtml', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('HTML压缩'), _t('默认关闭，启用则会对HTML代码进行压缩，可能与部分插件存在兼容问题，请酌情选择开启或者关闭'));
	$form->addInput($compressHtml);

	$PjaxOption = new Typecho_Widget_Helper_Form_Element_Radio('PjaxOption', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('全站Pjax'), _t('默认关闭，启用则会强制关闭“反垃圾保护”，强制“将较新的的评论显示在前面”'));
	$form->addInput($PjaxOption);

	$AjaxLoad = new Typecho_Widget_Helper_Form_Element_Radio('AjaxLoad', 
	array('auto' => _t('自动'),
	'click' => _t('点击'),
	0 => _t('关闭')),
	0, _t('Ajax翻页'), _t('默认关闭，启用则会使用Ajax加载下一页的文章'));
	$form->addInput($AjaxLoad);

	$Highlight = new Typecho_Widget_Helper_Form_Element_Radio('Highlight', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('代码高亮'), _t('默认关闭，启用则会渲染页面内代码块”'));
	$form->addInput($Highlight);

	$catalog = new Typecho_Widget_Helper_Form_Element_Radio('catalog', 
	array('post' => _t('使用文章内设定'),
	'open' => _t('全部启用'),
	0 => _t('全部关闭')),
	'post', _t('文章目录'), _t('一键开关全部文章目录，默认使用文章内的设定，（若文章内无任何标题，则不显示目录）'));
	$form->addInput($catalog);

	$scrollTop = new Typecho_Widget_Helper_Form_Element_Radio('scrollTop', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('返回顶部'), _t('默认关闭，启用将在右下角显示“返回顶部”按钮'));
	$form->addInput($scrollTop);

	$MusicSet = new Typecho_Widget_Helper_Form_Element_Radio('MusicSet', 
	array('order' => _t('顺序播放'),
	'shuffle' => _t('随机播放'),
	0 => _t('关闭')),
	0, _t('背景音乐'), _t('默认关闭，启用后请填写音乐地址,否则开启无效'));
	$form->addInput($MusicSet);

	$MusicUrl = new Typecho_Widget_Helper_Form_Element_Textarea('MusicUrl', NULL, NULL, _t('背景音乐地址（建议使用mp3格式）'), _t('请输入完整的音频文件路径，例如：<br>https://music.163.com/song/media/outer/url?id=<b class="notice">{MusicID}</b>.mp3<br>可设置多个音频，换行即可，一行一个，留空则关闭背景音乐'));
	$form->addInput($MusicUrl);

	$MusicVol = new Typecho_Widget_Helper_Form_Element_Text('MusicVol', NULL, NULL, _t('背景音乐播放音量（输入范围：0~1）'), _t('请输入一个0到1之间的小数（0为静音  0.5为50%音量  1为100%最大音量）输入错误内容或留空则使用默认音量100%'));
	$form->addInput($MusicVol);

	$InsideLinksIcon = new Typecho_Widget_Helper_Form_Element_Radio('InsideLinksIcon', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('显示链接图标（内页）'), _t('默认关闭，启用后内页（链接模板）链接将显示链接图标'));
	$form->addInput($InsideLinksIcon);

	$IndexLinksSort = new Typecho_Widget_Helper_Form_Element_Text('IndexLinksSort', NULL, NULL, _t('首页显示的链接分类（支持多分类，请用英文逗号“,”分隔）'), _t('若只需显示某分类下的链接，请输入链接分类名（建议使用字母形式的分类名），留空则默认显示全部链接'));
	$form->addInput($IndexLinksSort);

	$InsideLinksSort = new Typecho_Widget_Helper_Form_Element_Text('InsideLinksSort', NULL, NULL, _t('内页（链接模板）显示的链接分类（支持多分类，请用英文逗号“,”分隔）'), _t('若只需显示某分类下的链接，请输入链接分类名（建议使用字母形式的分类名），留空则默认显示全部链接'));
	$form->addInput($InsideLinksSort);

	$ShowLinks = new Typecho_Widget_Helper_Form_Element_Checkbox('ShowLinks', array('footer' => _t('页脚'), 'sidebar' => _t('侧边栏')), NULL, _t('首页显示链接'));
	$form->addInput($ShowLinks->multiMode());

	$ShowWhisper = new Typecho_Widget_Helper_Form_Element_Checkbox('ShowWhisper', array('index' => _t('首页'), 'sidebar' => _t('侧边栏')), NULL, _t('显示最新的“轻语”'));
	$form->addInput($ShowWhisper->multiMode());

	$sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
	array('ShowHotPosts' => _t('显示热门文章（根据评论数量排序）'),
	'ShowRecentPosts' => _t('显示最新文章'),
	'ShowRandomPosts' => _t('显示随机文章'),
	'ShowRecentComments' => _t('显示最近回复'),
	'IgnoreAuthor' => _t('↪不显示作者回复'),
	'ShowCategory' => _t('显示分类'),
	'ShowTag' => _t('显示标签'),
	'ShowArchive' => _t('显示归档'),
	'ShowSiteStats' => _t('显示站点统计'),
	'ShowOther' => _t('显示其它杂项')),
	array('ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowTag', 'ShowArchive', 'ShowOther'), _t('侧边栏显示'));
	$form->addInput($sidebarBlock->multiMode());

	$SiteStatsDateType = new Typecho_Widget_Helper_Form_Element_Radio('SiteStatsDateType',
	array('first' => _t('使用第一篇文章日期'),
	'custom' => _t('使用自定义日期')),
	'first', _t('站点运行时间起始日期'), _t('选择站点运行时间的计算方式'));
	$form->addInput($SiteStatsDateType);

	$SiteStatsCustomDate = new Typecho_Widget_Helper_Form_Element_Text('SiteStatsCustomDate', NULL, NULL, _t('自定义起始日期'), _t('格式：2024-01-01，仅在选择\"使用自定义日期\"时生效'));
	$form->addInput($SiteStatsCustomDate);

	$OneCOL = new Typecho_Widget_Helper_Form_Element_Radio('OneCOL', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('单栏模式'), _t('关闭侧边栏，仅显示主栏内容。'));
	$form->addInput($OneCOL);

	$ICPbeian = new Typecho_Widget_Helper_Form_Element_Text('ICPbeian', NULL, NULL, _t('ICP备案号'), _t('在这里输入ICP备案号,留空则不显示'));
	$form->addInput($ICPbeian);

	$Gonganbeian = new Typecho_Widget_Helper_Form_Element_Text('Gonganbeian', NULL, NULL, _t('公安备案号'), _t('在这里输入公安备案号,留空则不显示'));
	$form->addInput($Gonganbeian);

	$CustomContent = new Typecho_Widget_Helper_Form_Element_Textarea('CustomContent', NULL, NULL, _t('底部自定义内容'), _t('位于底部，footer之后body之前，适合放置一些JS内容，如网站统计代码等（若开启全站Pjax，目前支持Google和百度统计的回调，其余统计代码可能会不准确）'));
	$form->addInput($CustomContent);

	$Announcement = new Typecho_Widget_Helper_Form_Element_Radio('Announcement', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('公告栏'), _t('默认关闭，启用后将在页面顶部显示公告栏'));
	$form->addInput($Announcement);

	$AnnouncementContent = new Typecho_Widget_Helper_Form_Element_Textarea('AnnouncementContent', NULL, NULL, _t('公告栏内容'), _t('在这里输入公告栏内容，支持HTML标签，留空则不显示公告栏<br><b class="notice">CSS类名提示：</b><br>• 公告栏容器：<code>.announcement</code><br>• 内容容器：<code>.announcement .container</code><br><b class="notice">示例样式（可复制到「自定义样式」）：</b><br><code>.announcement { background: #fff3cd; color: #856404; padding: 10px 0; margin-bottom: 20px; border-bottom: 1px solid #ffeeba; } .announcement .container { text-align: center; }</code>'));
	$form->addInput($AnnouncementContent);

	// Google广告设置开始
	$GoogleAdClient = new Typecho_Widget_Helper_Form_Element_Text('GoogleAdClient', NULL, NULL, _t('Google Ad Client ID'), _t('在这里输入Google广告的Client ID，格式为：ca-pub-xxxxxxxxxxxxxxxx，留空则不显示广告'));
	$form->addInput($GoogleAdClient);

	$GoogleAdSlotPost = new Typecho_Widget_Helper_Form_Element_Textarea('GoogleAdSlotPost', NULL, NULL, _t('Google-文章底部广告代码'), _t('提示：后台已配置优化，无需填写完整广告代码<br>只需填写广告的核心内容，完整的&lt;ins&gt;标签内容<br>留空则不显示文章底部广告'));
	$GoogleAdSlotPost->input->setAttribute('class', 'w-100');
	$form->addInput($GoogleAdSlotPost);

	$GoogleAdPostStyle = new Typecho_Widget_Helper_Form_Element_Text('GoogleAdPostStyle', NULL, NULL, _t('Google-文章底部广告样式'), _t('在这里输入文章底部广告容器的CSS样式，如：margin: 20px 0; padding: 10px; background: #f5f5f5; 留空则使用默认样式'));
	$form->addInput($GoogleAdPostStyle);

	$GoogleAdSlotSidebar = new Typecho_Widget_Helper_Form_Element_Textarea('GoogleAdSlotSidebar', NULL, NULL, _t('Google-侧边栏广告代码'), _t('提示：后台已配置优化，无需填写完整广告代码<br>只需填写广告的核心内容，如Slot ID或完整的&lt;ins&gt;标签内容<br>留空则不显示侧边栏广告'));
	$GoogleAdSlotSidebar->input->setAttribute('class', 'w-100');
	$form->addInput($GoogleAdSlotSidebar);

	$GoogleAdSidebarStyle = new Typecho_Widget_Helper_Form_Element_Text('GoogleAdSidebarStyle', NULL, NULL, _t('Google-侧边栏广告样式'), _t('在这里输入侧边栏广告容器的CSS样式，如：margin: 20px 0; padding: 10px; background: #f5f5f5; 留空则使用默认样式'));
	$form->addInput($GoogleAdSidebarStyle);

	$GoogleRecaptchaReplace = new Typecho_Widget_Helper_Form_Element_Radio('GoogleRecaptchaReplace', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	1, _t('Google reCAPTCHA链接替换'), _t('默认启用，启用则会将Google reCAPTCHA的链接从www.google.com替换为www.recaptcha.net，确保reCAPTCHA在某些地区可以正常访问'));
	$form->addInput($GoogleRecaptchaReplace);
	// Google广告设置结束
	// 主题设置备份开始
	$str1 = explode('/themes/', Helper::options()->themeUrl);
	$str2 = explode('/', $str1[1]);
	$name=$str2[0];
	$db = Typecho_Db::get();
	$sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name));
	$ysj = $sjdq['value'];
	if(isset($_POST['type']))
	{ 
	if($_POST["type"]=="备份模板设置数据"){
	if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'))){
	$update = $db->update('table.options')->rows(array('value'=>$ysj))->where('name = ?', 'theme:'.$name.'bf');
	$updateRows= $db->query($update);
	echo '<div class="tongzhi col-mb-12 home">备份已更新，请等待自动刷新！如果等不到请点击';
	?>    
	<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
	<script language="JavaScript">window.setTimeout("location='<?php Helper::options()->adminUrl('options-theme.php'); ?>'", 2500);</script>
	<?php
	}else{
	if($ysj){
		$insert = $db->insert('table.options')
		->rows(array('name' => 'theme:'.$name.'bf','user' => '0','value' => $ysj));
		$insertId = $db->query($insert);
		echo '<div class="tongzhi col-mb-12 home">备份完成，请等待自动刷新！如果等不到请点击';
		?>    
		<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
		<script language="JavaScript">window.setTimeout("location='<?php Helper::options()->adminUrl('options-theme.php'); ?>'", 2500);</script>
		<?php
	}
	}
			}
	if($_POST["type"]=="还原模板设置数据"){
	if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'))){
	$sjdub=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'));
	$bsj = $sjdub['value'];
	$update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:'.$name);
	$updateRows= $db->query($update);
	echo '<div class="tongzhi col-mb-12 home">检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击';
	?>    
	<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
	<script language="JavaScript">window.setTimeout("location='<?php Helper::options()->adminUrl('options-theme.php'); ?>'", 2000);</script>
	<?php
	}else{
	echo '<div class="tongzhi col-mb-12 home">没有模板备份数据，恢复不了哦！</div>';
	}
	}
	if($_POST["type"]=="删除备份数据"){
	if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'))){
	$delete = $db->delete('table.options')->where ('name = ?', 'theme:'.$name.'bf');
	$deletedRows = $db->query($delete);
	echo '<div class="tongzhi col-mb-12 home">删除成功，请等待自动刷新，如果等不到请点击';
	?>    
	<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
	<script language="JavaScript">window.setTimeout("location='<?php Helper::options()->adminUrl('options-theme.php'); ?>'", 2500);</script>
	<?php
	}else{
	echo '<div class="tongzhi col-mb-12 home">不用删了！备份不存在！！！</div>';
	}
	}
		}
	echo '<form class="protected home col-mb-12" action="?'.$name.'bf" method="post">
	<input type="submit" name="type" class="btn btn-s" value="备份模板设置数据" />&nbsp;&nbsp;<input type="submit" name="type" class="btn btn-s" value="还原模板设置数据" />&nbsp;&nbsp;<input type="submit" name="type" class="btn btn-s" value="删除备份数据" /></form>';
	// 主题设置备份结束
}

function themeInit($archive) {
	$options = Helper::options();
	$options->commentsAntiSpam = false;
	if ($options->PjaxOption || FindContents('page-whisper.php', 'commentsNum', 'd')) {
		$options->commentsOrder = 'DESC';
		$options->commentsPageDisplay = 'first';
	}
	if ($archive->is('single')) {
		$archive->content = hrefOpen($archive->content);
		if ($options->AttUrlReplace) {
			$archive->content = UrlReplace($archive->content);
		}
		if ($archive->is('post') && (($options->catalog == 'post' && $archive->fields->catalog) || $options->catalog == 'open')) {
			$archive->content = createCatalog($archive->content);
		}
	}
}

function cjUrl($path) {
	$options = Helper::options();
	$ver = '?ver='.constant("INITIAL_VERSION_NUMBER");
	if ($options->cjcdnAddress) {
		echo rtrim($options->cjcdnAddress, '/').'/'.$path.$ver;
	} else {
		$options->themeUrl($path.$ver);
	}
}

function hrefOpen($obj) {
	return preg_replace('/<a\b([^>]+?)\bhref="((?!'.addcslashes(Helper::options()->index, '/._-+=#?&').'|\#).*?)"([^>]*?)>/i', '<a\1href="\2"\3 target="_blank">', $obj);
}

function UrlReplace($obj) {
	$list = explode(PHP_EOL, Helper::options()->AttUrlReplace);
	foreach ($list as $tmp) {
		list($old, $new) = explode('=', $tmp);
		$obj = str_replace($old, $new, $obj);
	}
	return $obj;
}

function postThumb($obj) {
	$thumb = $obj->fields->thumb;
	if (!$thumb) {
		return false;
	}
	if (is_numeric($thumb)) {
		preg_match_all('/<img.*?src="(.*?)".*?[\/]?>/i', $obj->content, $matches);
		if (isset($matches[1][$thumb-1])) {
			$thumb = $matches[1][$thumb-1];
		} else {
			return false;
		}
	}
	if (Helper::options()->AttUrlReplace) {
		$thumb = UrlReplace($thumb);
	}
	return '<img src="'.$thumb.'" />';
}

function Postviews($archive) {
	$db = Typecho_Db::get();
	$cid = $archive->cid;
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
	}
	$exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
	if ($archive->is('single')) {
		$cookie = Typecho_Cookie::get('contents_views');
		$cookie = $cookie ? explode(',', $cookie) : array();
		if (!in_array($cid, $cookie)) {
			$db->query($db->update('table.contents')
				->rows(array('views' => (int)$exist+1))
				->where('cid = ?', $cid));
			$exist = (int)$exist+1;
			array_push($cookie, $cid);
			$cookie = implode(',', $cookie);
			Typecho_Cookie::set('contents_views', $cookie);
		}
	}
	echo $exist == 0 ? '暂无阅读' : $exist.' 次阅读';
}

function getSiteStats() {
    $db = Typecho_Db::get();
    $stat = Typecho_Widget::widget('Widget_Stat');
    $options = Helper::options();
    
    $stats = array();
    
    $stats['posts'] = $stat->publishedPostsNum;
    
    $commentCount = $db->fetchObject($db->select(array('COUNT(coid)' => 'num'))
        ->from('table.comments')
        ->where('status = ?', 'approved'));
    $stats['comments'] = $commentCount->num;
    
    $startTime = 0;
    
    if ($options->SiteStatsDateType == 'custom' && !empty($options->SiteStatsCustomDate)) {
        $startTime = strtotime($options->SiteStatsCustomDate);
    }
    
    if ($startTime <= 0) {
        $firstPost = $db->fetchRow($db->select('created')->from('table.contents')
            ->where('type = ?', 'post')
            ->where('status = ?', 'publish')
            ->order('created', Typecho_Db::SORT_ASC)
            ->limit(1));
        if ($firstPost) {
            $startTime = $firstPost['created'];
        }
    }
    
    if ($startTime > 0) {
        $days = floor((time() - $startTime) / 86400);
        $stats['runtime'] = $days . ' 天';
    } else {
        $stats['runtime'] = '0 天';
    }
    
    $totalWords = 0;
    $posts = $db->fetchAll($db->select('text')->from('table.contents')
        ->where('type = ?', 'post')
        ->where('status = ?', 'publish'));
    foreach ($posts as $post) {
        $text = strip_tags($post['text']);
        $text = preg_replace('/\[.*?\]/', '', $text);
        $text = preg_replace('/\s/', '', $text);
        $totalWords += mb_strlen($text, 'UTF-8');
    }
    
    if ($totalWords >= 10000) {
        $stats['words'] = round($totalWords / 10000, 1) . ' 万字';
    } else {
        $stats['words'] = $totalWords . ' 字';
    }
    
    return $stats;
}

function Breadcrumbs($archive) {
	$options = Helper::options();
	if (!empty($options->Breadcrumbs) && in_array('Pageshow', $options->Breadcrumbs)) {
		echo '<div class="breadcrumbs">'.PHP_EOL .'<a href="'.$options->siteUrl.'">首页</a> &raquo; '.$archive->title.PHP_EOL .'</div>'.PHP_EOL;
	}
}

function createCatalog($obj) {
	global $catalog;
	global $catalog_count;
	$catalog = array();
	$catalog_count = 0;
	$obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($obj) {
		global $catalog;
		global $catalog_count;
		$catalog_count ++;
		$catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
		return '<h'.$obj[1].$obj[2].'><a class="cl-offset" name="cl-'.$catalog_count.'"></a>'.$obj[3].'</h'.$obj[1].'>';
	}, $obj);
	return $obj.PHP_EOL .getCatalog();
}

function getCatalog() {
	global $catalog;
	$index = '';
	if ($catalog) {
		$index = '<ul>'.PHP_EOL;
		$prev_depth = '';
		$to_depth = 0;
		foreach($catalog as $catalog_item) {
			$catalog_depth = $catalog_item['depth'];
			if ($prev_depth) {
				if ($catalog_depth == $prev_depth) {
					$index .= '</li>'.PHP_EOL;
				} elseif ($catalog_depth > $prev_depth) {
					$to_depth++;
					$index .= PHP_EOL .'<ul>'.PHP_EOL;
				} else {
					$to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
					if ($to_depth2) {
						for ($i=0; $i<$to_depth2; $i++) {
							$index .= '</li>'.PHP_EOL .'</ul>'.PHP_EOL;
							$to_depth--;
						}
					}
					$index .= '</li>'.PHP_EOL;
				}
			}
			$index .= '<li><a href="#cl-'.$catalog_item['count'].'" onclick="Catalogswith()">'.$catalog_item['text'].'</a>';
			$prev_depth = $catalog_depth;
		}
		for ($i=0; $i<=$to_depth; $i++) {
			$index .= '</li>'.PHP_EOL .'</ul>'.PHP_EOL;
		}
	$index = '<div id="catalog-col">'.PHP_EOL .'<b>文章目录</b>'.PHP_EOL .$index.'<script>function Catalogswith(){document.getElementById("catalog-col").classList.toggle("catalog");document.getElementById("catalog").classList.toggle("catalog")}</script>'.PHP_EOL .'</div>'.PHP_EOL;
	}
	return $index;
}

function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {
	$options = Helper::options();
	$autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;
	$noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;
	if ($obj->url && $autoLink) {
		echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
	} else {
		echo $obj->author;
	}
}

function CommentAt($coid){
	$db = Typecho_Db::get();
	$prow = $db->fetchRow($db->select('parent')->from('table.comments')
		->where('coid = ? AND status = ?', $coid, 'approved'));
	$parent = $prow['parent'];
	if ($prow && $parent != '0') {
		$arow = $db->fetchRow($db->select('author')->from('table.comments')
			->where('coid = ? AND status = ?', $parent, 'approved'));
		echo '<b class="comment-at">@'.$arow['author'].'</b>';
	}
}

function Contents_Post_Initial($limit = 10, $order = 'created') {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$posts = $db->fetchAll($db->select()->from('table.contents')
		->where('type = ? AND status = ? AND created < ?', 'post', 'publish', $options->time)
		->order($order, Typecho_Db::SORT_DESC)
		->limit($limit));
	if ($posts) {
		$widget = Typecho_Widget::widget('Widget_Abstract_Contents');
		foreach($posts as $post) {
			$widget->push($post);
			echo '<li><a'.($widget->hidden && $options->PjaxOption ? '' : ' href="'.$widget->permalink.'"').'>'.htmlspecialchars($widget->title).'</a></li>'.PHP_EOL;
		}
	} else {
		echo '<li>暂无文章</li>'.PHP_EOL;
	}
}

function Contents_Post_Random($limit = 10) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$posts = $db->fetchAll($db->select()->from('table.contents')
		->where('type = ? AND status = ? AND created < ?', 'post', 'publish', $options->time)
		->order('RAND()')
		->limit($limit));
	if ($posts) {
		$widget = Typecho_Widget::widget('Widget_Abstract_Contents');
		foreach($posts as $post) {
			$widget->push($post);
			echo '<li><a'.($widget->hidden && $options->PjaxOption ? '' : ' href="'.$widget->permalink.'"').'>'.htmlspecialchars($widget->title).'</a></li>'.PHP_EOL;
		}
	} else {
		echo '<li>暂无文章</li>'.PHP_EOL;
	}
}

class Initial_Widget_Comments_Recent extends Widget_Abstract_Comments
{
	public function __construct($request, $response, $params = NULL) {
		parent::__construct($request, $response, $params);
		$this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
	}
	public function execute() {
		$select  = $this->select()->limit($this->parameter->pageSize)
		->where('table.comments.status = ?', 'approved')
		->order('table.comments.coid', Typecho_Db::SORT_DESC);
		if ($this->parameter->parentId) {
			$select->where('cid = ?', $this->parameter->parentId);
		}
		if ($this->options->commentsShowCommentOnly) {
			$select->where('type = ?', 'comment');
		}
		if ($this->parameter->ignoreAuthor) {
			$select->where('ownerId <> authorId');
		}
		$page_whisper = FindContents('page-whisper.php', 'commentsNum', 'd');
		if ($page_whisper) {
			$select->where('cid <> ? OR (cid = ? AND parent <> ?)', $page_whisper[0]['cid'], $page_whisper[0]['cid'], '0');
		}
		$this->db->fetchAll($select, array($this, 'push'));
	}
}

function FindContent($cid) {
	$db = Typecho_Db::get();
	$row = $db->fetchRow($db->select()->from('table.contents')
	->where('cid = ?', $cid)
	->limit(1));
	if ($row) {
		$widget = Typecho_Widget::widget('Widget_Abstract_Contents');
		$widget->push($row);
		return $row;
	}
	return NULL;
}

function FindContents($val = NULL, $order = 'order', $sort = 'a', $publish = NULL) {
	$db = Typecho_Db::get();
	$sort_dir = ($sort == 'a') ? Typecho_Db::SORT_ASC : Typecho_Db::SORT_DESC;
	$select = $db->select()->from('table.contents')
		->where('created < ?', Helper::options()->time)
		->order($order, $sort_dir);
	if ($val) {
		$select->where('template = ?', $val);
	}
	if ($publish) {
		$select->where('status = ?','publish');
	}
	$rows = $db->fetchAll($select);
	return empty($rows) ? NULL : $rows;
}

function Whisper($sidebar = NULL) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	
	$sort = Typecho_Db::SORT_DESC;
	$select = $db->select()->from('table.contents')
		->where('created < ?', $options->time)
		->where('template = ?', 'page-whisper.php')
		->order('commentsNum', $sort);
	$pages = $db->fetchAll($select);
	
	$p = $sidebar ? 'li' : 'p';
	$remind = '';
	
	if (Typecho_Widget::widget('Widget_User')->pass('editor', true) && (!$pages || isset($pages[1]))) {
		$remind = '<'.$p.' class="notice"><b>仅管理员可见: </b>'.($pages ? '发现多个"轻语"模板页面，已自动选取内容较多的页面来展示，请删除多余模板页面。' : '未找到"轻语"模板页面，请创建"轻语"模板页面。').'</'.$p.'>'.PHP_EOL;
	}
	
	if ($pages) {
		$widget = Typecho_Widget::widget('Widget_Abstract_Contents');
		$widget->push($pages[0]);
		
		$title = $sidebar ? '<h3 class="widget-title">'.$widget->title.'</h3>' : '<h2 class="post-title"><a href="'.$widget->permalink.'">'.$widget->title.'<span class="more">···</span></a></h2>';
		$comment = $db->fetchAll($db->select()->from('table.comments')
			->where('cid = ? AND status = ? AND parent = ?', $widget->cid, 'approved', '0')
			->order('coid', Typecho_Db::SORT_DESC)
			->limit(1));
		if ($comment) {
			$content = hrefOpen(Markdown::convert($comment[0]['text']));
			if ($options->AttUrlReplace) {
				$content = UrlReplace($content);
			}
			$content = strip_tags($content, '<p><br><strong><a><img><pre><code>'.$options->commentsHTMLTagAllowed) . ($sidebar ? PHP_EOL .'<li class="more"><a href="'.$widget->permalink.'">查看更多...</a></li>' : '');
		} else {
			$content = '<'.$p.'>暂无内容</'.$p.'>';
		}
	} else {
		$title = $sidebar ? '<h3 class="widget-title">轻语</h3>' : '<h2 class="post-title"><a>轻语</a></h2>';
		$content = '<'.$p.'>暂无内容</'.$p.'>';
	}
	echo $title.PHP_EOL .($sidebar ? '<ul class="widget-list whisper">' : '<div class="post-content">').PHP_EOL .$content.PHP_EOL .$remind.($sidebar ? '</ul>' : '</div>').PHP_EOL;
}

function Links($sorts = NULL, $icon = 0) {
	$db = Typecho_Db::get();
	$link = NULL;
	$list = NULL;
	$page_links = FindContents('page-links.php', 'order', 'a');
	if ($page_links) {
		$exist = $db->fetchRow($db->select()->from('table.fields')
			->where('cid = ? AND name = ?', $page_links[0]['cid'], 'links'));
		if (empty($exist)) {
			$db->query($db->insert('table.fields')
				->rows(array(
					'cid'           =>  $page_links[0]['cid'],
					'name'          =>  'links',
					'type'          =>  'str',
					'str_value'     =>  NULL,
					'int_value'     =>  0,
					'float_value'   =>  0
				)));
			return NULL;
		}
		$list = $exist['str_value'];
	}
	if ($list) {
		$list = explode(PHP_EOL, $list);
		foreach ($list as $val) {
			list($name, $url, $description, $logo, $sort) = explode(',', $val);
			if ($sorts) {
				$arr = explode(',', $sorts);
				if ($sort && in_array($sort, $arr)) {
					$link .= '<li><a'.($url ? ' href="'.$url.'"' : '').($icon==1&&$url ? ' class="l_logo"' : '').' title="'.$description.'" target="_blank">'.($icon==1&&$url ? '<img src="'.($logo ? $logo : rtrim($url, '/').'/favicon.ico').'" onerror="erroricon(this)">' : '').'<span>'.($url ? $name : '<del>'.$name.'</del>').'</span></a></li>'.PHP_EOL;
				}
			} else {
				$link .= '<li><a'.($url ? ' href="'.$url.'"' : '').($icon==1&&$url ? ' class="l_logo"' : '').' title="'.$description.'" target="_blank">'.($icon==1&&$url ? '<img src="'.($logo ? $logo : rtrim($url, '/').'/favicon.ico').'" onerror="erroricon(this)">' : '').'<span>'.($url ? $name : '<del>'.$name.'</del>').'</span></a></li>'.PHP_EOL;
			}
		}
	}
	echo $link ? $link : '<li>暂无链接</li>'.PHP_EOL;
}

function Playlist() {
	$options = Helper::options();
	$arr = explode(PHP_EOL, $options->MusicUrl);
	if ($options->MusicSet == 'shuffle') {
		shuffle($arr);
	}
	echo implode(',', $arr);
}

function compressHtml($html_source) {
	$chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
	$compress = '';
	foreach ($chunks as $c) {
		if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
			$c = substr($c, 19, strlen($c) - 19 - 20);
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
			$c = substr($c, 12, strlen($c) - 12 - 13);
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, PHP_EOL) !== false || strpos($c, PHP_EOL) !== false)) {
			$tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
			$c = '';
			foreach ($tmps as $tmp) {
				if (strpos($tmp, '//') !== false) {
					if (substr(trim($tmp), 0, 2) == '//') {
						continue;
					}
					$chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
					$is_quot = $is_apos = false;
					foreach ($chars as $key => $char) {
						if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
							$is_quot = !$is_quot;
						} else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
							$is_apos = !$is_apos;
						} else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
							$tmp = substr($tmp, 0, $key);
							break;
						}
					}
				}
				$c .= $tmp;
			}
		}
		$c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
		$c = preg_replace('/\\s{2,}/', ' ', $c);
		$c = preg_replace('/>\\s</', '> <', $c);
		$c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
		$c = preg_replace('/<!--[^!]*-->/', '', $c);
		$compress .= $c;
	}
	return $compress;
}

function themeFields($layout) {
	$thumb = new Typecho_Widget_Helper_Form_Element_Text('thumb', NULL, NULL, _t('自定义缩略图'), _t('在这里填入一个图片 URL 地址, 以添加本文的缩略图，若填入纯数字，例如 <b>3</b> ，则使用文章第三张图片作为缩略图（对应位置无图则不显示缩略图），留空则默认不显示缩略图'));
	$thumb->input->setAttribute('class', 'w-100');
	$layout->addItem($thumb);

	$catalog = new Typecho_Widget_Helper_Form_Element_Radio('catalog', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('文章目录'), _t('默认关闭，启用则会在文章内显示“文章目录”（若文章内无任何标题，则不显示目录），需要在“控制台-设置外观-文章目录”启用“使用文章内设定”后，方可生效'));
	$layout->addItem($catalog);
}
/*回复可见样式开始*/
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('myyodux','one');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('myyodux','one');
class myyodux {
    public static function one($con,$obj,$text)
    {
      $text = empty($text)?$con:$text;
      if(!$obj->is('single')){
      $text = preg_replace("/\[hidden\](.*?)\[\/hidden\]/sm",'',$text);
      }
      
               return $text;
}
}/*回复可见样式结束*/
/* 增加评论验证*/
$comment = spam_protection_pre($comment, $post, $result);
function spam_protection_math() {
    $num1 = rand(1, 15);
    $num2 = rand(1, 15);
    echo "<div style=\"display:flex;flex-direction: column;align-items: flex-start;\"><p for=\"math\" id=\"Verification_code\" style=\"margin:0\"><code>$num1</code>+<code>$num2</code> 等于：</p><input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"25\" id=\"sum\" tabindex=\"4\" style=\"flex:1\" placeholder=\"计算结果 *\">\n</div>";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}
function spam_protection_pre($comment, $post, $result) {
    if ($_REQUEST['text'] != null) {
        If($_POST['num1'] == null || $_POST['num2'] == null) {
            throw new Typecho_Widget_Exception(_t('验证码异常.', '评论失败'));
        } else {
            $sum = $_POST['sum'];
            switch ($sum) {
            case $_POST['num1'] + $_POST['num2'] : break;
            case null:
                throw new Typecho_Widget_Exception(_t('请输入验证码.', '评论失败'));
                break;
            default:
                throw new Typecho_Widget_Exception(_t('验证码错误.', '评论失败'));
            }
        }
    }
    return $comment;
}
/* 增加评论验证结束*/
