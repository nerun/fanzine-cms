# Needs we don't need

We are a species that creates false needs: we create and consume things just because we think we need them, and they are not always the best option. Needs we don't need. That is why we pollute every space we occupy: from the Pacific Ocean and its islands of trash and plastic, to dark and dirty cities. It would be no different with the internet.

Internet is polluted with poorly written, excessive, and often unnecessary JavaScript codes, polluted with heavy CMS platforms that, in theory, make life easier for users who could just focus on writing their content and less on structure. But in practice it's not like that: we waste hours, even days, trying to understand how these platforms work, and even more time adjusting plugins, settings, themes, appearances. And it doesn't always work out. Often all these facilities open all sorts of doors for intruders.

It doesn't stop there. Non-necessary needs call for even more non-necessary needs\... All CMS platforms need a good database. But a website doesn't need that. In most cases, if you really needed a database to run a website, SQLite would be enough. HTML5 is fast and responsive by default and the web works without JavaScript.

## Suggested readings

Unixsheikh.com:
  - [SQLite the only database you will ever need in most cases](https://unixdigest.com/articles/sqlite-the-only-database-you-will-ever-need-in-most-cases.html).
  - [The proper design process in web development](https://unixdigest.com/articles/the-proper-design-process-in-web-development.html).
  - [Stop pushing JavaScript!](https://unixdigest.com/articles/stop-pushing-javascript.html)

# What is the solution then?

My answer to this call is **Fanzine CMS**: a homegrown Content Management System (CMS) built almost entirely in **PHP** and **HTML5**, with only a single JavaScript file—for the hamburger menu. It features **responsive web design** and a look inspired by the default theme of a well-known CMS.

**Fanzine CMS** follows a straightforward layout: banner, navigation bar, sidebar, main content area, and footer. It supports featured images that can be easily toggled on or off by the user. To streamline content creation and reduce the need for HTML knowledge, each article is paired with a `.yaml` file containing metadata used to configure key elements of the page.

The YAML file must share the same name as the corresponding article (HTML or Markdown) and should ideally include the following fields:

```yaml
article: Interesting title
author:  John Doe
columns: auto
date:    Tue, 12 Dec 2023
email:   author@email.com
image:   image-in-img-folder.jpg
```

* **article** — Page title.
* **author** — Author's name.
* **columns** — Sets `style="column-count:(...)"`. The default is `2`, but `auto` works well in most cases. It creates as many 340px columns as the screen allows (see `.columns` in `style.css` to adjust width). A typical 1920×1080 screen yields 3 columns.
* **date** — If blank or omitted, PHP automatically fills it using [file modification time](https://www.php.net/manual/en/function.filemtime.php).
* **email** — Optional. If present, it becomes a link on the author's name.
* **image** — Optional featured image. Default size is 640×360px within articles (`index.php`) and 432×216px for thumbnails on the main page (`main.php`). No fallback image is used.

This structure keeps content creation clean and consistent, while allowing flexibility and automation through PHP.

## Configuration

Basic configuration is handled through the `config.php` file, including:

* HTML language
* Website title
* Meta tags: author, copyright, description, keywords, browser cache, etc.
* Default values for articles: title, author, columns, email, and image
* Navigation labels translation: prev/next
* `BASE_PATH` constant — useful if your site is hosted in a subdirectory (not at the root)
* And more

## Full Markdown Support

Thanks to Emanuil Rusev’s [Parsedown](https://github.com/erusev/parsedown) and [ParsedownExtra](https://github.com/erusev/parsedown-extra), **Fanzine CMS** fully supports [PHP Markdown Extra](https://michelf.ca/projects/php-markdown/extra/). This matters because "Markdown’s syntax is intended for one purpose: to be used as a format for writing for the web."[^1]

In fact, this very README is written in Markdown.

[^1]: J. Gruber. *Daring Fireball: Markdown syntax documentation*. Overview: [Philosophy](https://daringfireball.net/projects/markdown/syntax#philosophy).

## No Database Required

No database needed! Just place your images in the `img/` folder and your articles in `articles/`. You can organize articles by year or any other structure. Just ensure links point to the correct paths. See examples below.

## CSS Customization

There’s only one CSS file: `style.css`. It may not be beginner-friendly, but if you’re looking to learn or tweak it, [CSS Tutorial](https://www.w3schools.com/css) is a good place to start — that’s where I learned a lot. Also, check your styles using [Jigsaw](https://jigsaw.w3.org/css-validator), a CSS validation tool.

## Engine

All PHP logic runs through `index.php`: a short, well-commented file that's easy to follow if you know the basics of HTML and PHP.

A complementary file, `main.php`, builds the homepage by displaying "abstracts" for all articles, grouped in pages of 5 (modifiable at the top of the file: `$articlesPerPage = 5;`). Readers can click "read more" or the article title to view the full content. The script scans the `articles` folder and generates a preview for each file using the `<!-- more -->` tag. If the tag is missing, it defaults to the first 9 lines of HTML (not text).

Another file, `articles.php`, handles formatting and display of the full article.

The entire page is rebuilt on each load — no frames (e.g., `frameset`, `frame`) as in HTML4. Still, it's faster than a traditional CMS thanks to its lightweight approach: no heavy scripts, no JavaScript, and no database. It’s also efficient: you only write repeated sections once (e.g., `<meta>`, `<header>`, `<footer>`).

### Hyperlinks

You can pass arguments to `index.php` via URL:

```html
<a href="index.php?id=page.html">...</a>
```

Which resolves to:

```
https://site.com/index.php?id=page.html
```

You can also pass subfolders:

```html
<a href="index.php?id=articles/2023/12/page.html">...</a>
```

Which resolves to:

```
https://site.com/index.php?id=articles/2023/12/page.html
```

### Nice URLs

If you use the provided `.htaccess` file, the rewrite rules allow for cleaner URLs by omitting the `index.php?id=` part:

```html
<a href="articles/2023/12/page.html">...</a>
```

Will resolve as:

```
https://site.com/articles/2023/12/page.html
```

Use root-relative URLs (e.g., `/articles`, not `articles`) for all internal links — including images, stylesheets, etc.

#### Enabling mod\_rewrite in Apache2

To make "nice URLs" work, you must enable **mod\_rewrite**. On a Linux server, run:

```console
$ sudo a2enmod rewrite
```

This enables the rewrite module (or informs you it's already enabled). Then, restart Apache:

```console
$ sudo service apache2 restart
```
