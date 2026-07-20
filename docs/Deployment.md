# Development Log

## Project foundation

The existing This Wild Life website was originally developed as a static HTML, CSS and JavaScript website and later converted into a custom WordPress theme hosted on Bluehost.

The live WordPress theme was previously edited manually through Bluehost File Manager. This process provided no proper staging workflow and made changes directly to the production website.

A new GitHub repository was created to make the WordPress implementation the authoritative version of the project. The project will use separate development and production branches, a Bluehost staging website and Git-based deployment.

The initial live theme was backed up and copied into the repository without modification.