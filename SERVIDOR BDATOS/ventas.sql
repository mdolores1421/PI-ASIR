USE MADET;

DELIMITER $$

CREATE PROCEDURE InsertarVentas13()
BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < 5 DO
        INSERT INTO ventas (cliente_id, empleado_id, producto_id, cantidad, total)
        SELECT 
            (SELECT id FROM clientes ORDER BY RAND() LIMIT 1), 
            (SELECT id FROM empleados ORDER BY RAND() LIMIT 1),
            (SELECT id FROM productos ORDER BY RAND() LIMIT 1),
            FLOOR(1 + RAND() * 10),
            ROUND(10 + RAND() * 500, 2)
        FROM (SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual) AS tmp1,
             (SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual) AS tmp2,
             (SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual UNION ALL 
              SELECT NULL FROM dual UNION ALL SELECT NULL FROM dual) AS tmp3;
        SET i = i + 1;
    END WHILE;
END $$

DELIMITER ;

CALL InsertarVentas13();
