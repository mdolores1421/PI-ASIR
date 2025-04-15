# TFG - Gestión Inteligente de Bases de Datos con IA (MADET)

Este proyecto es un Trabajo de Fin de Grado que tiene como objetivo mejorar el rendimiento de las consultas SQL utilizando inteligencia artificial. El sistema propone y crea índices automáticamente en función del historial de consultas y sus tiempos de ejecución.

## 🧠 Tecnologías utilizadas

- PHP, HTML, CSS (interfaz web)
- MySQL (gestión de base de datos)
- Python (modelo IA con scikit-learn / TensorFlow)
- Bash (automatizaciones)
- Git (control de versiones)

## 📁 Estructura del proyecto

- `servidor_bdatos/`: Contiene el esquema y datos de la base de datos `MADET`
- `servidor_ia/`: Contiene el script Python que analiza y sugiere índices
- `servidor_web/`: Contiene la interfaz en PHP para ejecutar consultas y ver sugerencias

## 🚀 Cómo ejecutar

1. Iniciar los tres servicios en sus respectivas máquinas/VMs.
2. Entrar en `servidor_web/` y acceder a `index.php` para loguearse.
3. Inicia la IA con `python servidor_ia/app.py` en la terminal.
4. Realizar consultas simples o complejas desde la interfaz.

## 📌 Requisitos

- PHP 7+
- MariaDB/MySQL
- Python 3.8+
- scikit-learn / TensorFlow

---

Creado por Mª Dolores Espinosa como proyecto final para ASIR.
