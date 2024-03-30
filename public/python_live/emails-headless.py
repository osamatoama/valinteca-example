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

import undetected_chromedriver as uc
import os
from selenium import webdriver
from selenium.webdriver.chrome.options import Options


chrome_options = uc.ChromeOptions()
#chrome_options.add_extension('AdBlock.crx')
#chrome_options.add_extension('xPath-Finder.crx')
chrome_options.add_argument("headless")
chrome_options.add_argument("--blink-settings=imagesEnabled=false")
chrome_options.add_argument("--log-level=3")
chrome_options.add_argument("--ignore-certificate-errors")
chrome_options.add_argument("--ignore-ssl-errors")
chrome_options.add_argument("no-sandbox")

chrome_options.add_argument("--headless")
chrome_options.add_argument("--no-sandbox")
chrome_options.add_argument("--disable-gpu")

#chrome_options.add_argument(r"--user-data-dir=C:\Users\Yahya\AppData\Local\Google\Chrome\User Data\Default")
#chrome_options.add_argument('--profile-directory=Default')
#chrome_options.add_argument(r"--user-data-dir=C:\Users\yahya\AppData\Local\Google\Chrome\User Data\Default")
#chrome_options.add_argument('--profile-directory=Profile 1')
chrome_options.add_experimental_option("excludeSwitches", ["disable-popup-blocking"])
#chrome_options.add_argument('proxy-server=106.122.8.54:3128')
#chrome_options.add_argument(r'--user-data-dir=C:\Users\yahya\AppData\Local\Google\Chrome\User Data\Default')



#browser = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()))

#chrome_options=chrome_options  for extentions
browser = uc.Chrome(service = ChromeService(ChromeDriverManager().install()),chrome_options=chrome_options)

browser.implicitly_wait(5)
browser.get("https://example.valinteca.com/emails-insert")
#  credentials

wait = WebDriverWait(browser, 30)  # waits for 10 seconds max




login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/form/input[2]')))
login_button.send_keys("kareem@gmail.com")


login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/form/input[3]')))
login_button.send_keys("test")



login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/form/input[4]')))
login_button.click()


print("OK DONE")
