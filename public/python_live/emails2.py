# -*- coding: utf-8 -*-
"""
Created on Thu Mar 28 04:17:27 2024

@author: Yahya
"""


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

chrome_options = Options()


browser = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()),options=chrome_options)
browser.implicitly_wait(5)
browser.get("https://example.valinteca.com/emails-insert")
#  credentials

wait = WebDriverWait(browser, 30)  # waits for 10 seconds max




login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/form/input[2]')))
login_button.send_keys("zyayaolabi@gmail.com")


login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/form/input[3]')))
login_button.send_keys("test")



login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/form/input[4]')))
login_button.click()



time.sleep(5)

browser.quit()
