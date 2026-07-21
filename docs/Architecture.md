# Architecture

## Overview

This Wild Life is a custom WordPress website hosted on Bluehost.

The project separates presentation, application functionality, stored content and uploaded media instead of placing the entire application inside the theme.

```text
Browser
→ WordPress theme
→ This Wild Life Core plugin
→ WordPress functions and REST API
→ MySQL database
```

## Theme

The custom theme is stored under:

```text
theme/thiswildlife-theme/
```

The theme controls presentation, including:

- Page templates
- Header and footer
- Book card and modal layouts
- CSS
- Browser-side JavaScript
- Responsive behaviour
- Decorative site assets

The theme queries published Book records and generates the collection dynamically.

It does not define the Book data structure or user permissions. Those responsibilities remain in the plugin so changing the visual theme would not remove the underlying Book management system.

## Core Plugin

Custom functionality is stored under:

```text
plugins/thiswildlife-core/
```

The plugin:

- Registers the `twl_book` custom post type
- Adds the Book editing interface
- Validates and saves Book fields
- Enables front-cover images
- Defines Book-specific permissions
- Creates the This Wild Life Publisher role
- Enables WordPress REST API support for the Book post type

The main plugin file handles plugin setup, post-type registration and permissions.

Additional Book field logic is separated into:

```text
includes/book-fields.php
```

This avoids placing all application logic inside either the theme’s `functions.php` file or one oversized plugin file.

## Book Data Model

Each Book is stored as an individual WordPress record.

Standard WordPress fields are used for:

```text
Title
Full description
Short description
Publication status
Featured image
```

Custom metadata is used for:

```text
Author
Format
Minimum age
Maximum age
Price
Amazon URL
Availability
Display order
```

The current availability choices are:

```text
Coming soon
Available
Out of stock
Unavailable
```

Amazon URLs are optional. When a Book has no Amazon URL, the purchase button is hidden.

## Database and Images

WordPress uses the Bluehost MySQL database.

The main Book record is stored through WordPress’s posts system. Additional Book fields are stored as post metadata.

Cover-image files are stored in the WordPress Media Library under the uploads directory. MySQL stores the attachment relationship rather than storing the image file itself.

```text
MySQL
├── Book records
├── Book metadata
└── Image attachment references

Media Library
└── Cover-image files
```

Code deployment does not replace or synchronize this content.

## Books Page

The original Books page contained five Book cards hardcoded in `page-books.php`, with additional details stored inside a JavaScript object.

The revised page uses `WP_Query` to request published `twl_book` records from MySQL.

```text
MySQL Book records
→ WP_Query
→ Theme loop
→ Generated Book cards
→ JavaScript modal
```

The JavaScript reads the generated card data instead of maintaining a separate hardcoded list. Adding or editing a Book in WordPress therefore updates the collection without requiring PHP or JavaScript changes.

## Users and Permissions

Two levels of access are currently required:

### Administrator

The site developer retains the WordPress Administrator role and can manage:

- Books and other content
- Users
- Themes and plugins
- Site configuration
- Deployment and hosting

### This Wild Life Publisher

Charlie can be assigned the restricted This Wild Life Publisher role.

This role can:

- Add Books
- Edit Books
- Publish and unpublish Books
- Delete Books
- Upload cover images

It cannot:

- Edit themes or plugins
- Change site settings
- Install software
- Manage users
- Access hosting or deployment credentials

WordPress authentication confirms who is logged in. Custom Book capabilities determine what that user is authorized to do.

## Validation and Security

Book fields are protected by:

- WordPress nonces
- Login requirements
- Book-specific capability checks
- Autosave protection
- Text sanitization
- URL sanitization
- Numeric validation
- Allowed-value checks for availability
- Escaping when values are displayed

Public visitors can view published Books but cannot create, edit or delete them.

## Relationship to the Previous College Project

The architecture uses the same separation principles as the earlier Express, MongoDB and Angular project, while using tools appropriate for WordPress.

```text
Previous project             This Wild Life

Pug/Angular views         →  WordPress theme
Express controllers       →  Plugin functions and save handlers
Mongoose model            →  Book post type and metadata fields
MongoDB documents         →  WordPress Book records in MySQL
Passport authorization    →  WordPress roles and capabilities
REST API                  →  WordPress REST API
```

MongoDB, Mongoose, Express and Angular were not added because WordPress already provides database access, routing, authentication, content management and an API layer.

The project follows the same architectural ideas without duplicating services that WordPress already supplies.