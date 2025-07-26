## A Format to Last Through Time

[The Unicode Standard](https://en.wikipedia.org/wiki/Unicode) was a revolution in transcending the limitations of traditional character encodings such as ASCII, because Unicode supports characters beyond the 128 available in the English language, which makes it universal. The [UTF-8](https://en.wikipedia.org/wiki/UTF-8) format became a masterful implementation of the Unicode standard while maintaining backward compatibility with ASCII. In fact, ASCII is now a subset of UTF-8.

This is relevant because the ASCII format has stood the test of time and is considered one of the best formats for storing electronic texts (etexts) meant to last. Most public domain novels, books, tales, and stories available on [Project Gutenberg](https://www.gutenberg.org) are in UTF-8 format.

<!-- more -->

In the words of Project Gutenberg:[^1]

> The major point of all this is that years from now Project Gutenberg etexts are still going to be viable, but program after program, and operating system after operating system are going to go the way of the dinosaur, as will all those pieces of hardware running them. Of course, this is valid for all Plain Vanilla ASCII etexts … not just those your access has allowed you to get from Project Gutenberg. The point is that a decade from now we probably won’t have the same operating systems, or the same programs and therefore all the various kinds of etexts that are not Plain Vanilla ASCII will be obsolete. We need to have etexts in files a Plain Vanilla search/reader program can deal with; this is not to say there should never be any markup... just those forms of markup should be easily convertible into regular, Plain Vanilla ASCII files so their utility does not expire when programs to use them are no longer with us. Remember all the trouble with CONVERT programs to get files changed from old word processor programs into Plain Vanilla ASCII?

## Markdown

Of course, Project Gutenberg only accepts [plain text](https://en.wikipedia.org/wiki/Plain_text) (.txt files in UTF-8), but [Markdown](https://en.wikipedia.org/wiki/Markdown) is a markup language that is essentially plain text—in other words, it remains readable in any plain text editor.

Markdown is a lightweight markup language with simple, unobtrusive, human-readable syntax. It is designed to be easy to write in any generic text editor and easy to read in its raw form. In fact, it is so simple and nonintrusive that one can open a Markdown file (with the ".md" extension) and read it almost as if it were a "Plain Vanilla ASCII file." You can even rename its extension to ".txt" if you prefer. On Windows, just use Notepad. On Linux, plain text editors abound: gedit (and its variants), Kate, Emacs, Vim, Nano, etc.

In this sense, Markdown aligns perfectly with Project Gutenberg's principle: markup should be easily convertible and should not obscure the readability or long-term viability of the text. Markdown achieves this precisely because it is both plain text and a nonintrusive markup.

## An Interchangeable Language

Files written in UTF-8 using the Markdown language are not only easy to read and open in any operating system or plain text editor, but also easy to convert into professional or more complex formats.

The easiest way to do this is to import your content directly into a **LibreOffice** or **Microsoft Office** word processor, or into desktop publishing editors like **Scribus** or **Adobe InDesign**.

However, the [Pandoc](https://pandoc.org/) program is available for several operating systems—Windows, Linux, BSD, macOS, etc. It allows you to convert to and from many different formats. And it's free and open source.

Of course, Pandoc is a command-line tool, designed to be used in the Command Prompt, PowerShell, Linux terminal, etc. But it's as easy as writing this:

```console
$ pandoc test.md -f markdown -t docx -s -o test.docx
```

The filename `test.md` tells Pandoc which file to convert. The `-s` option instructs it to create a "standalone" file, with a header and footer, rather than just a fragment. The `-o test.docx` flag specifies that the output should go into `test.docx`. Note that we could have omitted `-f markdown -t docx`, since Pandoc is smart enough to infer the input and output formats from the filenames—but it doesn’t hurt to include them.[^2]

The overall appearance of the converted file is excellent—there’s really nothing to complain about.

July 27, 2023 (_revised July 17, 2025_)

Daniel Dias Rodrigues

[^1]: Michael Hart, "The History and Philosophy of Project Gutenberg," *Project Gutenberg*, August 1992, [https://www.gutenberg.org/about/<wbr>background/history\_and\_<wbr>philosophy.html](https://www.gutenberg.org/about/background/history_and_philosophy.html#the-project-gutenberg-philosophy-continued-2).

[^2]: "Getting started with pandoc. Step 6: Converting a File," *Pandoc*, accessed July 27, 2023, https://pandoc.org/getting-started.html#step-6-converting-a-file.