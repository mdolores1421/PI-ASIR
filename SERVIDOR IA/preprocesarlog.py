import mysql.connector
import re

# Conexión a la base de datos
conexion = mysql.connector.connect(
    host="192.168.100.10",
    user="usuario_ia",
    password="IA12345",
    database="MADET"
)
cursor = conexion.cursor()

# Obtener consultas sin procesar en log_features
cursor.execute("""
    SELECT id, consulta, tiempo_ejecucion 
    FROM log_consultas 
    WHERE id NOT IN (SELECT consulta_id FROM log_features)
""")
consultas = cursor.fetchall()

# Funciones para extraer características
def contar_joins(consulta):
    return len(re.findall(r"\bJOIN\b", consulta, re.IGNORECASE)) + 1

def contar_condiciones(consulta):
    return len(re.findall(r"\bWHERE\b", consulta, re.IGNORECASE)) + \
           len(re.findall(r"\bAND\b", consulta, re.IGNORECASE)) + \
           len(re.findall(r"\bOR\b", consulta, re.IGNORECASE))

# Procesar y llenar log_features
for consulta_id, texto, tiempo in consultas:
    num_tablas = contar_joins(texto)
    num_condiciones = contar_condiciones(texto)
    
    cursor.execute("""
        INSERT INTO log_features (consulta_id, num_tablas, num_condiciones, tiempo_ejecucion, uso_indices, registros_devueltos) 
        VALUES (%s, %s, %s, %s, FALSE, 0)
    """, (consulta_id, num_tablas, num_condiciones, tiempo))

conexion.commit()
cursor.close()
conexion.close()

print("Procesamiento completado. `log_features` actualizado.")
