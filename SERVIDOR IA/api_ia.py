from flask import Flask, request, jsonify
import joblib
import numpy as np
import pandas as pd

app = Flask(__name__)

# Cargar el modelo entrenado
modelo = joblib.load('modelo_entrenado.pkl')

@app.route('/predecir', methods=['POST'])
def predecir():
    try:
        datos = request.get_json()
        
        # Crear un DataFrame con los datos de entrada
        df = pd.DataFrame([datos])
        
        # Asegurar que las columnas sean las mismas usadas en el entrenamiento
        columnas_esperadas = ['id', 'consulta', 'tiempo_ejecucion', 'fecha', 'consulta_id', 'num_tablas', 'num_condiciones', 'uso_indices']
        df = df.reindex(columns=columnas_esperadas, fill_value=0)
        
        # Eliminar columnas irrelevantes para la predicción
        df = df[['num_tablas', 'num_condiciones', 'uso_indices']]
        
        # Hacer la predicción
        tiempo_estimado = modelo.predict(df)[0]
        
        # Asegurar que el tiempo estimado no sea negativo
       # tiempo_estimado = max(0, tiempo_estimado)
        
        return jsonify({'tiempo_estimado': tiempo_estimado})
    except Exception as e:
        return jsonify({'error': str(e)})

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000, debug=True)
