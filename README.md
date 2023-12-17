<!--
:article: A Familiar Magazine
:author:  Daniel Dias Rodrigues
:email:   danieldiasr@gmail.com
:columns: 2
-->
# Needs we don't need

We are a species that creates false needs: we create and consume things just because we think we need them and they are not always the best option. Needs that we don't need. That's why we pollute every space we occupy: from the Pacific Ocean and its islands of trash and plastic, to dark cities full of trash. It would be no different with the internet.

Internet is polluted with poorly written, excessive, and often unnecessary JavaScript codes, polluted with heavy CMS platforms that, in theory, make life easier for users who could just focus on writing their content and less on structure. But in practice it's not like that: we waste hours, even days, trying to understand how these platforms work, and even more time adjusting extensions, settings, themes, appearances. And it doesn't always work out. Often all these facilities open all sorts of doors for intruders.

It doesn't stop there. Non-necessary needs call for even more non-necessary needs\... All CMS platforms need a good database. But a website doesn't need that. In most cases, if you really needed a database to run a website, SQLite would be enough. HTML is fast and responsive by default and the web works without JavaScript.

## Suggested readings

-   Unixsheikh.com. (2023-02-16) [SQLite the only database you will ever need in most cases](https://unixsheikh.com/articles/sqlite-the-only-database-you-will-ever-need-in-most-cases.html).
-   Unixsheikh.com. (2023-11-09) [The proper design process in web development](https://unixsheikh.com/articles/the-proper-design-process-in-web-development.html).
-   Unixsheikh.com. (2019-09-19) [Stop pushing JavaScript!](https://unixsheikh.com/articles/stop-pushing-javascript.html)

# What is the solution then?

My answer to this call is **Fanzine CMS**: a homemade content management system written entirely and only in **PHP** and **HTML5**, with a look and feel which resembles the default theme of a large CMS out there.

**Fanzine CMS** has a basic frame: banner, navigation bar, side navigation column, main content area and a footer. The content also allows the use of featured images, which the user can easily turn on/off at will with the help of PHP. In fact, with the purpose of reducing the need for knowledge of HTML language, and thanks to the power of PHP, a commented section was added where you can define the default parameters common to all content pages:

-   **article** — page title.
-   **author** — author's name. Alternatively, you can set a default author name in `index.php` if you are the only author of your site.
-   **columns** — is the `style="column-count:..."`. You can let it in `auto`, it's good for most cases. Will be created as many columns of 340px as possible. A typical screen FHD 1920x1080 will have 3 columns.
-   **date** — if blank or missing PHP will get the [file modification time](https://www.php.net/manual/en/function.filemtime.php) and fill this field for you!
-   **email** — author's email is optional, but will be linked to author's name if this attribute is provided.
-   **image** — featured image is an optional field.

This section should preferably be placed at the top of the file. Order does not matter:

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

## No database required

No database required! Place your images in the `img/` folder and your articles in `articles/`, you can organize them by year, etc. Just remember to pass the right path in the links.

## Easy customization

The main Cascading Style Sheet (CSS) is very simple: `style.css`. Easy to understand and easy to change.

However, if you think you need some help, this is a great start, I learned a lot there: [CSS Tutorial](https://www.w3schools.com/Css/).

## Engine

All PHP code run from inside `index.php`: a short file with a few lines of code, easy to understand if you know the basics of PHP, and well commented.

A complementary file, called `main.php` is responsible for creating the main page with \"abstracts\" of all articles on the site. It lists the contents of the `articles` folder and creates the excerpt, the reader just needs to click on \"read more\".

What `index.php` do is to join three html pages into one, in this order:

```
+ header.html
+ sidebar.html
+ render a main page
  (defaults to 'main.php')
+ footer.html
```

## Passing arguments

In the \"render a main page\" step, we can pass some arguments to PHP (`index.php`) via URL, using:

```
<a href="index.php?id=articles/page.html">
    Friendly link name
</a>
```

You can pass subfolders:

```
<a href="index.php?id=articles/2023/12/page.html">
```

And it will redirect to:

```
https://website.com/index.php?id=articles/2023/12/page.html
```

If you use the `.htaccess` we provided, the rewrite rules will allow you to omit the **`index.php?id=`** portion:

```
<a href="/articles/page.html">
```

And it will redirect to:

```
https://website.com/articles/2023/12/page.html
```

Don't forget to use root relative URLs: `/articles` not `articles`. Do the same for `img` folder or any other internal link.

The entire page is rebuilded and reloaded. There are no frames like there were in HTML4 (frameset, frame, etc.). But as it's a lightweight website (no heavy scripts, no javscript, no database), it's still faster than a CMS. This method is also cost-effective: you don't have to rewrite vast lines of repetitive code. For example: `header.html` is the same for all pages. Tons of meta tags written just once!

# Licensing

![](https://www.gnu.org/graphics/gplv3-with-text-136x68.png)

Fanzine CMS is a homemade content management system written entirely and only in PHP and HTML5.

Copyright (C) 2023 Daniel Dias Rodrigues

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

Read the [LICENSE](LICENSE).
