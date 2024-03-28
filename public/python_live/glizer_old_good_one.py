

#install these libs
#pip install selenium==4.9.0 #
#pip install webdriver-manager #

from webdriver_manager.chrome import ChromeDriverManager
from selenium import webdriver
from selenium.webdriver.chrome.service import Service as ChromeService
from selenium.webdriver.common.by import By
import re
from selenium.webdriver.common.keys import Keys


from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
import time


import os
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import requests
#install extentions


executable_path = os.getcwd() + "\\AdBlock.crx"
#os.environ["webdriver.chrome.driver"] = executable_path
chrome_options = Options()
#chrome_options.add_extension('AdBlock.crx')
# chrome_options.add_extension('xPath-Finder.crx')

#browser = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()))

time.sleep(5)
headers={"Content-Type":"application/json", "Accept":"application/json","X-Authorization": "HnweAEO5T7SArZCiy5SjzOx9cZ96qGEejaiIkvyZLZW1PrBZX64ofs5lO6s6UCmK","X-Device":"osama-old-code"}

r = requests.get(url="https://sahwa.valantica.com/api/v1/bot", headers=headers)

if(r.json()['success'] == False):
    print(r.json())
    exit()


print(r.json())
user_name = r.json()['email']
password = r.json()['password']

code = r.json()['code']
PlayerId = r.json()['player_id']






#chrome_options=chrome_options  for extentions
browser = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()),chrome_options=chrome_options)



webpage = "https://www.midasbuy.com/midasbuy/my/redeem/pubgm"
browser.get(webpage)

import pandas as pd
#df_sheet_index = pd.read_excel('glizer.xlsx')

browser.implicitly_wait(5)


time.sleep(10)

#note: stop here and close popups and make manual login with (Keep me signed in)

#find X path using this extention https://chromewebstore.google.com/detail/xpath-finder/ihnknokegkbpmofmafnkoadfjkhlogph?hl=tr&utm_source=ext_sidebar

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
wait = WebDriverWait(browser, 20)  # waits for 10 seconds max

browser.refresh()
#cookie_accept_button
cookie_accept_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[7]/div[3]/div[1]/div/div')))
cookie_accept_button.click()


browser.implicitly_wait(10)

##login
time.sleep(10)
login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div/div/div[2]/div/div')))
login_button.click()
time.sleep(10)
browser.switch_to.frame("login-iframe")

#  credentials


time.sleep(5)

login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[1]/div[1]/div/div[3]/div/div[2]/div/div/div/div[1]/p/input')))
login_button.send_keys(user_name)

login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[1]/div[1]/div/div[3]/div/div[3]/div')))
login_button.click()

login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[1]/div[1]/div/div[3]/div[1]/div[2]/div[2]/div/input')))
login_button.send_keys(password)

login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[1]/div[1]/div/div[3]/div[2]')))
login_button.click()

browser.implicitly_wait(10)


time.sleep(5)

#webpage = "https://www.midasbuy.com/midasbuy/my/redeem/pubgm"
#browser.get(webpage)

#Change_Player_ID

Change_Player_ID = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[2]/div[2]/div/div[2]/div[2]/div/div[1]/span/i')))
Change_Player_ID.click()

Change_Player_ID_input= wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div[1]/div/div[2]/div/div/div[1]/input')))
Change_Player_ID_input.clear()
Change_Player_ID_input.send_keys(PlayerId)

Change_Player_ID_ok= wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div[1]/div/div[3]/div/div/div/div')))
Change_Player_ID_ok.click()


#Redemption_code
Redemption_code = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div/div/div[2]/div[1]/div/div/div[1]/input')))
Redemption_code.clear()
Redemption_code.send_keys(code)


Redemption_code_ok = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div/div/div[2]/div[2]/div/div')))
Redemption_code_ok.click()

from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
#enter Code



time.sleep(20)
Redemption_code_submit = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[4]/div[2]/div[2]/div[4]/div/div/div/div')))
Redemption_code_submit.click()

#not always showing div5
time.sleep(10)
# Redemption_code_verify = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[4]/div[2]/div[2]/div[5]/div/div/div/div')))
# Redemption_code_verify.click()
#error
#Redemption_code_error = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[4]/div[2]/div[2]/div[1]/div')))
#Redemption_code_error.text



try:

    Redeem_successfuly_ok = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[3]/div[3]/div/div[3]/div/div/div/div/div')))
    Redeem_successfuly_ok.click()
    # success

    requests.post(url="https://sahwa.valantica.com/api/v1/redeem",json={"code":code, "email": user_name, "status": "redeemed"}, headers=headers)
    print("Success old")
except TimeoutException:
    requests.post(url="https://sahwa.valantica.com/api/v1/block",json={"email":user_name}, headers=headers)

    print("exception handled")
    # error



browser.quit()

