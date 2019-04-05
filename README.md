# Microgallery

![Version](https://img.shields.io/badge/VERSION-1.2.3-0366d6.svg?style=for-the-badge)
![Joomla](https://img.shields.io/badge/joomla-3.7+-1A3867.svg?style=for-the-badge)
![Php](https://img.shields.io/badge/php-5.6+-8892BF.svg?style=for-the-badge)

_description in Russian [here](README.ru.md)_

Content plugin for Joomla! 3 for displaying image tiles in the article.

Shortcode format: `{microgallery image_path[ Title gallery]}`. The path is specified from the site root. Exclude subdirectories.

Include extensions: `.jpg, .jpeg, .png, .gif, .svg`.

If a gallery title is specified, it will be displayed in front of the gallery as a third-level title.

**Params:**

* Image width, default 25%.
* Connect plugin styles, by default Yes, if not — provide output layout in the main site template.
* Connect Lazyload (included in the plugin), default Yes.
* Connect Lightbox (included in the plugin), default Yes.

**Warning:** the plugin does not generate thumbnail images.
