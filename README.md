# Initial-M — Typecho 简约 SEO 博客主题 🚀  

<div align="center">
  <img src="screenshot.png" width="50%" height="auto" alt="主题封面">
</div>

![Version](https://img.shields.io/badge/version-3.2.3-blue)
![Typecho](https://img.shields.io/badge/Typecho-1.3-green)
![PHP](https://img.shields.io/badge/PHP-8.1+-red)
![License](https://img.shields.io/badge/license-MIT-brightgreen)

> 简约而不简单 · 高度优化 · 持续维护中  

**Initial-M** 是基于 Initial 主题开发的 Typecho 现代化博客主题，  
在保留原版简约设计风格的基础上，专注于 SEO 优化、结构化数据支持、性能提升与用户体验增强。

适用于：技术博客 / 极简个人博客 / 内容创作者网站

🔗 主题预览：[羽翼博客](https://www.886a.top)

---

## ✨ 核心特性

- 🧠 完整 Schema.org 结构化数据支持（已通过 [Google Rich Results 测试](https://search.google.com/test/rich-results)）
- ⚡ SEO 优化（Meta / Title / Breadcrumb / Open Graph）
- 📱 响应式排版设计
- 🔐 评论数学验证码防垃圾评论
- 👁 回复可见功能 `[hidden][/hidden]` 标签
- 📊 侧边栏统计模块（文章数 / 评论数 / 运行时间）
- 🎲 随机文章模块
- 🎨 图片懒加载功能
- 📢 公告栏功能（支持 HTML）
- 💾 主题设置备份 / 还原功能
- 📦 Google 广告位延迟加载优化
- 🌐 多头像源支持（Cravatar / Weavatar / SEP 等）
- 更多细节等你发掘

---

## 🧩 技术亮点

- **Typecho 1.3.0 兼容**：修复 `Widget\Base\Contents::push()` 报错
- **SEO 深度优化**：完整 Schema.org 结构化数据、Open Graph
- **性能优化**：集成 lazysizes 库实现图片懒加载，提升页面加载速度
- **稳定性提升**：容错机制优化，修复潜在白屏问题；广告初始化逻辑优化
- **无障碍访问**：HTML5 语义化标签、ARIA 属性支持，满足 PageSpeed Insights 检测要求

---

## 📦 安装方法

1. 下载或克隆本仓库
2. 上传到 `usr/themes/Initial-M`
3. 后台 → 外观 → 启用主题
4. 在主题设置中进行配置

---

## ⚙️ 运行环境

- 最低要求
  - Typecho ≥ 1.1
  - PHP ≥ 7.4

- 推荐环境
  - Typecho 1.3.0
  - PHP 8.1+

- 已测试环境
  - Typecho 1.3.0 1.2.1
  - PHP 8.3

> 本主题已针对 PHP 8.x 进行兼容优化，建议使用较新的 PHP 版本以获得更好的性能与安全性。

## 🍕 分支说明

- **master 分支**：稳定版本，推荐生产环境使用
- **dev 分支**：开发测试版本，包含最新功能但可能存在不稳定因素

---

## 📈 当前版本更新日志

**当前版本：v3.2.3 (2026-03-04)**

- **性能优化**：集成lazysizes库实现图片懒加载，提升页面加载速度
- **功能修复**：修复代码块中的[hidden]标签被误处理的问题，保护代码块内容

📄 查看完整详细历史更新请前往 [CHANGELOG.md](CHANGELOG.md)

---

## 🔗 关于原版

Initial-M 基于 Initial v2.5.5 版本进行增强开发，  
在保留原版简约设计风格的基础上增加了 SEO、结构化数据、广告优化、主题设置备份、公告栏等多项功能。

原版仓库：[https://github.com/jielive/initial](https://github.com/jielive/initial)

---

## 🙏 致谢

感谢原作者 JIElive 的开源贡献，为 Initial-M 提供了基础框架和设计理念。

---

## 📄 License

MIT License