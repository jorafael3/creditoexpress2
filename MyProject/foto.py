import requests

url = "https://reconocimiento-dataconsulting.ngrok.app/"
data = {
    "id": "mCk8yXLwvZ0f+GovEZMqmKcqnpwB37o7gzHNKQWqOb4=",
    "emp": "SALVACERO",
    "img":""
}
headers = {'Content-Type': 'application/json'}

response = requests.post(url, json=data, headers=headers)

print(response.json())
