'''
codes

b36j5kUw272f3fVbJc
b36j5TUj292f34V7Kd
b36j5gUD2t2835V2L5
b36j5QUy2M2530V2M7
b36j5iUQ282036V8N2
b36j5NUc2r2336V5P0
b36j5fU3252539V1Qf
b36j5TUx2X2035V3Rb
b36j5ZUe2b283aVbS8
b36j5VUT2j2139V5T8
b36j5tUE2U2730VbU4
b36j5yUT2E283bV4Va
b36j5sUu2D213fVcW9
b36j5kUL2w2938VdX8
b36j5sUp2M2d33V4Yf
b36j5kUD2i203fVeZ6
b36j5cUd2X2b34V2a5
b36j5SUs2G2933V6b6
b36j5iUD2v253dVcc6
b36j5LUg2P2736Vcdc
b36j5rUN2P2632Vae2
b36j5LU82b2933V3f4
b36j5KU22W2e39V2gd
b36j5HUX2b2e36V8h4
b36j5EUC2S223bV9ia
b36j5LUw2Q2c37Vcj4
b36j56UL2n2b30V6ka
b36j5bUX2f253bV4m2


Emails

cicqo97622@finloe.com	Zz102030
nbtpq32608@scatinc.com	Zz102030
pzwjxl4005@rambara.com	Zz102030
dmnoj77885@fabtivia.com	Zz102030
lffeskn303@gonaute.com	Zz102030
gknxgw3506@xredb.com	Bb102030
edrproz467@unite5.com	Bb102030
drfwgn8737@mailsd.net	Bb102030
zftrz30745@uaxpress.com	Bb102030
ylkuwf9682@enmaila.com	Bb102030
jnsyb81629@onymi.com	Ss102030
xjarfli476@effexts.com	Ss102030
gzvswm8092@eosatx.com	Ss102030
nmmiqk1894@lyunsa.com	Ss102030
fegppl0400@toolve.com	Ss102030
aekerb4054@coinxt.net	Nn102030


players
5254742728
533038203
5535899709

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


    user_name = 'cicqo97622@finloe.com'
    password = 'Zz102030'
    code = 'b36j5cUc2p283dV6z0'
    PlayerId =  '533038203'



    browser = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()),options=chrome_options)

    webpage = "https://www.midasbuy.com/midasbuy/my/redeem/pubgm"
    browser.get(webpage)

    js_code = "setInterval(function () {var s1 = document.querySelector('.activity-iframe-wrapper'), s2 = document.querySelector('.PatFacePopWrapper_visa-card-pat-face-pop__PTPdF'); if(s1) {s1.style.display = 'none'}  if(s2) { s2.style.display = 'none' }; }, 300) "
    browser.execute_script(js_code)

    try:
        wait = WebDriverWait(browser, 20)
        cookie_accept_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[13]/div[5]/i')))
        cookie_accept_button.click()
        time.sleep(5)

        cookie_accept_button = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[10]/div[3]/div[1]/div/div/div/div')))
        cookie_accept_button.click()
    except:
        wait = WebDriverWait(browser, 20)
        cookie_accept_button = wait.until(EC.element_to_be_clickable((By.XPATH, '//*[@id="root"]/div/div[9]/div[3]/div[1]/div/div/div/div')))
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
            print("id is wrong")
            time.sleep(2)
            browser.quit()
            exit()



    try:
        Redemption_code_submit = wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[4]/div/div/div/div')))
        Redemption_code_submit.click()
        if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[3]/div/div[4]/div/div/div/div/div'))).text =="Return to Shop":
            print("Success ok  new way")
            time.sleep(2)
            browser.quit()
            exit()



    except Exception as error:
        try:
            if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[3]/div[3]/div/div[3]/div/div/div/div/div'))).text == 'OK' :
                print("Success ok")
                time.sleep(2)
                browser.quit()
                exit()
        except:
            try:
                if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[1]/div/div'))).text == 'Redemption code is redeemed by someone else':
                    print("Code is already redeemed")
                    browser.quit()
                    exit()
                elif wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[1]/div/div'))).text == 'You have already redeemed':
                    print("You have already redeemed")
                    browser.quit()
                    exit()
            except:
                if wait.until(EC.element_to_be_clickable((By.XPATH, '/html/body/div[2]/div/div[6]/div[4]/div[2]/div[2]/div[5]/div/div/div/div'))).text == 'verify comfirm' :
                    print("block-email")
                    browser.quit()
                    exit()
                print("An exception occurred:", error) #





except Exception as error:
    print("An exception occurred:", error) # An exception occurred:
    print("CODE HAS NOT REDEEMED")





browser.quit()
