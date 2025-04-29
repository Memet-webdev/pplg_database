-- Membuat database
CREATE DATABASE IF NOT EXISTS user_db;

-- Membuat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Membuat tabel buku
CREATE TABLE buku (
    kode_buku VARCHAR(50) PRIMARY KEY,
    judul_buku VARCHAR(255) NOT NULL,
    nama_pengarang VARCHAR(255) NOT NULL,
    penerbit VARCHAR(255) NOT NULL,
    id_kategori INT NOT NULL,
    no_urut INT NOT NULL
);
