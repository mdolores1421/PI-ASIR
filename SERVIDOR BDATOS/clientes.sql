USE MADET;

INSERT INTO clientes (nombre, email, telefono, fecha_registro)
SELECT 
    CONCAT('Cliente ', n) AS nombre,
    CONCAT('cliente', n, '@email.com') AS email,
    CONCAT('600', LPAD(n, 6, '0')) AS telefono,
    DATE_ADD('2020-01-01', INTERVAL FLOOR(RAND() * 1460) DAY) AS fecha_registro
FROM (
    SELECT ROW_NUMBER() OVER () AS n
    FROM (
        SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 
        UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
    ) a,
    (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 
        UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) b,
    (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 
        UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) c,
    (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 
        UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) d,
    (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) e
) numbers
WHERE NOT EXISTS (
    SELECT 1 FROM clientes WHERE email = CONCAT('cliente', n, '@email.com')
)
LIMIT 50000;
