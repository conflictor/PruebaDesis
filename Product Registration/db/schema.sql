-- Eliminamos las tablas si ya existen (por si se vuelve a correr)
DROP TABLE IF EXISTS product_materials;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS branches;
DROP TABLE IF EXISTS warehouses;
DROP TABLE IF EXISTS currencies;

-- Tabla: bodegas (warehouses)
CREATE TABLE warehouses (
                            id SERIAL PRIMARY KEY,
                            name VARCHAR(50) NOT NULL
);

-- Tabla: sucursales (branches)
CREATE TABLE branches (
                          id SERIAL PRIMARY KEY,
                          name VARCHAR(50) NOT NULL,
                          warehouse_id INTEGER REFERENCES warehouses(id) ON DELETE CASCADE
);

-- Tabla: monedas (currencies)
CREATE TABLE currencies (
                            id SERIAL PRIMARY KEY,
                            name VARCHAR(50) NOT NULL
);

-- Tabla: productos
CREATE TABLE products (
                          id SERIAL PRIMARY KEY,
                          product_code VARCHAR(15) UNIQUE NOT NULL,
                          product_name VARCHAR(50) NOT NULL,
                          warehouse_id INTEGER REFERENCES warehouses(id),
                          branch_id INTEGER REFERENCES branches(id),
                          currency_id INTEGER REFERENCES currencies(id),
                          price DECIMAL(10, 2) NOT NULL,
                          description TEXT NOT NULL
);

-- Tabla: materiales por producto
CREATE TABLE product_materials (
                                   id SERIAL PRIMARY KEY,
                                   product_id INTEGER REFERENCES products(id) ON DELETE CASCADE,
                                   material_name VARCHAR(50) NOT NULL
);

-- SEEDERS

-- Bodegas
INSERT INTO warehouses (name) VALUES
                                  ('Bodega Central'),
                                  ('Bodega Norte'),
                                  ('Bodega Sur');

-- Sucursales (relacionadas a bodegas por id)
INSERT INTO branches (name, warehouse_id) VALUES
                                              ('Sucursal Principal', 1),
                                              ('Sucursal Secuandaria', 1),
                                              ('Sucursal A', 2),
                                              ('Sucursal B', 2),
                                              ('Sucursal C', 3);

-- Monedas
INSERT INTO currencies (name) VALUES
                                  ('CLP'),
                                  ('USD'),
                                  ('EUR');

-- Asignar permisos al usuario que usará la app
GRANT USAGE ON SCHEMA public TO desisuser;
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO desisuser;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE products_id_seq TO desisuser;
ALTER DATABASE desisdb OWNER TO desisuser;
GRANT ALL PRIVILEGES ON DATABASE desisdb TO desisuser;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO desisuser;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO desisuser;
GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public TO desisuser;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO desisuser;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO desisuser;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON FUNCTIONS TO desisuser;



-- Permisos por defecto para futuras tablas
--ALTER DEFAULT PRIVILEGES IN SCHEMA public
--GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO desisuser;
