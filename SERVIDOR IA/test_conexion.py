import mysql.connector

# Configuración de la conexión
conn = mysql.connector.connect(
    host="192.168.100.10",
    user="cliente_madet",
    password="Cliente12345",
    database="MADET"
)

cursor = conn.cursor()
cursor.execute("SHOW TABLES")

print("Tablas en la base de datos:")
for table in cursor.fetchall():
    print(table[0])

cursor.close()
conn.close()
