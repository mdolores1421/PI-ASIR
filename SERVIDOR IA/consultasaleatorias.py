import mysql.connector
import random
import time

# Conexión a la base de datos
conn = mysql.connector.connect(
    host="192.168.100.10",
    user="usuario_ia",
    password="IA12345",
    database="MADET"
)
cursor = conn.cursor()

# Tablas de ejemplo (ajústalas según tu BD)
tablas = ["clientes", "pedidos", "productos", "empleados"]
columnas = {
    "clientes": ["id", "nombre", "correo"],
    "pedidos": ["id", "fecha", "total"],
    "productos": ["id", "nombre", "precio"],
    "empleados": ["id", "nombre", "cargo"]
}

# Generador de consultas SQL aleatorias
def generar_consulta():
    tabla = random.choice(tablas)
    col = random.choice(columnas[tabla])
    tipo_consulta = random.choice(["SELECT", "COUNT", "AVG"])
    
    if tipo_consulta == "SELECT":
        sql = f"SELECT {col} FROM {tabla} LIMIT {random.randint(1, 10)}"
    elif tipo_consulta == "COUNT":
        sql = f"SELECT COUNT({col}) FROM {tabla}"
    else:  # AVG
        if col in ["total", "precio"]:
            sql = f"SELECT AVG({col}) FROM {tabla}"
        else:
            sql = f"SELECT COUNT({col}) FROM {tabla}"
    
    return sql

# Insertar en log_consultas
def insertar_log(consulta):
    tiempo_ejecucion = round(random.uniform(0.01, 1.5), 4)  # Simulación de tiempo de ejecución
    cursor.execute("INSERT INTO log_consultas (consulta, tiempo_ejecucion, fecha) VALUES (%s, %s, NOW())", (consulta, tiempo_ejecucion))
    conn.commit()

# Ejecutar generación de consultas
num_consultas = 5000  # Ajusta según necesidad
for _ in range(num_consultas):
    sql = generar_consulta()
    insertar_log(sql)
    time.sleep(random.uniform(0.1, 0.5))  # Simular consultas reales

print(f"{num_consultas} consultas generadas y registradas en log_consultas.")

cursor.close()
conn.close()
