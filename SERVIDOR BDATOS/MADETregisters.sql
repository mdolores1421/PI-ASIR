USE MADET;

DELIMITER $$

-- Procedimiento para insertar empleados (100 empleados)
DROP PROCEDURE IF EXISTS InsertarEmpleados$$
CREATE PROCEDURE InsertarEmpleados()
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 100 DO
        INSERT INTO empleados (nombre, puesto, salario) 
        VALUES (
            CONCAT('Empleado ', i), 
            ELT(FLOOR(1 + (RAND() * 3)), 'Gerente', 'Vendedor', 'Cajero'), 
            ROUND(1500 + (RAND() * 2000), 2)
        );
        SET i = i + 1;
    END WHILE;
END$$

-- Procedimiento para insertar clientes (2.000 clientes)
DROP PROCEDURE IF EXISTS InsertarClientes$$
CREATE PROCEDURE InsertarClientes()
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 50000 DO
        INSERT INTO clientes (nombre, email, telefono, fecha_registro) 
        VALUES (
            CONCAT('Cliente ', i), 
            CONCAT('cliente', i, '@email.com'), 
            CONCAT('6', FLOOR(10000000 + (RAND() * 89999999))),
            DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 3650) DAY) -- Fecha aleatoria en los últimos 10 años
        );
        SET i = i + 1;
    END WHILE;
END$$

-- Procedimiento para insertar productos (1.000 productos)
DROP PROCEDURE IF EXISTS InsertarProductos$$
CREATE PROCEDURE InsertarProductos()
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 20000 DO
        INSERT INTO productos (nombre, precio, stock) 
        VALUES (
            CONCAT('Producto ', i), 
            ROUND(5 + (RAND() * 995), 2), 
            FLOOR(10 + (RAND() * 490))
        );
        SET i = i + 1;
    END WHILE;
END$$

-- Procedimiento para insertar ventas (3.850 registros aleatorios)
DROP PROCEDURE IF EXISTS InsertarVentas$$
CREATE PROCEDURE InsertarVentas()
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 50000 DO
        INSERT INTO ventas (cliente_id, empleado_id, producto_id, cantidad, total, fecha_venta) 
        VALUES (
            FLOOR(1 + (RAND() * 2000)),  -- Cliente aleatorio
            FLOOR(1 + (RAND() * 100)),   -- Empleado aleatorio
            FLOOR(1 + (RAND() * 1000)),  -- Producto aleatorio
            FLOOR(1 + (RAND() * 5)),     -- Cantidad entre 1 y 5
            ROUND(10 + (RAND() * 990), 2), -- Total entre 10 y 1000€
            DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 1825) DAY) -- Fecha aleatoria en los últimos 5 años
        );
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- Ejecutar los procedimientos
CALL InsertarEmpleados();
CALL InsertarClientes();
CALL InsertarProductos();
CALL InsertarVentas();
