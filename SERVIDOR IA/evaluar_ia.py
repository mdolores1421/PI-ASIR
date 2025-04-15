import pandas as pd
import joblib
from sklearn.metrics import mean_absolute_error, mean_squared_error

# Cargar los datos
archivo_csv = "datos_procesados.csv"
df = pd.read_csv(archivo_csv)

# Seleccionar características (X) y variable objetivo (y)
X = df[['num_tablas', 'num_condiciones', 'uso_indices']]
y = df['tiempo_ejecucion']

# Cargar el modelo entrenado
modelo = joblib.load('modelo_entrenado.pkl')

# Evaluar el modelo
predicciones = modelo.predict(X)
mae = mean_absolute_error(y, predicciones)
mse = mean_squared_error(y, predicciones)
rmse = mse ** 0.5

print(f"Error Medio Absoluto (MAE): {mae}")
print(f"Error Cuadrático Medio (MSE): {mse}")
print(f"Raíz del Error Cuadrático Medio (RMSE): {rmse}")
