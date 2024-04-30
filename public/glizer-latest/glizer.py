
'''
version 3.0.2
remove Ads
'''

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
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
import time
import os
from selenium.webdriver.chrome.options import Options
import requests

try:

    chrome_options = Options()



    headers={"Content-Type":"application/json", "Accept":"application/json","X-Authorization": "HnweAEO5T7SArZCiy5SjzOx9cZ96qGEejaiIkvyZLZW1PrBZX64ofs5lO6s6UCmK","X-Device":"osama-new-code-1"}
    r = requests.get(url="https://sahwa.valantica.com/api/v1/bot", headers=headers)
    print(r.json())
    if(r.json()['success'] == False):
        exit()
    user_name = r.json()['email']
    password = r.json()['password']

    code = r.json()['code']
    code_id = r.json()['code_id']
    PlayerId =  r.json()['player_id']


    browser = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()),options=chrome_options)



    webpage = "https://www.midasbuy.com/midasbuy/my/redeem/pubgm"
    browser.get(webpage)

    js_code = "setInterval(function () {var s1 = document.querySelector('.activity-iframe-wrapper'), s2 = document.querySelector('.PatFacePopWrapper_visa-card-pat-face-pop__PTPdF'); if(s1) {s1.style.display = 'none'}  if(s2) { s2.style.display = 'none' }; }, 300) "
    browser.execute_script(js_code)

    wait = WebDriverWait(browser, 20)
    cookie_accept_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[9]/div[3]/div[1]/div/div/div/div')))
    cookie_accept_button.click()


    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[2]/div/div/div[2]/div/div/div/div')))
    login_button.click()
    time.sleep(1)
    browser.switch_to.frame("login-iframe")


    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div/div[1]/div/div[3]/div/div[2]/div/div/div/div[1]/p/input ')))
    login_button.send_keys(user_name)

    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div/div[1]/div/div[3]/div/div[3]/div')))
    login_button.click()

    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div/div[1]/div/div[3]/div[1]/div[2]/div[2]/div/input')))
    login_button.send_keys(password)

    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div/div[1]/div/div[3]/div[2]/div')))
    login_button.click()


    browser.implicitly_wait(10)

    time.sleep(3)
    RemoveAd = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[10]/div/div[2]')))
    RemoveAd.click()
    time.sleep(3)

    Change_Player_ID = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[2]/div[2]/div/div[2]/div[2]/div/div[1]/span/i')))
    Change_Player_ID.click()

    Change_Player_ID_input= wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div[1]/div/div[2]/div/div/div[1]/input')))
    time.sleep(1)
    Change_Player_ID_input.clear()
    Change_Player_ID_input.send_keys(PlayerId)
    Change_Player_ID_ok= wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div[1]/div/div[3]/div/div/div/div')))
    Change_Player_ID_ok.click()


    try:
        Redemption_code = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[2]/div/div/div[2]/div[1]/div/div/div[1]/input')))
        Redemption_code.clear()
        Redemption_code.send_keys(code)


        Redemption_code_ok = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[2]/div/div/div[2]/div[2]/div/div')))
        Redemption_code_ok.click()

    except:
        if ('Invalid Game ID' in wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[5]/div[2]/div[1]/div/div[2]/div[2]/p'))).text) :
            requests.post(url="https://sahwa.valantica.com/api/v1/convert-to-manual",json={"code":code,"code_id": code_id, "note": "ID is wrong"}, headers=headers)
            print("id is wrong")
            time.sleep(2)
            browser.quit()
            exit()



    try:
        Redemption_code_submit = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[4]/div/div/div/div')))
        Redemption_code_submit.click()
        if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[3]/div/div[4]/div/div/div/div/div'))).text =="Return to Shop":
            requests.post(url="https://sahwa.valantica.com/api/v1/redeem",json={"code":code,"code_id": code_id, "email": user_name, "status": "redeemed"}, headers=headers)
            print("Success ok  new way")
            time.sleep(2)
            browser.quit()
            exit()



    except Exception as error:
        try:
            if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[3]/div[3]/div/div[3]/div/div/div/div/div'))).text == 'OK' :
                requests.post(url="https://sahwa.valantica.com/api/v1/redeem",json={"code":code,"code_id": code_id, "email": user_name, "status": "redeemed"}, headers=headers)
                print("Success ok")
                time.sleep(2)
                browser.quit()
                exit()
        except:
            try:
                if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[1]/div/div'))).text == 'Redemption code is redeemed by someone else':
                    requests.post(url="https://sahwa.valantica.com/api/v1/convert-to-manual",json={"code":code,"code_id": code_id, "note": "Code is already redeemed"}, headers=headers)
                    print("Code is already redeemed")
                    browser.quit()
                    exit()
                elif wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[1]/div/div'))).text == 'You have already redeemed':
                    print("You have already redeemed")
                    requests.post(url="https://sahwa.valantica.com/api/v1/redeem",json={"code":code,"code_id": code_id, "email": user_name, "status": "redeemed"}, headers=headers)
                    browser.quit()
                    exit()
            except:
                if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[5]/div/div/div/div'))).text == 'verify comfirm' :
                    requests.post(url="https://sahwa.valantica.com/api/v1/block",json={"email":user_name}, headers=headers)
                    print("block-email")
                    browser.quit()
                    exit()
                print("An exception occurred:", error) #





except Exception as error:
    print("An exception occurred:", error) # An exception occurred:
    print("CODE HAS NOT REDEEMED")





browser.quit()
