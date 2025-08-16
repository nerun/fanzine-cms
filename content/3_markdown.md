Editors working on **Fanzine-CMS** can improve readability by using GitHub’s callout styles. These blocks highlight important information directly in Markdown files. The three most useful types are:

* **Note** – to provide extra context or clarification.
* **Tip** – to share best practices or helpful shortcuts.
* **Warning** – to emphasize risks, limitations, or potential errors.

<!-- more -->

### Syntax examples

```markdown
> [!Note]
> This is a note.
```

> [!Note]
> This is a note.

```
> [!Tip]
> This is a tip.
```

> [!Tip]
> This is a tip.

```
> [!Warning]
> This is a warning.
```

> [!Warning]
> This is a warning.

Callout styles ensure that critical details stand out, making Fanzine-CMS documentation clearer and more user-friendly.

> [!Warning]
> Remember, the right is `[!Warning]` not `[!WARNING]` nor `[!warning]`.

The words Note, Tip and Warning are translatable in `config.php`, but you will always use `[!Note]`, `[!Tip]` and `[!Warning]` as markup.

---

## Extra Tip for Editors

Not related to GitHub callouts, but editors can also use the `<kbd>` tag to show keyboard input in a clean way, for example:

```html
<kbd>Ctrl</kbd>+<kbd>Alt</kbd>+<kbd>Del</kbd>
```

<kbd>Ctrl</kbd>+<kbd>Alt</kbd>+<kbd>Del</kbd>

This adds visual clarity to shortcut instructions.
