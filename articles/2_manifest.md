<!--
:article:   Apologetic manifest of the universal format
:author:    Daniel Dias Rodrigues
:columns:   2
:date:      Thur, 27 jul 2023
:email:     danieldiasr@gmail.com
:image:     markdown-mark.webp
-->

## A format to lasts through time

[The Unicode Standard](https://en.wikipedia.org/wiki/Unicode) was a revolution in transcending the limitations of traditional character encodings such as ASCII, because Unicode supports other characters in addition to the 128 available in the English language, which makes it universal. And the [UTF-8](https://en.wikipedia.org/wiki/UTF-8) format was a master at implementing the Unicode standard while incorporating ASCII. In fact, ASCII is now a subset of UTF-8.

This information is relevant because the ASCII format has survived the time and is considered one of the best formats to store electronic texts (etexts) that last in time. Most public domain novells, books, tales and stories available in [Project Gutenberg](https://www.gutenberg.org) are in ASCII format.

<!-- more -->

In the words of Project Gutenberg:[^1]

> _The major point of all this is that years from now Project Gutenberg etexts are still going to be viable, but program after program, and operating system after operating system are going to go the way of the dinosaur, as will all those pieces of hardware running them. Of course, this is valid for all Plain Vanilla ASCII etexts … not just those your access has allowed you to get from Project Gutenberg. The point is that a decade from now we probably won’t have the same operating systems, or the same programs and therefore all the various kinds of etexts that are not Plain Vanilla ASCII will be obsolete. We need to have etexts in files a Plain Vanilla search/reader program can deal with; this is not to say there should never be any markup... just those forms of markup should be easily convertible into regular, Plain Vanilla ASCII files so their utility does not expire when programs to use them are no longer with us. Remember all the trouble with CONVERT programs to get files changed from old word processor programs into Plain Vanilla ASCII?_

## Markdown

Of course, Project Gutenberg only accepts Plain Vanilla ASCII (.txt files), but [markdown](https://en.wikipedia.org/wiki/Markdown) is a markup language that is essentially pure text, that is, it has the same readability when read in a plain text editor.

Markdown a lightweight (or humane) markup language with simple, unobtrusive syntax. It is designed to be easy to write using any generic text editor and easy to read in its raw form. Markdown is a markup language intended for creating formatted text using any plain text editor. In fact, it's so simple and unobtrusive that a person can open a markdown file (extension ".md") and read it as if it were "Plain Vanilla ASCII file". You can rename it's extension to ".txt" if you prefer. On Windows, just use notepad, and on Linux, plain text editors abound: gedit (and its variants), kate, emacs, vim, nano etc.

## An interchangeable language

Files written in UTF-8 format using markdown language are not only easy to read and open in any operating system and plain text editor software, but they are also easy to convert to any professional or more complex format.

The easiest way to do this is to import your content directly into a **LibreOffice** or **Microsoft Office** text editor, or into editors for professional publications like **Scribus** or **Adobe InDesign**.

However, the [pandoc](https://pandoc.org/) program is available for several operating systems: Windows, Linux, BSD, macOS, etc. It lets you convert to and from many different formats. And it's free and open source.

Of course, pandoc is a command line tool, designed to be used in command prompt, powershell, linux terminal etc. But it's so easy as write this:

```shell
$ pandoc test.md -f markdown -t docx -s -o test.docx
```

The filename `test.md` tells pandoc which file to convert. The `-s` option says to create a "standalone" file, with a header and footer, not just a fragment. And the `-o test.docx` says to put the output in the file `test.docx`. Note that we could have omitted `-f markdown -t docx`, since pandoc is smart enough to understand the nature of both the input and the output file, but it doesn’t hurt to include them.[^2]

The overall appearance of the converted file is very good and there is nothing to complain about.

July 27, 2023 (_revised January 23, 2024_)

**Daniel Dias Rodrigues**


[^1]: Hart, Michael (1992, August). [_The History and Philosophy of Project Gutenberg_](https://www.gutenberg.org/about/background/history_and_philosophy.html). Project Gutenberg.

[^2]: [_Getting started with pandoc: Step 6 - Converting a file_](https://pandoc.org/getting-started.html#step-6-converting-a-file). Pandoc: a universal document converter.