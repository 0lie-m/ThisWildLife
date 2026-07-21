# Deployment

## Overview

This Wild Life uses separate development, staging and production environments.

The staging deployment workflow has been automated using GitHub, cPanel Git Version Control, a cPanel deployment configuration and a scheduled Cron Job.

Production deployment has not yet been configured. The live website remains unchanged until changes are deliberately approved for production.

## Branches

- `main` contains production-approved code.
- `dev` contains code approved for staging.
- `feature/*`, `fix/*`, `test/*` and `docs/*` branches are used for individual changes.

Changes should normally follow this workflow:

```text
Feature or fix branch
→ Pull request into dev
→ Automatic staging deployment
→ Staging testing
→ Pull request from dev into main
→ Production deployment
```

## Staging Deployment

The cPanel-managed staging repository is checked out on the `dev` branch.

The repository is stored outside the public website directory. This prevents Git metadata and internal documentation from becoming publicly accessible.

The `.cpanel.yml` file copies only the custom application code into staging:

```text
theme/thiswildlife-theme
→ staging WordPress theme directory

plugins/thiswildlife-core
→ staging WordPress plugin directory
```

The deployment does not copy:

- The WordPress database
- Media Library uploads
- WordPress core
- Configuration files
- Passwords or credentials
- Project documentation
- Git metadata

## Automatic Deployment

A cPanel Cron Job runs every five minutes.

The Cron Job executes:

```text
deployment/deploy-staging-if-changed.sh
```

The script:

1. Checks the current cPanel repository commit.
2. Fetches the latest `dev` branch from GitHub.
3. Exits without deploying when nothing has changed.
4. Fast-forwards the cPanel repository when a new commit exists.
5. Calls the cPanel deployment service.
6. Runs the tasks defined in `.cpanel.yml`.

This means merging a pull request into `dev` automatically updates staging within approximately five minutes.

The automatic process was verified using a dedicated test commit. cPanel pulled and deployed the commit without either deployment button being pressed manually.

## Manual Fallback

If automatic deployment fails, the staging repository can be updated manually through:

```text
cPanel
→ Git Version Control
→ thiswildlife-staging
→ Pull or Deploy
→ Update from Remote
→ Deploy HEAD Commit
```

Manual deployment should only be used after checking the repository branch, HEAD commit and deployment destination.

## Database and Media

Git controls application code, but it does not synchronize WordPress content.

Book records are stored in the staging MySQL database. Cover images uploaded through WordPress are stored in the staging Media Library.

Therefore:

```text
Git
= theme and plugin code

MySQL
= Book records, pages and settings

Media Library
= uploaded cover files
```

This separation prevents code deployment from overwriting staging or production content.

## Security

- Production is not currently connected to automatic deployment.
- Deployment targets only the staging WordPress installation.
- No passwords, private keys or database credentials are committed.
- `wp-config.php`, environment files and backup archives must remain outside Git.
- The repository should not be made private until authenticated cPanel access to GitHub has been configured.
- Shell access and deployment permissions should remain limited to the hosting account owner.

## Troubleshooting

Deployment activity can be reviewed through cPanel Git Version Control.

Cron output is written to:

```text
$HOME/logs/staging-deploy.log
```

Useful checks include confirming that:

- cPanel is checked out on `dev`.
- `.cpanel.yml` exists at the repository root.
- The automation script exists under `deployment/`.
- The repository has no uncommitted server-side changes.
- The HEAD commit and Last Deployed SHA match after deployment.