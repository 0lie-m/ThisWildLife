# Development Log

## Project foundation

The existing This Wild Life website was originally developed as a static HTML, CSS and JavaScript website and later converted into a custom WordPress theme hosted on Bluehost.

The live WordPress theme was previously edited manually through Bluehost File Manager. This process provided no proper staging workflow and made changes directly to the production website.

A new GitHub repository was created to make the WordPress implementation the authoritative version of the project. The project will use separate development and production branches, a Bluehost staging website and Git-based deployment.

The initial live theme was backed up and copied into the repository without modification.

## Milestone 1 - Git Repository and Branch Workflow

A new GitHub repository was created for the WordPress version of the project.

The repository was structured to separate the WordPress theme, future plugin development and project documentation.

A development (`dev`) branch was introduced alongside the production (`main`) branch. The first pull request was successfully created and merged into `main`, establishing the version control workflow that will be used throughout the project.

Future development will follow the workflow:

Feature Development → dev → Pull Request → main → Production.