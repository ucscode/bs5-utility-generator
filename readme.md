# Bootstrap Responsive CSS Generator

A flexible PHP class for generating responsive CSS utility classes using custom properties (`--css-vars`) and Bootstrap 5-style media queries. Create scalable, maintainable styles like responsive font sizes, widths, or any other CSS property using consistent class patterns.

---

## ✨ Features

- 🧱 Generates `:root` CSS variables (`--bs-font-12`, `--bs-width-90`, etc.)
- 📱 Responsive class support via Bootstrap 5 breakpoints (`.fs-sm-12`, `.w-xl-90`, etc.)
- 💡 Easily configurable for **any CSS property** — not just font sizes
- ⚡ Outputs valid CSS for quick inclusion or injection into your projects
- 🧩 Fully extendable for custom ranges, units, or breakpoints

---


## 🚀 Usage

### Generate Responsive Width Utility Classes

```php
use Ucscode\Bs5AutoCss\Generator;

$generator = new Generator(
    property: 'width',
    varPrefix: '--bs-width-',
    classPrefix: 'w-',
    range: [25, 50, 75, 90, 100],
    unit: '%'
);

$css = $generator->generate();
file_put_contents('widths.css', $css);
```

---

## ⚙️ Constructor Parameters

```php
new Generator(
    string $property = 'font-size',
    string $varPrefix = '--bs-font-',
    string $classPrefix = 'fs-',
    array|int $range = 100,
    string $unit = 'px'
);
```

| Parameter      | Description                                                           |
| -------------- | --------------------------------------------------------------------- |
| `$property`    | The CSS property to generate classes for (e.g., `width`, `font-size`) |
| `$varPrefix`   | The prefix used in CSS variable names                                 |
| `$classPrefix` | The prefix used in generated utility class names                      |
| `$range`       | Accepts an integer (1 to N) or an array of exact values               |
| `$unit`        | Appended to each value (`px`, `%`, `rem`, etc.)                       |

---

## 📁 Output Example

### For `.fs-xl-14`:

```css
:root {
    --bs-font-14: 14px;
}

@media (min-width:1200px) {
    .fs-xl-14 {
        font-size: var(--bs-font-14) !important;
    }
}
```

---

## 🧪 Suggested Use Cases

* Generate font-size utilities
* Generate spacing (margin/padding) utilities
* Width or height classes
* Border radius, line-height, etc.

---

## 📄 License

MIT License — free for personal and commercial use.
