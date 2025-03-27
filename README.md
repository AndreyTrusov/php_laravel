# Laravel ORM Implementation

This project demonstrates the implementation of Object-Relational Mapping (ORM) in Laravel, focusing on a simple note-taking application with users, notes, and categories.

## Project Overview

The application allows users to create notes and organize them using categories. It provides a complete RESTful API for manipulating both notes and categories using Laravel's Eloquent ORM.

## Components

### Models

- **Category Model** - Represents categories with a name attribute
- **Note Model** - Represents notes with title, body, and associations to users and categories
- **User Model** - Standard Laravel authentication model

### Controllers

- **CategoryController** - Handles CRUD operations and search for categories
- **NoteController** - Manages notes with CRUD and search functionality

### Database Structure

- **users** - Stores user account information
- **categories** - Stores category names
- **notes** - Stores note content with user references
- **note_category** - Junction table for the many-to-many relationship

## API Endpoints

### Categories

- `GET /api/categories` - List all categories (sorted alphabetically)
- `GET /api/categories/{id}` - Get category by ID
- `POST /api/categories` - Create a new category
- `PUT /api/categories/{id}` - Update an existing category
- `DELETE /api/categories/{id}` - Delete a category
- `POST /api/categories/find-by-name` - Find a category by exact name

### Notes

- `GET /api/notes` - List all notes
- `GET /api/notes/{id}` - Get note by ID
- `POST /api/notes` - Create a new note
- `PUT /api/notes/{id}` - Update an existing note
- `DELETE /api/notes/{id}` - Delete a note
- `GET /api/notes/search` - Search notes by keyword

## Setup Instructions

1. Clone this repository
2. Create a `.env` file (copy from `.env.example`)
3. Configure your database connection in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```
4. Run composer install:
   ```bash
   composer install
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Seed the database:
   ```bash
   php artisan db:seed
   ```

## Technologies Used

- Laravel 11.x
- MySQL
- Eloquent ORM
- Laravel Factories and Seeders

Homework #1:
![Screenshot 2025-03-20 at 22 03 27](https://github.com/user-attachments/assets/61019e63-75a1-4797-86d4-077536770fc1)

Homework #2:
<img width="1170" alt="image" src="https://github.com/user-attachments/assets/69dd2e5f-93af-446a-b41b-bf5f9cf3f7ef" />
<img width="1025" alt="image" src="https://github.com/user-attachments/assets/cfd7be60-a296-4e93-bc71-bc0e6ec0da80" />



