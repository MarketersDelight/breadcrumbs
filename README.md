# Breadcrumbs

A [Marketers Delight](https://marketersdelight.com/) drop-in that adds a breadcrumb trail above your content. It builds the trail from the current page type (posts, pages, custom post types, taxonomies, archives, search and 404) and lets you turn it on or off per Layout.

## Features

- Trails for single posts (blog page → parent categories → category), pages and hierarchical post types (parent pages), and custom post types with archives
- Trails for category, tag and custom taxonomy archives, including parent terms
- Trails for date (year / month / day), author, post type, blog, search and 404 pages
- Adds "Filter results" and "Page N" items on filtered and paginated archives
- Optional compact "← All {post type}" back link on single posts instead of the full trail
- Semantic markup: `<nav aria-label="Breadcrumbs">` with an ordered list and `aria-current="page"` on the current item
- Styles are added to MD's compiled stylesheet. The trail scrolls horizontally instead of wrapping on small screens.
- The HTML template can be overridden through MD's template system

## Settings

**Global settings** (a Breadcrumbs panel on the MD settings dashboard, below Tools):

- **Home text**: changes the label of the first link in the trail (default: "Home")
- **Simple Go back link**: on single posts, shows only "← All {post type}", linking to the blog page or the post type archive

**Layout settings**: each Layout (post type, taxonomy, term or single post) gets an **Add Breadcrumbs** or **Remove Breadcrumbs** checkbox. Which one you see depends on the setting it inherits. Breadcrumbs don't show anywhere until you add them to a Layout.

## Developers

- `md_filter_breadcrumbs`: filter the trail array before it renders. Each item is keyed and holds `label` and `url` (an empty `url` means the item is not linked).

## Requirements

- Marketers Delight 6.0 or later
- WordPress 6.6 or later
- PHP 7.4 or later

## Install

1. Download the latest `breadcrumbs-x.y.z.zip` from the [Releases page](https://github.com/MarketersDelight/breadcrumbs/releases).
2. In WordPress, go to MD's Drop-ins screen, click **Add new**, and upload the zip.
3. Activate Breadcrumbs, then add it to a Layout.

Don't use **Code → Download ZIP**. That zip includes development files and a folder name that MD won't recognize.

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
