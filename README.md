# This Wild Life

This Wild Life is a custom WordPress wildlife and children's book website hosted on Bluehost.

The project began as a static HTML, CSS and JavaScript website before being converted into a custom WordPress theme. It is now being developed as a small full-stack WordPress application with database-driven content, restricted publishing permissions, staging and automated Git deployment.

## Current features

- Custom responsive WordPress theme
- Database-driven Book collection
- Custom Book editing interface
- Front-cover uploads through the WordPress Media Library
- Manual availability management
- Optional Amazon links
- Restricted This Wild Life Publisher role
- Bluehost staging environment
- GitHub feature and development branches
- Automated `dev` deployment to staging
- Manual deployment fallback through cPanel

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
- Cron

## Architecture

```text
Browser
→ WordPress theme
→ This Wild Life Core plugin
→ WordPress functions and REST API
→ MySQL database
```

The theme controls presentation.

The custom plugin defines Book functionality, validation and permissions.

WordPress and MySQL store Book records, page content and site settings. Cover-image files are managed through the WordPress Media Library.

More information is available in [Architecture.md](docs/Architecture.md).

## Repository structure

```text
ThisWildLife/
├── deployment/
│   └── deploy-staging-if-changed.sh
├── docs/
│   ├── Architecture.md
│   ├── Deployment.md
│   └── DevelopmentLog.md
├── plugins/
│   └── thiswildlife-core/
├── theme/
│   └── thiswildlife-theme/
├── .cpanel.yml
├── .gitignore
└── README.md
```

## Branch workflow

```text
Feature, fix, test or documentation branch
→ Pull request into dev
→ Automatic staging deployment
→ Staging testing
→ Pull request into main
→ Production
```

`dev` is connected to the Bluehost staging environment.

A cPanel Cron Job checks GitHub every five minutes. When it detects a new `dev` commit, it updates the cPanel repository and deploys the theme and plugin code to staging.

`main` is reserved for production-approved code. Automatic production deployment has not yet been configured.

See [Deployment.md](docs/Deployment.md) for the full process and manual fallback instructions.

## Book management

Books are managed through the protected WordPress dashboard.

Each Book can contain:

- Title
- Short and full descriptions
- Front-cover image
- Author
- Format
- Minimum and maximum reader age
- Price
- Amazon URL
- Availability
- Display order

Public visitors can view published Books but cannot create or edit them.

Charlie can be assigned the restricted **This Wild Life Publisher** role. This role can manage Books and cover images without receiving access to themes, plugins, site settings, users or hosting.

## Development history

The project development log records the architecture decisions, implementation milestones and problems encountered during development.

See [DevelopmentLog.md](docs/DevelopmentLog.md).

## Current status

The full staging workflow is operational:

```text
GitHub dev
→ automatic cPanel check
→ staging deployment
```

The production website remains separate and unchanged while staging development continues.

## Security

The repository must not contain:

- `wp-config.php`
- Database exports
- Passwords
- API keys
- SSH private keys
- Environment files
- Website backups

The repository is currently public to allow unauthenticated cPanel pulls. Private repository authentication will be configured before changing its visibility.