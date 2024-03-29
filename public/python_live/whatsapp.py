
#version glizer - Stable version V24.03.23.4
#install these libs
#pip install selenium==4.9.0 #
#pip install webdriver-manager #

import requests


headers={"Content-Type":"application/json", "Accept":"application/json"}


r = requests.post(url="https://api.green-api.com/waInstance1101888590/sendMessage/22752bf9fad745fdbff8ec9a3b03f16020ec0ae51b6e4df9a6",json={"chatId":"971508403823@c.us", "message": "Hello from python"}, headers=headers)




print(r)

