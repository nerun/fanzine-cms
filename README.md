<!--
:article: A Familiar Magazine
:author:  Daniel Dias Rodrigues
:email:   danieldiasr@gmail.com
:columns: 2
:image:   screenshot.webp
-->

# Needs we don't need

We are a species that creates false needs: we create and consume things just because we think we need them, and they are not always the best option. Needs we don't need. That is why we pollute every space we occupy: from the Pacific Ocean and its islands of trash and plastic, to dark and dirty cities. It would be no different with the internet.

Internet is polluted with poorly written, excessive, and often unnecessary JavaScript codes, polluted with heavy CMS platforms that, in theory, make life easier for users who could just focus on writing their content and less on structure. But in practice it's not like that: we waste hours, even days, trying to understand how these platforms work, and even more time adjusting plugins, settings, themes, appearances. And it doesn't always work out. Often all these facilities open all sorts of doors for intruders.

It doesn't stop there. Non-necessary needs call for even more non-necessary needs\... All CMS platforms need a good database. But a website doesn't need that. In most cases, if you really needed a database to run a website, SQLite would be enough. HTML5 is fast and responsive by default and the web works without JavaScript.

## Suggested readings

Unixsheikh.com:
  - [SQLite the only database you will ever need in most cases](https://unixsheikh.com/articles/sqlite-the-only-database-you-will-ever-need-in-most-cases.html).
  - [The proper design process in web development](https://unixsheikh.com/articles/the-proper-design-process-in-web-development.html).
  - [Stop pushing JavaScript!](https://unixsheikh.com/articles/stop-pushing-javascript.html)

# What is the solution then?

My answer to this call is **Fanzine CMS**: a home-made Content Management System (CMS), written almost entirely and exclusively in **PHP** and **HTML5** (I ended up using a single JavaScript, very simple), with **responsive web design** and an appearance that resembles the default theme of a large CMS out there.

**Fanzine CMS** has a basic structure: banner, navigation bar, side navigation column, main content area and a footer. The content also allows the use of featured images, which the user can easily activate and deactivate. In fact, in order to reduce the need for knowledge of the HTML language, and thanks to the power of PHP, a commented section has been added where you can define the default parameters common to all content pages.

This section should preferably be placed at the top of the article file (html or markdown). The order does not matter:

```
<!--
:article: Interesting title
:author:  John Doe
:columns: auto, 1, 2, 3... etc
:date:    Tue, 12 Dec 2023
:email:   author@email.com
:image:   image-in-img-folder.jpg
-->
```

-   **article** — page title.
-   **author** — author's name.
-   **columns** — is the `style="column-count:(...)"`. The default is 2, but you can let it in `auto`, it's good for most cases. Will be created as many columns of 340px as possible (see `.columns` in `style.css` to change default width). A typical screen FHD 1920&times;1080 will have 3 columns.
-   **date** — if blank or missing PHP will get the [file modification time](https://www.php.net/manual/en/function.filemtime.php) and fill this field for you!
-   **email** — author's email is optional but, if this parameter is provided, it will be linked to author's name automatically.
-   **image** — featured image is an optional field. Default size is 640&times;360px for images inside the article (defined in `index.php`) and 432&times;216px for images loaded as thumbnail in the main page (`main.php`). there's no default here.

## Configuration

All basic configuration can be done through the `config.php` file:

* html language
* website title
* meta tags: author, copyright holder, description, keywords, browser cache, etc
* article defaults for title, authorship, columns, email and image
* translation of some navigation tags: prev/next
* `BASE_PATH` constant: useful if your site is a "subsite" (not in the root folder)
* etc

## Full markdown support

Thanks to Emanuil Rusev's [Parsedown](https://github.com/erusev/parsedown) / [ParsedownExtra](https://github.com/erusev/parsedown-extra), **Fanzine CMS** has full support to [PHP Markdown Extra](https://michelf.ca/projects/php-markdown/extra/). This is important because "Markdown’s syntax is intended for one purpose: to be used as a format for writing for the web."[^1]

In fact, this README is written in markdown.

[^1]: J. Gruber. _Daring Fireball: Markdown syntax documentation_. Overview: [Philosophy](https://daringfireball.net/projects/markdown/syntax#philosophy).

## No database required

No database required! Place your images in the `img/` folder and your articles in `articles/`, you can organize them by year, etc. Just remember to pass the right path in the links. See below.

## CSS customization

There is only one Cascading Style Sheet (CSS): `style.css`. And it's not exactly easy to understand. However, if you feel like you need some help, this is a great place to start: [CSS Tutorial](https://www.w3schools.com/css). I learned a lot there. Also, test the validity of your style sheets in [Jigsaw](https://jigsaw.w3.org/css-validator), a CSS validator.

## Engine

All PHP code run from inside `index.php`: a short file with a few lines of code, easy to understand if you know the basics of HTML and PHP, and well commented.

A complementary file, called `main.php`, is responsible for creating the main page with "abstracts" of all the articles on the site, and then dividing them into groups of 5 articles abstracts per page (you can change this in the first line: `$articlesPerPage = 5;`). The reader only needs to click on "read more", or on the article title itself. This is done by the script, which lists the contents of the `articles` folder and creates the excerpt for each file found there. The script will use the `<!-- more -->` tag, identifying as an abstract only what is before it. If no "more" tag is found, it will select the first 9 lines (of HTML code, not of the text).

Another complementary file, called `articles.php` is responsible for formatting the full article itself.

The entire page is rebuilded and reloaded. There are no frames like there were in HTML4 (frameset, frame, etc.). But as it's a lightweight website (no heavy scripts, no javascript, no database), it's still faster than a CMS. This method is also cost-effective: you don't have to rewrite vast lines of repetitive code. For example: `<meta>` elements, `<header>` and `<footer>` sections are the same for all pages. Tons of tags written just once!

### Hyperlinks

We can pass some arguments to the engine (`index.php`) via URL, using:

```
<a href="index.php?id=page.html">...</a>
```

And it will redirect to:

```
https://site.com/index.php?id=page.html
```

You can pass subfolders:

```
<a href="index.php?id=articles/2023/12/page.html">...</a>
```

And it will redirect to:

```
https://site.com/index.php?id=articles/2023/12/page.html
```

### Nice URLs

If you use the `.htaccess` we provide, the rewrite rules will allow you to use "nice urls" by omitting the **`index.php?id=`** portion:

```
<a href="articles/2023/12/page.html">...</a>
```

Will be redirected to:

```
https://site.com/articles/2023/12/page.html
```

Don't forget to use root relative URLs: `/articles` not `articles`. Do the same for `img` folder or any other internal link.

#### Enable Mod_Rewrite in Apache2

In order to "nice urls" to work, you do need to enable **mod_rewrite**. The command to do this in a Linux server is:

```console
$ sudo a2enmod rewrite
```

The above command will enable rewrite mode or inform you that it is already in use. After that, restart Apache.

```console
$ sudo service apache2 restart
```
