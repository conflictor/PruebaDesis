###VERSIONES
versión php -> 8.2.28
versión bd -> 15.3

### CREAR USUARIO Y BASE DE DATOS EN POSTGRESQL
sudo -u postgres psql
CREATE USER desisuser WITH PASSWORD 'desis2025';
CREATE DATABASE desisdb;
GRANT ALL PRIVILEGES ON DATABASE desisdb TO desisuser;
\q

### LEVANTAR EL SCHEMA Y CREAR LAS TABLAS Y SEEDERS
sudo -u postgres psql -d desisdb -f db/schema.sql


### MONTAR EL SERVIDOR EN LA CARPETA DE LA APLICACIÓN
php -S localhost:8000


