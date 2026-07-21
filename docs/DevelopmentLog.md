# Development Log

## Project background

This Wild Life began as a static HTML, CSS and JavaScript website. I later converted it into a custom WordPress theme hosted on Bluehost.

Before this project update, I changed the live website by manually editing or uploading theme files through Bluehost File Manager. Although this worked, it meant that changes were being made directly to production without a proper staging or deployment process.

I started this update to give the website a clearer full-stack structure and a safer development workflow.

## Milestone 1: Repository and branch workflow

I created a new GitHub repository for the WordPress version of the website.

The repository separates:

```text
theme/
plugins/
docs/
deployment/
```

I introduced two main branches:

```text
main = production-approved code
dev = staging and active development
```

Individual changes are developed on temporary feature, fix, test or documentation branches. They are merged into `dev` using pull requests.

During the initial setup, I completed my first pull request and merge. I also accidentally merged one feature into `main` before testing it on staging. Because production deployment was not connected, the live website was unaffected. I corrected the branch state by merging the same feature into `dev` without resetting or rewriting Git history.

This helped me understand why the pull request base and comparison branches must be checked before merging.

## Milestone 2: Staging environment

I created a Bluehost staging copy of the WordPress website.

The staging environment has its own WordPress installation and database. It allows code and content changes to be tested without affecting visitors on the production website.

The staging site remained private and unlaunched while the Book system and deployment workflow were developed.

## Milestone 3: Core plugin and Book model

I created a custom plugin called:

```text
thiswildlife-core
```

The plugin registers a custom WordPress post type called `twl_book`.

Each Book now has its own record containing:

```text
Title
Full description
Short description
Front-cover image
Author
Format
Minimum age
Maximum age
Price
Amazon URL
Availability
Display order
```

The plugin also adds the Book Details editing panel and securely validates submitted values.

This replaced the previous approach where Book content was hardcoded across the PHP template and JavaScript file.

## Milestone 4: Database-driven Book collection

I created the five existing Books as records in the staging WordPress database:

1. Brigid the Badger
2. Fionn the Fox
3. Holly the Hedgehog
4. Peadar the Puffin
5. Puck Fair Mystery

The records were initially saved as drafts and then published inside staging.

Cover images were uploaded through the WordPress Media Library. The image files are stored in the uploads directory, while MySQL stores their attachment references.

I updated `page-books.php` to use `WP_Query` to retrieve published Books from MySQL and generate the Book cards automatically.

I also updated `books.js` so the modal reads the generated Book data instead of using a separate hardcoded JavaScript object.

After this change, a Book can be added or edited through WordPress without changing PHP or JavaScript.

## Milestone 5: Publisher permissions

I added a restricted WordPress role called:

```text
This Wild Life Publisher
```

This role is intended for Charlie.

It allows Book management and cover-image uploads but does not allow access to themes, plugins, users, site settings or hosting credentials.

I retained the Administrator role for development and technical management.

The permission system uses custom WordPress capabilities instead of relying on the standard Author role. This keeps Book permissions separate from ordinary blog-post permissions.

## Milestone 6: Git-controlled staging deployment

I enabled Bluehost shell access and created a cPanel-managed Git repository outside the public website directory.

The repository is checked out on `dev`.

I added `.cpanel.yml` to define which repository folders are copied into staging:

```text
theme/thiswildlife-theme
plugins/thiswildlife-core
```

The first deployment was triggered manually through cPanel and completed successfully.

The deployed commit SHA matched the repository HEAD SHA, confirming that the intended code had reached staging.

## Milestone 7: Automatic staging deployment

I added a server-side deployment script and configured a cPanel Cron Job to run every five minutes.

The script:

1. Fetches the latest GitHub `dev` branch.
2. Compares it with the current cPanel commit.
3. Exits when there are no changes.
4. Fast-forwards the repository when a new commit exists.
5. Triggers the cPanel deployment service.

I tested the workflow using a harmless HTML comment.

The test commit was merged into `dev` at 12:33 AM and automatically deployed by cPanel at 12:35 AM. I did not press the Update or Deploy buttons manually.

This confirmed the workflow:

```text
Feature branch
→ Pull request
→ dev
→ automatic cPanel check
→ staging deployment
```

## Problems encountered and solutions

### Nested Git repository

The original theme ZIP contained its own hidden `.git` directory.

As a result, the main repository did not detect changes made inside the theme. I confirmed the nested repository through the terminal, removed only its internal Git metadata and then added the actual theme files to the main repository.

### Full theme ZIP update failed

Replacing the full theme ZIP on staging failed because WordPress could not copy several existing image directories.

WordPress rolled back to the previous active theme. I then replaced only the two changed files through the staging File Manager.

Later deployments used cPanel Git and no longer required full theme ZIP uploads.

### Amazon button remained visible

JavaScript correctly applied the `hidden` attribute when an Amazon URL was empty, but the shared `.btn` CSS rule forced the button to display.

I added a scoped CSS rule:

```css
.modal-actions [hidden] {
  display: none !important;
}
```

I used this fix as the first end-to-end Git deployment test.

### Cron Job could not find its script

The automatic deployment initially failed with:

```text
No such file or directory
```

I checked the Cron log and discovered that the shell script had not been committed to GitHub.

I recreated the script under the correct `deployment/` directory, confirmed that Git tracked it, merged it into `dev` and performed one manual bootstrap deployment.

The following test commit deployed automatically.

## Relationship to my previous full-stack project

My previous college project used:

```text
Express
Mongoose
MongoDB
REST APIs
Angular
Passport
```

This project uses different tools because WordPress already supplies many of those services.

The main comparison is:

```text
Previous project             This Wild Life

Views                     →  WordPress theme
Controllers               →  Plugin functions
Mongoose model            →  Book post type and metadata
MongoDB                    →  WordPress MySQL database
Passport                   →  WordPress roles and capabilities
REST API                   →  WordPress REST API
```

I followed the same principle of separating presentation, application logic, stored data and authorization without forcing MongoDB or Angular into WordPress.

## Current status

The project currently has:

- A custom WordPress theme
- A custom core plugin
- Database-driven Book records
- Secure Book editing
- A restricted Publisher role
- A private Bluehost staging environment
- GitHub branch and pull request workflows
- Automatic `dev` deployment to staging
- A manual fallback deployment process

Production deployment is not yet configured. The live website remains separate until the staging workflow and documentation are fully reviewed.