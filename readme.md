# Bootstrap Responsive Font Size

A flexible and maintainable stylesheet providing responsive font size utilities using CSS variables, fully compatible with Bootstrap 5 breakpoints. 

## Features

- Predefined font size classes from `fs-1px` to `fs-100px`.
- Responsive font size classes for different breakpoints, e.g., `fs-md-2px`, `fs-xxl-10px`.
- Uses CSS variables for easy customization of font sizes.
- Generator source code to create custom selectors and range of font sizes

## Usage

Include the CSS file in your HTML:

```html
<link rel="stylesheet" href="path/to/fontsize.css">
```

Then, use the classes in your HTML elements:

```html
<p class="fs-1px">This is a very small text.</p>
<p class="fs-md-2px">This text gets slightly larger on medium screens.</p>
<p class="fs-xxl-10px">This text is quite large on extra extra large screens.</p>
```

## Customization

You can customize the font sizes by overriding the CSS variables in your own stylesheets or inline styles:

```css
:root {
  --ucs-fontsize-1: 0.75rem;
  --ucs-fontsize-2: 1rem;
  /* ... */
}
```

You can also limit it to the scope of a particular selector

```css
.my-selector {
    --ucs-fontsize-1: 2px;
}
```

## Browser Support

This project uses CSS variables, which are not supported in Internet Explorer. If you need to support that browser, consider using a post-processor like PostCSS.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
