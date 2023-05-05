# Adapt Dev Base Theme

This guide explains the design and coding rules for coding standards. It was created to ensure consistency across client projects and provide guidance on developing and maintaining themes, plugins, and site modifications It combines policies and guidelines with data-backed best practices from sources like the [W3C](https://www.w3.org/), [WordPress.org](https://make.wordpress.org/core/handbook/best-practices/coding-standards/), and other industry and peer leaders.

This guide will be updated as new issues arise that require attention. If a topic is not covered here, submit it to your team leader.


## New Project Quickstart
-   Setup local wp instance
    - Ideally this is a copy (db and files) of the -base- base theme instance
        - This will ensure all required plugins are installed, otherewise you can do this yourself
        - This should also give you the latest base theme code
-   Setup a new repository for this project's theme folder
    - If you have an exiting base theme folder, just delete it's .git folder and then `git init`
    - You'll aslo want to ask for an empty dev ops projet to push your rpo up to
-   Use the commands `npm install` and `composer install` to install theme development dependencies
-   Optional: Create a `.env` file with a `DEV_URL` variable to test with Lighthouse and to generate Critical CSS
-   Set Sass variables based on the project's style guide in `assets/sass/_utilities`
-   Use the command `npm run start` to watch assets for changes and start coding!

## DevOps and Deploying Theme Code

Most WordPress project repositories will have an automated build process triggered when commits are made to the default branch.

Typically this process will install NPM packages, run the NPM build script defined in `package.json`, and then move the resulting bundled theme files to the development server.

## WordPress Coding Standards

The WordPress community is a rich community of developers who have worked tirelessly to make it the success it is today. These developers have learned through their trial and error, and have put together coding standards to ensure the best success and security. Make yourself familiar with the following links:

-   [PHP Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/)
-   [JavaScript Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/)
-   [CSS Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/css/)

## Recommended Development Environment

Your backend will be (L,W,M)AMP, to support your local WordPress install. Source control will be Git, hooked to our Azure DevOps account.

We recommend using the following development environment
-   Code Editor: Visual Studio Code
    -   Plugins: eslint, php debug, php intellisense, phpcs, stylelint, WordPress Snippets
-   WP install manager: Local by Flywheel
    -   This is especially helpful when working on WP engine based sites
-   Database manager: SQL Pro (connects with Local)
-   Password manager: LastPass
-   Browser plugins: bugherd, lastpass

## Gulp

Gulp tasks are responsible for pre-processing all SCSS files, optimizing images, and for minifying and uglifying JS files. After the base theme files have been cloned from the repository, use the command `npm install` to download any required packages. Once completed, use the command `npm run start` to fire up the Gulp watch task and process your assets as they change. All images added to the theme need to be added in assets/images. All CSS added to the project will be added in `assets/sass`.

Another useful NPM command is `npx`, which can be used to execute locally installed binaries. With it, you can individually run other available Gulp tasks:
```
npx gulp clean
npx gulp lighthouse
npx gulp critical
```

## JavaScript

Scripts are categorized as global JS or *other* JS. Global JS should be added to or required from within `assets/js/main.js`. Scripts that need to be kept separate can be put in `assets/js` and will build to `dist/js` with their filename intact.

Theme component scripts and styles are kept in their own directory alongside their class definitions. Those scripts are written to `dist/js` with their filenames intact.

## Sass/CSS Conventions

Follow the BEM (block-element-modifier) methodology for naming CSS classes. The BEM approach ensures that everyone who participates in the development of a website works with a single codebase and speaks the same language. Using proper naming will prepare you for the changes in the design of the website.

While base theme classnames are not yet entirely BEM, we keep moving towards this goal; bear this in mind when refactoring layouts and making additions.

The following specific classnames should be present and used in most project stylesheets:

-   .site-header
-   .container - utility class to set width and margins
-   .logo
-   .main-nav, .menu, .primary-menu, .footer-nav
-   .hero, .site-footer
-   .copyright

Avoid selecting classnames based on specific page content - opt instead for a more generic name that describes its purpose/utility.

**SCSS files and locations**
Sass files are located in the `assets/sass` folder.

In many directories you will notice a top-level `__all` partial. Like `index.html` or `index.js`, these files exist as an easy entry point and to quickly import all partials from that folder.

The first folder `_utilities` contains Sass partials that are solely mixins, functions, and variable definitions.

A CSS reset and base style defintions are found in `base`. The partials in `modules` style more specific elements or sections of the site like the header and footer. Lastly `templates` contains partials that correlate to the WordPress templates where they will be included - for example front page styles are often different from page template styles, and are conditionally loaded in this theme.

The `flex` directory contains Sass stylesheets for each of the ACF flexible content layouts available in our theme. Notice that the stylesheets and layouts use the exact same *slug*; this is because these styles are automatically inlined using a theme action before our flex loop. Keep this in mind when adding new layouts, or renaming existing ones.

Apart from flex stylesheets, only top level scss files in `assets/sass` are built to `dist/css`

Theme component CSS and Sass files are found alongside their class definitions and and are built to `dist/css` with their filenames intact.

## Accessibility

Here are basics to maintain accessibility standards.

* Use Skip to content link 
    * Built into the header
* [Use ARIA: Roles, states, and properties](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/ARIA_Techniques)
* Write in plain English
* Always use alt text for images
    * Consitantly using wordpresses built in's for images will usually make sure alt info is pulled from the db
    * if getting the image via wp_get_attachment_image or making the image yourself you need to make sure to aslo check the images post meta for alt test
    * Don't use a generic fallback like "image" if no alt is available. If alt isn't there, enter it yourself!
* Avoid directional language (e.g., “click the box on the right to learn more”)
* Create meaningful link text (anchor text) … i.e., try to avoid “click here”
* Open links to new web pages in the same window
* Restrict the use of tables to tabular data
* Use headings properly
    * Follow h1's with h2's and so on as you descend the dom. 
    * Don't use heading tags to get the size / style you want for text.

## Colors

Colors are usually provided in the projects style guide. These are the only colors that should be used for the project, Ouadapt_devde of darkening / lightening or enutrals like blacks and greys.

When you get a style guide you can quickly apply and use those colors in the base theme. Go to `assets/sass/_utilities/_vars.scss` and you'll find vars to replace with the projects colors. These vars are available in any scss file, so use them throughtout the project.

The vars should be used for almost all your coloring. Random colors in the css should be avoided for code maintainability and design consistency. If there are missing or unspecified colors, contact your team lead or project manager. 

## Linking

Links to internal pages and off site should open in the same window. Links to different document types that use an external application, such as pdfs or Word documents, can open in a new window. A link within a form can also open in a new window so users don’t lose information they may have entered.

All links should use meaningful anchor text. Do not use full URLs as the link text. Do not use **“click here.”**

-   _Wrong:_ View information about Gravity Forms here: [https://domainname/gravity-forms](#)
-   _Wrong:_ [Click here](#) to view information about Gravity Forms
-   **Correct:** View information about [Gravity Forms](#)

Do not use a person’s name as the anchor text if you’re linking to an email address. When the anchor text is the person’s name, the link should point to a web page about that person.

-   _Wrong:_ Contact [Jane Jones](#).
-   **Correct:** Contact Jane Jones at [jjones@domain.com](#) or [email me](#).

If linking to an external file, provide a hint to the user by putting the file type in parentheses.

-   Use standard PC file extensions (.pdf, .doc, .ppt, etc.)
-   Include the file type as part of the anchor text
-   **Example:** [View the door code policy (pdf)](#) for more information.

## Image Element Standards

When uploading an image to the media library, be sure its size is equal or greater than the minimum dimensions needed for proper use. Do not upload images exceeding 72dpi and avoid images larger than 1800px in width, 1800px in height.

Don't worry about an image's dimensions being too big while uploading. All images should be cropped or downsized in templates before being output on a page.

**Optimization - Important!**
The base theme doesn't currently support media library image optimization. So be sure to use a plugin like Smush or a tool like Squoosh to ensure the images in the library are in a performant file format and optimized in size for the web.

**Suggested naming convention**
(the type of graphic element) – (section) – (name) . (jpg/png/gif/svg)

Abbreviations for types of graphic elements:

-   bg: background images
-   hero: hero images
-   icon: icons
-   img: in-page photos (any photo that’s not a hero)
-   thumb: thumbnail images

_Example:_
A background image of the hero section for the TracTru project: bg-hero-dots.jpg

**Formatting/Usage Rules**

-   Use custom thumbnails sizes and use the appropriate size for the task
-   Do not use a higher resolution than 72 dpi.
-   Photos must be responsive.
    - Using wordpress's built ins will help ensure this
-   All images must have alt text to comply with accessibility standards.

## Theme Hooks

[Theme Hooks Alliance is dead](https://github.com/zamoose/themehookalliance/). Long live Theme Hooks Alliance!

AdaptDev Base Theme includes a handful of action hooks the facilitate easy customization.

- adapt_dev_before_html
- adapt_dev_body_open
- adapt_dev_body_close
- adapt_dev_head_open
- adapt_dev_head_close
- adapt_dev_header_before
- adapt_dev_header_after
- adapt_dev_header_top
- adapt_dev_header_bottom
- adapt_dev_content_before
- adapt_dev_content_after
- adapt_dev_flex_loop_before
- adapt_dev_flex_loop_after
- adapt_dev_flex_section_before
- adapt_dev_flex_section_after
- adapt_dev_footer_before
- adapt_dev_footer_after
- adapt_dev_footer_top
- adapt_dev_footer_bottom

## Plugins

Projects should be pre-loaded with necessary plugins, however, if the need for additional plugin arises, research the best solution and present it to the team dev lead and/or project manager. Be sure it is not on the [WPEngine Disallowed List](https://wpengine.com/support/disallowed-plugins/)

Suggested plugins for common tasks:
Forms:              Gravity Forms
Image optimization: Smush
Import/export:      WP All Import
GTM:                Google Tag Manager for Wordpress
SEO:                Yoast SEO
Post relationships: Toolset

## Menus

Menus should be responsive and accessable. The base code should get you most of the way there.
The built in menu system includes some extra accesability features:
- Responsive desktop (dropdown) and mobile (off-canvas) primary menu styling
- Correctly applied ARIA attributes, keyboard navigable anchors, and focus styles
- CSS transitions

## Base Theme ACF Conventions
**Non-Active Field Groups (Partials)**
Whenever you have an input or inputs that could be on multiple flex layouts, make them in a field group. This group should be inactive and can then be used in flex layouts, cloned in.
All non active field groups e.g. Button, Section should be named simply, but uniquely. So for the Image field group which has a media selector and text field, image and label would be good names. Adding another similar Icon field group, good names might be icon and icon-label. 
You should decide on a per group basis whether or not the fields should be "grouped" (though that will actually be set on the flex layout side).

**Flex Layouts (Page Sections)**
Flex layouts are the page sections or blocks that the end user will be able to select and build their page out of.

Flex Layouts should be named uniquely and simply. Their name should be used as a prefix to any layout specific fields (fields that aren't cloned from a field group). So a Hero Image layout could have the name hero or hero-image. It's unique fields like text alignment would a get a name like hero_text-alignment. A flex layout should represent a single "section" of a page. So they should be independent of other layouts and relatively simple in scope. More complicated layouts may provide more options to the user, but they also leave more room for the user to break from the sites design or introduce untested combinations. Balance appropriately.

A flex layout should clone in the "Section" field group.

Many cloned field groups should be set to display as a "Group", The default is "Seamless". so you should make sure that if you set a field group to "Group", then it should be set that way on every layout it's cloned into. That way the group will always require the same call to access it in templates.
In the case you need to clone multiples of the same field group, e.g. two Images or three Buttons. This would be a new field group (maybe a repeater that clones in the original) to avoid naming collisions

**Names for common layouts / fields**
The field group that contains the user facing flex layouts should be named "Content Sections". The button being "Add Content Section".
The flex layout for a single wysiwyg field only should be named "Content Editor".
The flex layout for columns should just be called "Columns".

**Flex Layout Templates**
Each Flex layout should have it's own template part. The file should be named `template-parts/layout-{layout-name}.php` If this layout has cloned in a field group like button, it should default to using that field group's template part to include a button. Of course you'll often need a button to be different in the current layout and that's cool too. You can write the custom layout directly in the flex layout file, or in a separate layout file named `template-parts/partials/{layout-name}_{field-group-name}.php`
The layout template should start with a `<section>` tag (unless something like article or aside is more appropriate) and use the `adapt_dev_section_classes` template tag.

**Flex Layout Stylesheets**
Flex layouts typically have their own associated styles. Before looping through a page's flexible content fields, this theme gathers together and inlines associated styles from `assets/sass/flex`. Add a new file, `assets/sass/flex/{layout-name}.scss` when creating a new flex layout to include its styles.

**Field Group Templates (Partials)**
Each field group intended to be cloned into flex layouts should have its own template part. The file should be named `partials/{field-group-name}.php`. It should be independent of any flex layout template it might be used in. They should be able to function with only the fields provided by the field group. So they should not require any fields from a parent flex layout. These will often be very simple. In the case of Image it might just be the call to `wp_get_attachment_image`. They exist to provide an easy starting point for new flex layouts that want to use this field group. They also are a good way to make changes to buttons or other basic elements through the site in one file. They can also be an example of recommended layouts or classes and even best practices when the developer needs to make something unique.

**Misc. Layout Templates**
Any other layout templates you need to make can be called `layout-{unique-name}.php`.

## Performance

The base theme includes a handful of performance features out of the box. Any additional features will need to be implemented by you, the developer.

Out of the box features:
- Conditional loading of scripts and styles, lazy and defered loading, and file bundling.
- Async loading of all WordPress scripts, including plugin scripts (can be toggled via an option).
- Tactically preloaded styles and images that help improve the critical rendering path.
- Optimized web font loading.
- Asset minification.
- Image optimization.

Features that have tools provided, but you must implement
- Lazy loading for background images.
- Critical CSS (option toggle in `functions.php`, and with a `DEV_URL` set in your `.env` file).
- Image re-sizing and re-formatting (must be done in template and the media manager).

Performance testing is built into the base theme through a Gulp task that leverages the Lighthouse Node API. The only thing you need to do is provide a URL for your local instance or remote development environment. The test will provide details on key expereiential metrics like LCP and CLS. A full HTML report is also saved as `lhreport.html` in the theme root.

## Components

The Base theme has a few built in components that provide standalone functionality to the base theme. Lazy loading images and basic primary navigation functionality are two examples. You'll find them in the components folder. Components are written as PHP classes, with accompanying js/css files when necessary. They are loaded via from within the file `componenets/functions.php`.

You can think of components like plugins, just lower level and more tightly integrated to the base theme. If you have some functionality to add and you can self contain it, maybe some new shortcodes, consider making it a component. Components are highly portable and can be enabled / disabled with one line of code.

### Customizer Component

The Customizer component is a PHP class much like the one included in WordPress' default themes. Instead of registering settings all together in one method, however, settings or groups of settings are separated into their own PHP class that extend the abstract class CustomizerSetting.

To create a new setting using this component:
1. Create a new class definition file in `components/Customizer/CustomizerSettings` that extends `AdaptDevBase\Components\Customizer\CustomizerSetting`.
2. The only required method is `action_customize_register()`, which will be fired on the WordPress `customize_register` action hook and used to register your settings and controls. This method receives the global `WP_Customize_Manager` instance as an argument.
3. Instantiate your new setting in the Customizer class in the array of `$enabled_settings`.

Note on namespaces: Base Theme components utilize [namespaces](https://www.php.net/manual/en/language.namespaces.php) to avoid naming collisions, which means accessing globally defined classes like `WP_Customize_Control` or `WP_Customize_Manager` require a [use statement](https://www.php.net/manual/en/language.namespaces.importing.php).


## Meta and structured data ##

The base theme provides basic seo meta data. Title and description are included. Title is dynamic per page, but the description is static for the whole site (set in the wp dashboard).

Structured data should be implemented per template / layout if it would make sense to do so.


## Things that are not allowed

-   Custom fonts not included in the style guide
    - Try to keep plugins that require their own fonts and stlye to a minimum
-   Custom colors not included in the style guide
-   Images without alt text
-   Underlined text, unless it’s a link
-   Use of unauthorized plugins or JS libraries
-   Bad websites ;)