# Learning Resources

A WordPress plugin for creating structured learning content, from modules and lessons to nested sub-lessons, topics, exercises and assessments.

## Current features

- Hierarchical **Learning Resources** custom post type.
- Hierarchical **Modules** taxonomy for curriculum classification.
- WordPress block editor and REST API support.
- Native parent/child hierarchy and ordering through page attributes.
- Resource metadata registered for the REST API: type, estimated duration in minutes, difficulty, and learning objectives.
- Rewrite rules flushed on activation and deactivation.

## Content model

Every piece of learning content is a Learning Resource. The parent/child hierarchy describes its position in the curriculum; the resource type describes what it is.

```text
WordPress – Full Site Editing
├── Introduction to Full Site Editing
├── Block Themes
│   ├── What is a Block Theme?
│   ├── Theme Structure
│   │   ├── Templates
│   │   ├── Template Parts
│   │   └── theme.json
│   └── Creating Your First Block Theme
└── The Site Editor
    ├── Navigation
    ├── Styles
    └── Template Editing
```

Numbering should be calculated from the hierarchy and menu order, not typed into titles.

## Installation

1. Copy this repository into `wp-content/plugins/learning-resources`.
2. Activate **Learning Resources** in WordPress.
3. Open **Learning Resources** in the dashboard.
4. Use the parent resource selector and order controls to organise the hierarchy.

## REST API

- Post type: `/wp-json/wp/v2/learning-resources`
- Taxonomy: `/wp-json/wp/v2/learning-modules`

Registered resource metadata is exposed in the REST API for authenticated users with permission to edit the resource.

## Roadmap

- Editor sidebar for resource metadata.
- Curriculum overview in the dashboard.
- Module, curriculum and navigation blocks.
- Breadcrumbs and previous/next navigation.
- Foundations for learner progress, exercises, quizzes and assessments.

## Development

This is the initial PHP foundation. The editor UI and front-end blocks are planned next.
