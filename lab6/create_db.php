<?php

$dbFile = __DIR__ . '/data/db.sqlite';
if (!is_dir(__DIR__ . '/data')) mkdir(__DIR__ . '/data', 0777, true);
if (file_exists($dbFile)) unlink($dbFile);
try {
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('PRAGMA foreign_keys = ON;');

    // Tabla de autores
    $db->exec("
        CREATE TABLE authors (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            bio TEXT
        );
    ");

    // Tabla de editoriales
    $db->exec("
        CREATE TABLE publishers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            address TEXT
        );
    ");

    // Tabla de libros
    $db->exec("
        CREATE TABLE books (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            isbn TEXT NOT NULL UNIQUE,
            title TEXT NOT NULL,
            publisher_id INTEGER,
            publication_year INTEGER,
            pages INTEGER,
            FOREIGN KEY(publisher_id) REFERENCES publishers(id) ON DELETE SET NULL
        );
    ");

    // Tabla autores_libro
    $db->exec("
        CREATE TABLE authors_books (
            book_id INTEGER NOT NULL,
            author_id INTEGER NOT NULL,
            PRIMARY KEY(book_id, author_id),
            FOREIGN KEY(book_id) REFERENCES books(id) ON DELETE CASCADE,
            FOREIGN KEY(author_id) REFERENCES authors(id) ON DELETE CASCADE
        );
    ");

    // Tabla de miembros
    $db->exec("
        CREATE TABLE members (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE,
            member_year INTEGER
        );
    ");

    // Tabla de préstamos
    $db->exec("
        CREATE TABLE loans (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            member_id INTEGER NOT NULL,
            book_id INTEGER NOT NULL,
            loaned_at TEXT DEFAULT CURRENT_TIMESTAMP,
            returned_at TEXT,
            FOREIGN KEY(member_id) REFERENCES members(id) ON DELETE CASCADE,
            FOREIGN KEY(book_id) REFERENCES books(id) ON DELETE CASCADE
        );
    ");

    // Datos
    $db->exec("
        INSERT INTO authors(name, bio) VALUES
            ('Gabriel García Márquez', 'Autor colombiano, Nobel de Literatura'),
            ('J.K. Rowling', 'Autora británica de Harry Potter'),
            ('Julio Cortázar', 'Escritor argentino, maestro del cuento');

        INSERT INTO publishers(name, address) VALUES
            ('Editorial Sudamericana', 'Buenos Aires, Argentina'),
            ('Bloomsbury', 'Londres, Reino Unido');

        INSERT INTO books(isbn, title, publisher_id, publication_year, pages) VALUES
            ('978-950-07-0896-4', 'Cien años de soledad', 1, 1967, 471),
            ('978-0-7475-3269-9', 'Harry Potter y la piedra filosofal', 2, 1997, 223),
            ('978-950-03-9114-5', 'Rayuela', 1, 1963, 600);

        INSERT INTO authors_books(book_id, author_id) VALUES
            (1, 1),
            (2, 2),
            (3, 3);

        INSERT INTO members(name, email, member_year) VALUES
            ('Juan Pérez', 'juan.perez@example.com', 2020),
            ('Ana Torres', 'ana.torres@example.com', 2021);

        INSERT INTO loans(member_id, book_id, loaned_at, returned_at) VALUES
            (1, 1, '2025-10-01', NULL),
            (2, 2, '2025-09-20', '2025-09-27');
    ");

    echo "Base de datos de biblioteca creada en: $dbFile\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}