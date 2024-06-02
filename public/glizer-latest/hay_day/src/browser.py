from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.service import Service as ChromeService


DETECT_PAGE_LOADED_XPATH='//div[@class="Banner_title__dnHBH"]'
SIGN_IN_BUTTON_SELECTOR='div.MobileNav_sign_in__qA2oK'
IFRAME_XPATH='//iframe[contains(@src,"https://www.midasbuy.com/apps/login/home/tr")]'
CONTINUE_SIGN_IN_BUTTON_XPATH='//div[contains(text(), "Devam et")]'
EMAIL_ADDRESS_FIELD_XPATH='//input[@placeholder="Oturum açmak veya kaydolmak için e-posta adresini girin"]'
PASSWORD_INPUT_FIELD_XPATH='//input[@placeholder="Şifre gir"]'
FINAL_SIGN_IN_BUTTON_XPATH='//div[contains(text(),"Giriş Yap")]'


PLAYER_ID_LOCATION_XPATH='//span[@class="UserTabBox_id__u8hgT"]'
SIGN_IN_BUTTON_XPATH='//div[@class="MobileNav_sign_in__qA2oK"]'
PLAYER_ID_SWITCH_INITIATE_BUTTON_SELECTOR='span.UserTabBox_switch_btn__428iM'
PLAYER_ID_INPUT_FIELD_XPATH='//input[@placeholder="Lütfen Oyuncu Kimliğinizi girin"]'
PLAYER_ID_SWITCH_OK_BUTTON_SELECTOR='div.ScIdEnterPop_btn_wrap__MrO8p > div > div > div > div'



class Browser:
    def __init__(self) -> None:
        options = Options()
        options.page_load_strategy = 'none'
        self.driver = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()), options=options)
        self.original_window = self.driver.current_window_handle

    def visit_page(self):
        self.driver.maximize_window()
        self.driver.get('https://www.midasbuy.com/midasbuy/tr/buy/hayday')

    def sign_in(self, email_address, password):
        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, DETECT_PAGE_LOADED_XPATH))
        )
        status = self.driver.execute_script(f"document.querySelector('{SIGN_IN_BUTTON_SELECTOR}').click();return 'clicked login button'")

        print(status)
        time.sleep(2)
        iframe = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, IFRAME_XPATH))
        )

        self.driver.switch_to.frame(iframe)

        continue_button = WebDriverWait(self.driver, 20).until(
            EC.presence_of_element_located((By.XPATH, CONTINUE_SIGN_IN_BUTTON_XPATH))
        )
        email_address_field=WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.XPATH, EMAIL_ADDRESS_FIELD_XPATH))
        )

        email_address_field.send_keys(email_address)

        self.driver.execute_script(
            'arguments[0].click()',
            continue_button
        )

        password_input_field = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH,PASSWORD_INPUT_FIELD_XPATH))
        )

        password_input_field.send_keys(password)

        self.driver.find_element(By.XPATH, FINAL_SIGN_IN_BUTTON_XPATH).click()


    def switch_player_id(self, player_id):
        print('switch_player_id')
        try:
            player_id = player_id
        except:
            raise Exception("Invalid Player ID")

        self.driver.switch_to.default_content()
        try:
            original_player_id = WebDriverWait(self.driver, 5).until(
                EC.presence_of_element_located((By.XPATH, PLAYER_ID_LOCATION_XPATH))).text.strip()
        except:
            original_player_id = '/'
        if str(player_id) in original_player_id:
            print('Current Player ID is same as provided player ID. Skipping the step.')
            return
        # print('original_player_id: ',original_player_id)
        WebDriverWait(self.driver, 15).until(
            EC.invisibility_of_element((By.XPATH, SIGN_IN_BUTTON_XPATH))
        )

        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, DETECT_PAGE_LOADED_XPATH))
        )
        time.sleep(7)
        if original_player_id=='/':
            print(2)
            status = self.driver.execute_script(f"document.querySelector('.UserTabBox_switch_btn__428iM').click();return 'clicked player switch button';")
        else:
            print(3)
            status = self.driver.execute_script(f"document.querySelector('{PLAYER_ID_SWITCH_INITIATE_BUTTON_SELECTOR}').click();return 'clicked player switch button';")

        print(status)
        #########################

        player_id_input_field = WebDriverWait(self.driver, 15).until(
            EC.element_to_be_clickable((By.XPATH, PLAYER_ID_INPUT_FIELD_XPATH))
        )
        player_id_input_field.clear()
        player_id_input_field.send_keys(player_id)

        player_id_input_field.clear()
        player_id_input_field.send_keys(player_id)

        self.driver.execute_script(f"document.querySelector('{PLAYER_ID_SWITCH_OK_BUTTON_SELECTOR}').click();return 'clicked player switch OK button';")

        time.sleep(2)

        current_player_id = WebDriverWait(self.driver, 2).until(
            EC.presence_of_element_located((By.XPATH, PLAYER_ID_LOCATION_XPATH))
        ).text.strip()
        # print('current_player_id: ', current_player_id)
        if original_player_id==current_player_id:
            raise Exception("Invalid Player ID")

        print('Player switch process complete')


    def filter_razer_gold(self):
        print('filter_razer_gold')

        WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH,'//div[contains(@title,"Razer")]'))).click()

    def select_item(self,product):
        print('select_item')
        # accept_cookie_btn
        self.driver.find_element(By.XPATH,'/html/body/div[2]/div/div[10]/div[3]/div[1]/div/div').click()
        time.sleep(1)
        self.driver.find_element(By.XPATH,f'//div[@class="abTest_val__wyibD" and text()="{product}"]').click()

    def select_payment_channel(self):
        print('select_payment_channel')
        razer_gold = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH,'//div[@data-channel-id="RAZER_GOLD_WALLET"]')))
        razer_gold.click()
        time.sleep(10)

    def proceed_to_payment(self):
        print('proceed_to_payment')
        time.sleep(5)
        self.driver.find_element(By.XPATH, '//div[text()="Ödeme"]').click()
        time.sleep(3)
        self.driver.find_element(By.XPATH, '/html/body/div[2]/div/div[7]/div[9]/div[4]/div/div/div/div').click()

    def switch_to_payment_window(self):
        print('switch_to_payment_window')
        # WebDriverWait(self.driver, 10).until(EC.new_window_is_opened(self.driver.window_handles))
        time.sleep(5)
        new_window = [window for window in self.driver.window_handles if window != self.original_window][0]
        self.driver.switch_to.window(new_window)


    def log_in_to_razer_id(self, razer_email, razer_password):
        print('log_in_to_razer_id')
        accept_cookie_btn = WebDriverWait(self.driver,10).until(EC.presence_of_element_located((By.XPATH,'//button[@id="onetrust-accept-btn-handler"]')))
        accept_cookie_btn.click()
        email_input_field = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((By.XPATH,'//input[@id="loginEmail"]')))
        email_input_field.send_keys(razer_email)

        password_input_field = self.driver.find_element(By.XPATH, '//input[@id="loginPassword"]')
        password_input_field.send_keys(razer_password)

        self.driver.find_element(By.XPATH, '//button[@id="btn-log-in"]').click()


    def proceed_to_checkout(self):
#
#         agree_button = WebDriverWait(self.driver, 10).until(EC.element_to_be_clickable((By.XPATH,'/html/body/div[1]/div/div/div[4]/a')))
#         agree_button.click()
#         time.sleep(10)
#         proceed_to_checkout_btn = WebDriverWait(self.driver, 10).until(EC.element_to_be_clickable((By.XPATH,'/html/body/div[2]/main/section/div/div/div/div[6]/div/div[5]/form/button')))
#         proceed_to_checkout_btn.click()
        time.sleep(3)

        submit_redeem_btn = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '/html/body/div[2]/main/section/div/div/div/div[6]/div/div[5]/form/button'))
        )
        self.driver.find_element(By.XPATH, '//span[contains(text(),"opyright ©")]').location_once_scrolled_into_view
        self.driver.execute_script(
            'arguments[0].click()',
            submit_redeem_btn
        )

        print("proceed_to_checkout")

    def select_different_authentication_method(self):
        iframe = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//iframe[@title="Razer OTP"]'))
        )

        self.driver.switch_to.frame(iframe)
        different_method_button = WebDriverWait(self.driver, 30).until(EC.element_to_be_clickable((By.XPATH,'//button[text()="Choose a different method"]')))
        self.driver.execute_script('arguments[0].click();', different_method_button)

        use_backup_code_button = WebDriverWait(self.driver, 15).until(EC.presence_of_element_located((By.XPATH,'//button[text()="Backup Codes"]')))
        self.driver.execute_script('arguments[0].click();', use_backup_code_button)
        time.sleep(2)
        print("select_different_authentication_method")

    def put_backup_code(self, backup_code):
        print('put_backup_code')
        input_boxes = self.driver.find_elements(By.XPATH, '//input[@class=" input-otp"]')
        for i in range(0, 8):
            input_boxes[i].send_keys(str(backup_code)[i])
        self.driver.switch_to.default_content()
        time.sleep(4)
        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '/html/body/div[2]/main/section/div/div[1]/h2'))
        )

        try:
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, '/html/body/div[2]/main/section/div/div[1]/h2'))
            )
            time.sleep(4)
            print('balance: ')
            print(self.driver.find_element(By.XPATH, '/html/body/div[2]/main/section/div/div[2]/div/div/div[2]/div/div/div[2]/div[2]/h6/div/span').text)

            if  self.driver.find_element(By.XPATH, '/html/body/div[2]/main/section/div/div[1]/h2').text == 'Congratulations!':
                print(self.driver.find_element(By.XPATH, '/html/body/div[2]/main/section/div/div[1]/h2').text)
                print('Success Inside If')
                return True

            return False

        except:
            raise Exception("Invalid Authentication Code")

        ...




