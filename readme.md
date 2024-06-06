# Demo Project: Classified Ads Website

This is an educational project with sample data that can be enhanced and developed further into a fully functional application.

![Klein](https://klein.braslavskii.com/klein.jpg)

## Technologies Used

- Laravel
- Docker Compose
- Nested Sets
- Laravel Scout
- and other cutting-edge technologies

## Overview

The project is a classified ads website that caters to three types of users: administrators, members, and guests.

## Demo

You can run the project on your local computer by following the instructions below or you can explore the project at the link - [klein.braslavskii.com](https://klein.braslavskii.com)

### Demo description

1. Created more than 100 categories for ads
2. All regions of Germany are created with division from lands to cities
3. Randomly generated 100 ads in different categories - each ad contains from 1 to 5 pictures, description
4. Created 100 users with random statuses

To access the admin panel use login/password

    admin@klein.loc
    123123

After authorization you will have two additional links in the menu - **Profil** - to manage your ads and **Admin** to go to the admin panel.

You admin panel you can manage users, regions, ads.

You can make any changes - the site is periodically restored to its initial state.

## Key Features

1. **Create, Edit, and Moderate Ads**: Users can create new ads, edit existing ones, and moderate ads based on certain criteria.

2. **Favorites**: Users can add ads to their favorites list for quick access.

3. **Ad Parameters and Images**: Ads can have various parameters depending on their category and can include images.

4. **Geographical Focus**: The project revolves around Germany, with pre-populated categories and cities from different districts and regions of the country.

5. **Multilingual Support**: The project is available in both English and German, utilizing Laravel's built-in localization mechanisms.

6. **Full-Text Search**: Integrated full-text search using Laravel Scout and Typesense for efficient and accurate search results.

7. **SMS Service and Two-Factor Authentication**: A virtual SMS service has been implemented for sending messages and enabling two-factor authentication.

8. **OpenStreetMap Integration**: The project integrates with OpenStreetMap for location-based functionalities.

## Setup Instructions

To run the project, follow these steps:

1. Clone the repository.
2. Install Docker Compose if not already installed.
3. Build and run the Docker containers - or - you can simply run `make init` - for the first time - it will build the containers, create database, seed the initial data. 
4. Set up the database and run migrations.

Commands:
- `Make test` - initiate PHPunit tests.
- `Make start` - start Docker.
- `Make down` - stop Docker.
- `Make init` - first start of the project.
- `Make asset` - create a new asset file.
- `Make refresh` - run a migrate refresh with seeder.
- `Make migratetest` - run a migrate refresh with seeder for the test database.

Special commands:
- `php artisan user:verify {email}` - verify a user.
- `php artisan user:role {email} {role}` - switch a user to a new role.

5. Seed the database with sample data.

To seed a test database: `docker compose exec php php artisan migrate --env=testing --seed`.

6. Access the project through the browser.

## Disclaimer

This project is for educational purposes and may contain bugs or incomplete features. It is not intended for production use.
During first installation it will take time to download demo images for ads.
