# Learning Resources

A WordPress plugin for structured learning content. It keeps curriculum resources, step-by-step tutorials and facilitated workshops as distinct content experiences while sharing a common Modules taxonomy.

## Content types

- **Learning Resources** (learning_resource): hierarchical curriculum content such as lessons, sub-lessons, topics, exercises and assessments. Existing parent/child relationships and ordering are retained.
- **Tutorials** (tutorial): standalone, step-by-step guides. Metadata supports an introduction, estimated duration, prerequisites, learning outcomes and ordered steps with explanatory content and code examples.
- **Workshops** (workshop): standalone facilitated learning experiences. Metadata supports facilitator details, delivery format, venue, sessions, video recordings and supporting materials.
- **Insights** remain ordinary WordPress posts and are not changed by this plugin.

All three plugin content types can be classified with the shared hierarchical Modules taxonomy. The plugin provides the content model and REST API fields; the active WordPress theme or separate frontend application is responsible for presenting each type with its own layout.

## REST API

- Learning Resources: /wp-json/wp/v2/learning-resources
- Tutorials: /wp-json/wp/v2/tutorials
- Workshops: /wp-json/wp/v2/workshops
- Modules: /wp-json/wp/v2/learning-modules

Custom metadata is exposed through each post's meta REST field. Updating metadata requires an authenticated user who can edit the relevant post.

## Installation

1. Copy this repository into wp-content/plugins/learning-resources.
2. Activate Learning Resources in WordPress.
3. Use the Learning Resources, Tutorials and Workshops menus in the dashboard.
4. Assign content to Modules to connect it to the wider curriculum.

## Development

Requires WordPress 6.6+ and PHP 7.4+. The plugin uses native custom post types, taxonomies, post metadata and REST API registration. It does not impose frontend templates, allowing a theme or frontend application to build distinct Tutorial and Workshop experiences.
