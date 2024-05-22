from asyncio import sleep
import subprocess
import time
import mysql.connector
from mysql.connector import Error
import json
import base64
# import requests
from datetime import datetime
# from Crypto.PublicKey import RSA
# from Crypto.Cipher import PKCS1_OAEP
import os
import subprocess


# //pip install pycryptodome


def Cargar_Datos():
     
    while True:
        try:
            time.sleep(0.4)
            conexion = mysql.connector.connect(
                host="50.87.184.179",
                user="wsoqajmy_jorge",
                password="Equilivre3*",
                database="wsoqajmy_crediweb"
            )
            # conexion = mysql.connector.connect(
            #     host="localhost",
            #     user="root",
            #     password="",
            #     database="crediweb"
            # )
            if conexion.is_connected():
                # print("Conexión establecida")
                pass

            cursor = conexion.cursor()
            consulta = 'SELECT * FROM creditos_solicitados WHERE estado = 1 and EST_REGISTRO = 1'
            # valores = (numero,)
            cursor.execute(consulta)
            resultados = cursor.fetchall()
            print(len(resultados))
            for row in resultados:
                print(row[2])
                cedula = row[2]
                fecha = row[6]
                celular = row[3]
                ID_UNICO = row[1]
                parametro = [cedula,fecha,celular,ID_UNICO]
                ruta_php = "C:/xampp/php/php.exe"
                ruta = "C:\\xampp\\htdocs\\credito_express_api\\credito.php"
                comando = [ruta_php, ruta] + parametro
                resultado = subprocess.run(comando, capture_output=True, text=True)
                print(resultado.stdout)


            cursor.close()
            conexion.close()

        except Error as e:
            print("Error de conexión:", e)
            print("Intentando reconectar...")
            continue

# def get_secuencial_api_banco():
#     try:
#             conexion = mysql.connector.connect(
#                 host="50.87.184.179",
#                 user="wsoqajmy_jorge",
#                 password="Equilivre3*",
#                 database="wsoqajmy_crediweb"
#             )
#             if conexion.is_connected():
#                 # print("Conexión establecida")
#                 pass

#             cursor = conexion.cursor()
#             consulta = 'SELECT * FROM parametros WHERE id = 1'
#             # valores = (numero,)
#             cursor.execute(consulta)
#             resultados = cursor.fetchall()
#             for row in resultados:
#                 # print(row[2])
#                 return row[2]
#             cursor.close()
#             conexion.close()

#     except Exception as e:
#             return [0, "INTENTE DE NUEVO"]

# def UPDATE_secuencial_api_banco(sec):
#         try:
#             # conexion = mysql.connector.connect(
#             #     host="localhost",
#             #     user="root",
#             #     password="",
#             #     database="crediweb"
#             # )
#             conexion = mysql.connector.connect(
#                 host="50.87.184.179",
#                 user="wsoqajmy_jorge",
#                 password="Equilivre3*",
#                 database="wsoqajmy_crediweb"
#             )

#             cursor = conexion.cursor()
#             consulta = """
#                 UPDATE parametros
#                     set valor = %s
#                 WHERE id = 1
#             """
#             valores = (
#                  sec,
#             )
#             cursor.execute(consulta,valores)
#             conexion.commit()

#         except Error as e:
#             print("Error de conexión:", e)
         
# def encrypt_cedula(cedula):
#   # Obtener la ruta completa del archivo de clave pública (PBKey.txt)
#     public_key_file = os.path.join(os.path.dirname(__file__), 'PBKey.txt')

#     try:
#         # Leer la clave pública desde el archivo
#         with open(public_key_file, 'rb') as f:
#             key = RSA.import_key(f.read())

#         # Crear un objeto Cipher con la clave pública
#         cipher = PKCS1_OAEP.new(key)

#         # Encriptar la cédula
#         encrypted_data = cipher.encrypt(cedula.encode('utf-8'))

#         # Devolver la cédula encriptada en formato base64
#         return base64.b64encode(encrypted_data).decode('utf-8')
#     except Exception as e:
#         # Manejar el error de encriptación
#         return (0, str(e), public_key_file)

# def obtener_datos_credito():
#     try:
#         # if val == 1:
#         #     cedula = param["CEDULA"]
#         #     nacimiento = param["FECHA_NACIM"]
#         #     celular = base64.b64decode(param_datos["celular"])
#         # else:
#         #     cedula = param["CEDULA"]
#         #     nacimiento = param["FECHA_NACIM"]
#         #     celular = param_datos["celular"]
#         cedula = "0951991637"
#         nacimiento = "19960114"
#         celular = "0969786231"
#         # fecha = datetime.strptime(nacimiento, '%d/%m/%Y')
#         # fecha_formateada = fecha.strftime('%Y%m%d')
#         ingresos = "1500"
#         instruccion = "SECU"
#         sec = get_secuencial_api_banco()
#         sec = int(sec) + 1
#         UPDATE_secuencial_api_banco(sec)

#         data = {
#             "transaccion": 4001,
#             "idSession": "1",
#             "secuencial": sec,
#             "mensaje": {
#                 "IdCasaComercialProducto": 8,
#                 "TipoIdentificacion": "CED",
#                 "IdentificacionCliente": encrypt_cedula(cedula),
#                 "FechaNacimiento": nacimiento,
#                 "ValorIngreso": ingresos,
#                 "Instruccion": instruccion,
#                 "Celular": celular
#             }
#         }

#         url = 'https://bs-autentica.com/cco/apiofertaccoqa1/api/CasasComerciales/GenerarCalificacionEnPuntaCasasComerciales'
#         api_key = '0G4uZTt8yVlhd33qfCn5sazR5rDgolqH64kUYiVM5rcuQbOFhQEADhMRHqumswphGtHt1yhptsg0zyxWibbYmjJOOTstDwBfPjkeuh6RITv32fnY8UxhU9j5tiXFrgVz'

#         headers = {
#             'Content-Type': 'application/json',
#             'ApiKeySuscripcion': api_key
#         }

#         response = requests.put(url, json=data, headers=headers, verify=False)
#         response_json = response.json()

#         print(response_json)
#         # update_secuencial_api_banco(sec)

#         # if 'esError' in response_json:
#         #     if response_json['esError']:
#         #         return (0, response_json, data)
#         #     elif response_json['descripcion'] == "No tiene oferta":
#         #         return (2, response_json, data)
#         #     elif response_json['descripcion'] == "Ha ocurrido un error" and datetime.now().hour >= 21:
#         #         return (3, response_json, data, datetime.now().hour)
#         #     else:
#         #         return (1, response_json, data)
#         # else:
#         #     return (0, response_json, data, response.content, response.text, 'curl' in dir())

#     except Exception as e:
#         param = {
#             "ERROR_TYPE": "API_SOL_FUNCTION",
#             "ERROR_CODE": "",
#             "ERROR_TEXT": str(e),
#         }
#         # incidencias(param)
#         return (0, "Error al procesar la solicitud del banco", str(e))


if __name__ == "__main__":
    Cargar_Datos()