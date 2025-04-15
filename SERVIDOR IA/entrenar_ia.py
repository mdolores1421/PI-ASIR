import pandas as pd
import joblib
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split

# Cargar los datos
archivo_csv = "datos_procesados.csv"
df = pd.read_csv(archivo_csv)

# Seleccionar características (X) y variable objetivo (y)
X = df[['num_tablas', 'num_condiciones', 'uso_indices']]
y = df['tiempo_ejecucion']

# Dividir los datos en conjuntos de entrenamiento y prueba
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Entrenar el modelo
modelo = RandomForestRegressor(n_estimators=200, max_depth=10, random_state=42)
modelo.fit(X_train, y_train)

# Guardar el modelo entrenado
joblib.dump(modelo, 'modelo_entrenado.pkl')

print("Modelo entrenado y guardado correctamente.")
