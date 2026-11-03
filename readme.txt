=== Learning Resources ===
Contributors: michael-bertram
Tags: learning, lessons, tutorials, workshops, curriculum, education
Requires at least: 6.6
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 0.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create structured learning resources, step-by-step tutorials and facilitated workshops, organised with a shared Modules taxonomy.

== Description ==

Learning Resources provides three distinct content types: hierarchical Learning Resources for curriculum content, Tutorials for structured step-by-step guides, and Workshops for facilitated sessions with recordings and materials. All three can be classified with the shared hierarchical Modules taxonomy.

Insights remain standard WordPress posts. The plugin supplies content models and REST API metadata; frontend layouts are provided by the active theme or frontend application.

== Installation ==

1. Upload the plugin folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. Use Learning Resources, Tutorials and Workshops to create content.

== REST API ==

* Learning Resources: /wp-json/wp/v2/learning-resources
* Tutorials: /wp-json/wp/v2/tutorials
* Workshops: /wp-json/wp/v2/workshops
* Modules: /wp-json/wp/v2/learning-modules

== Changelog ==

= 0.2.0 =
* Add dedicated Tutorial and Workshop content types.
* Add REST-enabled structured metadata for tutorial steps and workshop sessions/materials.
* Share the Modules taxonomy across all plugin content types.
* Preserve the existing Learning Resources hierarchy and metadata.

= 0.1.0 =
* Initial release of the content model, taxonomy and REST-enabled metadata.
