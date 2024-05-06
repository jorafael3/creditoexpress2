from asyncio import sleep
import subprocess
import time
import mysql.connector
from mysql.connector import Error
import json
import base64
import requests
from datetime import datetime

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
            consulta = 'SELECT ID_UNICO FROM creditos_solicitados WHERE estado = 1 and EST_REGISTRO = 1'
            # valores = (numero,)
            cursor.execute(consulta)
            resultados = cursor.fetchall()
            print(len(resultados))
            for row in resultados:
                print(row[0])
            cursor.close()
            conexion.close()

        except Error as e:
            print("Error de conexión:", e)
            print("Intentando reconectar...")
            continue  # Continuar con el siguiente intento de conexión



def encrypt_cedula(cedula):
    # Contenido de la clave pública
    public_key_file = "/path/to/PBKey.txt"  # Ruta a tu archivo de clave pública
    # Lee el contenido del archivo PEM
    with open(public_key_file, 'r') as f:
        public_key_content = f.read().strip()

    rsa_key = None
    try:
        rsa_key = open(public_key_content, "r")
        encrypted_data = rsa_key.public_encrypt(cedula.encode('utf-8'), RSA.pkcs1_oaep_padding)
        return base64.b64encode(encrypted_data)
    except Exception as e:
        # Manejar el error de encriptación
        return (0, str(e), public_key_file)
    finally:
        if rsa_key:
            rsa_key.close()

def obtener_datos_credito(param, param_datos, val):
    try:
        if val == 1:
            cedula = param["CEDULA"]
            nacimiento = param["FECHA_NACIM"]
            celular = base64.b64decode(param_datos["celular"])
        else:
            cedula = param["CEDULA"]
            nacimiento = param["FECHA_NACIM"]
            celular = param_datos["celular"]

        fecha = datetime.strptime(nacimiento, '%d/%m/%Y')
        fecha_formateada = fecha.strftime('%Y%m%d')
        ingresos = "500"
        instruccion = "SECU"

        # sec = get_secuencial_api_banco()
        sec = int(sec[0]["valor"]) + 1

        data = {
            "transaccion": 4001,
            "idSession": "1",
            "secuencial": sec,
            "mensaje": {
                "IdCasaComercialProducto": 8,
                "TipoIdentificacion": "CED",
                "IdentificacionCliente": encrypt_cedula(cedula),
                "FechaNacimiento": fecha_formateada,
                "ValorIngreso": ingresos,
                "Instruccion": instruccion,
                "Celular": celular
            }
        }

        url = 'https://bs-autentica.com/cco/apiofertaccoqa1/api/CasasComerciales/GenerarCalificacionEnPuntaCasasComerciales'
        api_key = '0G4uZTt8yVlhd33qfCn5sazR5rDgolqH64kUYiVM5rcuQbOFhQEADhMRHqumswphGtHt1yhptsg0zyxWibbYmjJOOTstDwBfPjkeuh6RITv32fnY8UxhU9j5tiXFrgVz'

        headers = {
            'Content-Type': 'application/json',
            'ApiKeySuscripcion': api_key
        }

        response = requests.put(url, json=data, headers=headers)
        response_json = response.json()

        # update_secuencial_api_banco(sec)

        if 'esError' in response_json:
            if response_json['esError']:
                return (0, response_json, data)
            elif response_json['descripcion'] == "No tiene oferta":
                return (2, response_json, data)
            elif response_json['descripcion'] == "Ha ocurrido un error" and datetime.now().hour >= 21:
                return (3, response_json, data, datetime.now().hour)
            else:
                return (1, response_json, data)
        else:
            return (0, response_json, data, response.content, response.text, 'curl' in dir())

    except Exception as e:
        param = {
            "ERROR_TYPE": "API_SOL_FUNCTION",
            "ERROR_CODE": "",
            "ERROR_TEXT": str(e),
        }
        # incidencias(param)
        return (0, "Error al procesar la solicitud del banco", str(e))



if __name__ == "__main__":
    Cargar_Datos()