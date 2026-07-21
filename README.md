# This Wild Life

This Wild Life is a custom WordPress wildlife and children's book website hosted on Bluehost.

The project began as a static HTML, CSS and JavaScript website before being converted into a custom WordPress theme. It is now developed as a small full-stack WordPress application with database-driven content, a custom REST API, restricted publishing permissions, staging and Git-based deployment.

## Current features

- Custom responsive WordPress theme
- Database-driven Book collection
- Custom Book post type and editing interface
- Front-cover uploads through the WordPress Media Library
- Manual Book availability management
- Optional Amazon links
- Restricted This Wild Life Publisher role
- Custom read-only Books REST API
- Separate Bluehost staging and production environments
- GitHub feature, development and production branches
- Automatic `dev` deployment to staging
- Manually approved `main` deployment to production

## Technology

- WordPress
- PHP
- JavaScript
- CSS
- MySQL
- WordPress REST API
- Git and GitHub
- Bluehost
- cPanel Git Version Control
- Bash
- Cron

## Architecture

```text
Public website
-> WordPress theme
-> This Wild Life Core plugin
-> WordPress functions and WP_Query
-> MySQL database
```

The theme controls the website's presentation and page templates.

The custom plugin defines Book functionality, custom fields, validation, user permissions and REST API routes.

WordPress and MySQL store Book records, page content and website settings. Cover-image files are stored in the WordPress uploads directory and managed through the Media Library. The database stores references to those images.

More information is available in [Architecture.md](docs/Architecture.md).

## Repository structure

```text
ThisWildLife/
|-- deployment/
|   |-- deploy-staging-if-changed.sh
|   `-- deploy-wordpress.sh
|-- docs/
|   |-- API.md
|   |-- Architecture.md
|   |-- Deployment.md
|   `-- DevelopmentLog.md
|-- plugins/
|   `-- thiswildlife-core/
|       |-- includes/
|       |   |-- book-fields.php
|       |   `-- book-rest-api.php
|       `-- thiswildlife-core.php
|-- theme/
|   `-- thiswildlife-theme/
|-- .cpanel.yml
|-- .gitignore
`-- README.md
```

Only custom project code and documentation are tracked. WordPress core files, uploaded media, database exports, configuration files and secrets are excluded.

## Book management

Books are managed through the protected WordPress dashboard.

Each Book can contain:

- Title
- Short description
- Full description
- Front-cover image
- Author
- Format
- Minimum and maximum reader age
- Price
- Optional Amazon URL
- Availability
- Display order

Published Books are retrieved from the WordPress MySQL database and displayed dynamically by the theme. Adding or editing a Book no longer requires changing PHP or HTML code.

Public visitors can view published Books but cannot create or edit them.

A restricted **This Wild Life Publisher** role is available for Book management. It can manage Books and upload cover images without receiving access to themes, plugins, users, website settings or hosting tools.

## REST API

The project includes a custom versioned, read-only REST API.

Get all published Books:

```http
GET /wp-json/thiswildlife/v1/books
```

Get one published Book:

```http
GET /wp-json/thiswildlife/v1/books/{id}
```

The API retrieves published Book records from MySQL and returns structured JSON responses. Unknown, private and unpublished Book IDs are not returned by the individual endpoint.

The production collection endpoint is available at:

```text
https://thiswildlife.org/wp-json/thiswildlife/v1/books
```

The API does not provide public create, update or delete routes. Book changes remain protected by WordPress authentication and custom capabilities.

See [API.md](docs/API.md) for the endpoint reference, response fields, security decisions and testing results.

## Branch workflow

```text
Feature, fix, test or documentation branch
-> Pull request into dev
-> Automatic staging deployment
-> Staging testing
-> Pull request from dev into main
-> Manual production deployment
```

`dev` contains the latest integrated development work and is connected to the Bluehost staging environment.

`main` contains production-approved code and is connected to the live website.

Temporary branches are used for individual changes and are merged into `dev` through pull requests.

## Deployment

A cPanel Cron Job checks the remote `dev` branch every five minutes. If it detects a new commit, it updates the staging repository and deploys the theme and plugin code automatically.

Production deployment remains manual. After staging testing is complete, `dev` is merged into `main`. The production cPanel repository is then updated and its HEAD commit is deployed deliberately.

The shared deployment script checks the currently checked-out branch:

```text
dev
-> Bluehost staging WordPress installation

main
-> Bluehost production WordPress installation
```

Other branches are refused by the deployment script. This prevents a feature or test branch from being deployed directly to either website.

Git deployment copies custom theme and plugin code only. It does not synchronize WordPress databases, uploaded media, pages or website settings.

See [Deployment.md](docs/Deployment.md) for the full workflow and recovery information.

## Relationship to the college project

The project uses the same separation of responsibilities as the earlier Express and MongoDB full-stack project, adapted for WordPress.

```text
College project:
Views
-> Express controllers
-> REST API
-> Mongoose models
-> MongoDB

This Wild Life:
WordPress theme
-> This Wild Life Core plugin
-> WordPress REST API
-> WordPress content model and WP_Query
-> MySQL
```

The technologies differ, but both projects separate presentation, application logic, API behaviour and stored data.

## Development history

The development log records the project's architecture decisions, completed milestones and problems encountered during implementation.

It includes the move from manual live-server editing to Git deployment, the database-driven Book system, the staging automation and the solutions to deployment and file-tracking issues.

See [DevelopmentLog.md](docs/DevelopmentLog.md).

## Current status

The database-driven Books system and custom REST API are live in production.

The current workflow is operational:

```text
Local development
-> feature branch
-> dev
-> automatic staging deployment
-> testing
-> main
-> manual production deployment
```

The restricted publisher account will be created with the website owner during a future meeting.

## Security

The repository must not contain:

- `wp-config.php`
- Database exports
- Passwords
- API keys
- SSH private keys
- Environment files
- Website backups

The public API exposes only information intended for public visitors. WordPress authentication and custom capabilities protect Book creation, editing, publishing and deletion.

The repository is currently public so cPanel can retrieve it without private-repository credentials. Private repository authentication can be configured later if the repository visibility changes.