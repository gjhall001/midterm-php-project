# Midterm Project (Backend Web Development)- PHP OOP REST API

This project is a RESTful API built with PHP using object-oriented programming principles. It allows users to retrieve and manage a collection of quotations, including both famous quotes and user-submitted entries.

Each quote is associated with an author and a category, and all data is stored in a PostgreSQL database.

## Features

- RESTful API design
- Built with PHP (OOP)
- JSON-based responses for all endpoints
- Manage:
  - Quotes
  - Authors
  - Categories
- Relational database (PostgreSQL) with foreign keys
- Error handling for missing or invalid parameters

## Database Structure

The project uses a PostgreSQL database named quotesdb with three tables:

### quotes

- id (Primary Key, Auto Increment)
- quote
- author_id (Foreign Key)
- category_id (Foreign Key)

### authors

- id (Primary Key)
- author

### categories

- id (Primary Key, Auto Increment)
- category

All fields are required (non-null).

## API Endpoints

Base URL:
https://midterm-php-project.onrender.com/api

---

### Authors

- GET `/authors` → Get all authors
- GET `/authors?id=1` → Get single author
- POST `/authors` → Create new author
- PUT `/authors` → Update author
- DELETE `/authors?id=1` → Delete author

### Categories

- GET `/categories` → Get all categories
- GET `/categories?id=1` → Get single category
- POST `/categories` → Create category
- PUT `/categories` → Update category
- DELETE `/categories?id=1` → Delete category

---

### Quotes

- GET `/quotes` → Get all quotes
- GET `/quotes?id=1` → Get single quote
- POST `/quotes` → Create quote
- PUT `/quotes` → Update quote
- DELETE `/quotes?id=1` → Delete quote

## Error Handling

The API provides clear JSON error messages for:

- Missing parameters
- Invalid requests
- Resource not found

## Technologies Used

- PHP (Object-Oriented Programming)
- PostgreSQL (Relational Database)
- REST API architecture
- JSON
