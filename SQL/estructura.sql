-- Datos de ejemplo para bodegas
INSERT INTO bodegas (nombre) VALUES ('Bodega Central'), ('Bodega Norte'), ('Bodega Sur');

-- Datos de ejemplo para sucursales
INSERT INTO sucursales (nombre) VALUES ('Sucursal Santiago'), ('Sucursal Valparaíso'), ('Sucursal Concepción');

-- Datos de ejemplo para monedas
INSERT INTO monedas (nombre) VALUES ('Peso Chileno'), ('Dólar'), ('Euro');
-- Estructura de la base de datos para el registro de productos
-- Script para PostgreSQL
-- Ejecuta esto en psql o PgAdmin

CREATE DATABASE productos_db;
\c productos_db;

CREATE TABLE IF NOT EXISTS bodegas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS sucursales (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS monedas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INTEGER NOT NULL REFERENCES bodegas(id),
    sucursal_id INTEGER NOT NULL REFERENCES sucursales(id),
    moneda_id INTEGER NOT NULL REFERENCES monedas(id),
    precio NUMERIC(10,2) NOT NULL,
    material VARCHAR(100),
    descripcion VARCHAR(1000)
);
