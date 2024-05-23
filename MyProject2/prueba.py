from asyncio import sleep
import subprocess
import time
import mysql.connector
from mysql.connector import Error

TIPO_CON = 0

# def Cargar_Datos():
#     cursor = conexion.cursor()
#     consulta = 'SELECT cedula FROM creditos_solicitados WHERE estado_encr = 1'
#     # valores = (numero,)
#     cursor.execute(consulta)
#     resultados = cursor.fetchall()
#     lista = []
#     lista.append(resultados[0])
#     print(lista)

def run_csharp_file_with_parameter(parameter):
    # Ruta al archivo ejecutable de .NET Core
    dotnet_executable = "C:\\Program Files\\dotnet\\dotnet.exe"
    # dotnet_executable = "dotnet"
    # Ruta al archivo C# que deseas ejecutar
    csharp_file = "C:\\xampp\\htdocs\\creditoexpress2\\MyProject2\\bin\\Debug\\net8.0\\MyProject2.dll"
    # csharp_file = "\\var\\www\\html\\creditoexpress2\\MyProject\\bin\\Debug\\net6.0\\MyProject.dll"
    # Construye el comando para ejecutar el archivo C# con el parámetro
    command = [dotnet_executable, csharp_file, parameter]
    # Ejecuta el comando
    try:
        output = subprocess.check_output(command)
        print("Output:", output.decode('utf-8'))  # Imprime la salida del proceso
        return output.decode('utf-8')
    except subprocess.CalledProcessError as e:
        print("Error:", e)  # Captura cualquier error que ocurra durante la ejecución

# Llama a la función y pasa el parámetro que deseas
# run_csharp_file_with_parameter("0931531115")
        
def Guardar_encrypt(cedula_encr,cedula):
        try:
            conexion = mysql.connector.connect(
                host="localhost",
                user="root",
                password="",
                database="crediweb"
            )
            # conexion = mysql.connector.connect(
            #     host="50.87.184.179",
            #     user="wsoqajmy_jorge",
            #     password="Equilivre3*",
            #     database="wsoqajmy_crediweb"
            # )

            cursor = conexion.cursor()
            consulta = """
                UPDATE creditos_solicitados
                    set cedula_encr2 = %s,
                        estado_encr2 = 0
                WHERE cedula = %s
            """
            valores = (
                 cedula_encr,cedula,
            )
            cursor.execute(consulta,valores)
            conexion.commit()

        except Error as e:
            print("Error de conexión:", e)
            

def Cargar_Datos():
    while True:
        
        try:
            time.sleep(0.5)
            conexion = mysql.connector.connect(
                host="localhost",
                user="root",
                password="",
                database="crediweb"
            )
            # conexion = mysql.connector.connect(
            #     host="50.87.184.179",
            #     user="wsoqajmy_jorge",
            #     password="Equilivre3*",
            #     database="wsoqajmy_crediweb"
            # )

            
            if conexion.is_connected():
                # print("Conexión establecida")
                pass

            cursor = conexion.cursor()
            consulta = 'SELECT cedula FROM creditos_solicitados WHERE estado_encr2 = 1'
            # valores = (numero,)
            cursor.execute(consulta)
            resultados = cursor.fetchall()
            print(len(resultados))
            for row in resultados:
                print(row[0])
                cedula_encr = run_csharp_file_with_parameter(row[0])
                Guardar_encrypt(cedula_encr,row[0])
                print(cedula_encr)
            # Cerrar cursor y conexión
            cursor.close()
            conexion.close()

        except Error as e:
            print("Error de conexión:", e)
            print("Intentando reconectar...")
            continue  # Continuar con el siguiente intento de conexión


if __name__ == "__main__":
    Cargar_Datos()