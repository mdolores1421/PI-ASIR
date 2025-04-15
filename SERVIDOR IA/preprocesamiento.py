import mysql.connector
import pandas as pd

# Conectar a la base de datos
conn = mysql.connector.connect(
    host='192.168.100.10',
    user='usuario_ia',
    password='IA12345',
    database='MADET'
)
cursor = conn.cursor()

def obtener_datos():
    query_consultas = """
    SELECT id, consulta, tiempo_ejecucion, fecha
    FROM log_consultas;
    """
    df_consultas = pd.read_sql(query_consultas, conn)
    
    query_features = """
    SELECT consulta_id, num_tablas, num_condiciones, uso_indices
    FROM log_features;
    """
    df_features = pd.read_sql(query_features, conn)
    
    df = pd.merge(df_consultas, df_features, left_on="id", right_on="consulta_id", how="inner")
    return df

def preprocesar_datos(df):
    df["tiempo_ejecucion"] = df["tiempo_ejecucion"].abs()  # Asegurar valores positivos
    return df

# Ejecutar el preprocesamiento
df = obtener_datos()
df = preprocesar_datos(df)

# Guardar los datos procesados
df.to_csv("datos_procesados.csv", index=False)

print("Preprocesamiento completado y guardado en 'datos_procesados.csv'")
