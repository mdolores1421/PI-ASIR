DELIMITER $$

CREATE PROCEDURE InsertPedidos(IN total INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < total DO
        INSERT INTO pedidos (cliente_id, producto_id, cantidad, fecha_pedido, total)
        VALUES (
            FLOOR(RAND() * 1000000) + 1, -- Cliente aleatorio
            FLOOR(RAND() * 50000) + 1,   -- Producto aleatorio
            FLOOR(RAND() * 5) + 1,       -- Cantidad entre 1 y 5
            DATE_ADD('2015-01-01', INTERVAL RAND() * 3000 DAY),
            ROUND(RAND() * 500, 2) * (FLOOR(RAND() * 5) + 1) -- Total basado en precio
        );
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

CALL InsertPedidos(5000000);
