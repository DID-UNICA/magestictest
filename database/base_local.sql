--@Autor(es): Mauricio Ramos
--@Fecha creación: 19/02/2020
--@Descripción: Script de creación de base local para pruebas
--del proyecto.
--Se ejecuta con \i
create user magesticd with encrypted password 'magesticd';
create database magesticd with owner magesticd encoding UTF8;
grant all privileges on database magesticd to magesticd;

--Es necesario en fedora instalar:
--sudo dnf install postgresql-contrib
--Además el archivo unaccent.control y unaccent--1.0 y 1.1
--Deben estar en la ruta de creación de diccionarios, ej:
--/usr/pgsql-11/share/extension
--Y la variable $libdir apuntar a donde se encuentra el archivo
--unaccent.so 
create extension unaccent;

