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
IFRAME_XPATH='//iframe[contains(@src,"https://www.midasbuy.com/apps/login/home/ae")]'
CONTINUE_SIGN_IN_BUTTON_XPATH='//div[contains(text(), "Continue")]'
EMAIL_ADDRESS_FIELD_XPATH='//input[@placeholder="Enter email to sign in or sign up"]'
PASSWORD_INPUT_FIELD_XPATH='//input[@placeholder="Enter password"]'
FINAL_SIGN_IN_BUTTON_XPATH='//div[contains(text(),"SIGN IN")]'


PLAYER_ID_LOCATION_XPATH='//span[@class="UserTabBox_id__u8hgT"]'
SIGN_IN_BUTTON_XPATH='//div[@class="MobileNav_sign_in__qA2oK"]'
PLAYER_ID_SWITCH_INITIATE_BUTTON_SELECTOR='div.UserTabBox_user_head__65f05 > span'
PLAYER_ID_INPUT_FIELD_XPATH='//input[@placeholder="Enter Player ID"]'
PLAYER_ID_SWITCH_OK_BUTTON_SELECTOR='div.BindLoginPop_btn_wrap__eiPwz > div > div > div > div'


REDEEM_CODE_INPUT_BOX_XPATH = '//input[@placeholder="Please enter a redeem code"]'
REDEEM_INITIATE_BUTTON_SELECTOR = 'div.RedeemGiftBox_input_g__euf1Y > div.RedeemGiftBox_btn_box__yNyi- > div > div > div > div'
SUBMIT_REDEEM_CODE_BUTTON_XPATH='//div[text()="Submit"]'
REDEEM_ERROR_NOTICE_XPATH='//i[@class="i-midas:notice icon"]/following-sibling::div'
REDEEM_SUCCESS_NOTICE_XPATH = '//div[text()="Redeem Successful"]'


class Browser:
    def __init__(self) -> None:
        options = Options()
        options.page_load_strategy = 'none'
        self.driver = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()), options=options)
    
    def visit_page(self):
        self.driver.get('https://www.midasbuy.com/midasbuy/ae/redeem/pubgm')

    def sign_in(self, email_address, password):
        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, DETECT_PAGE_LOADED_XPATH))
        )

        status = self.driver.execute_script(f"document.querySelector('{SIGN_IN_BUTTON_SELECTOR}').click();return 'clicked login button'")

        print(status)
        
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
        try:
            player_id = int(player_id)
        except:
            raise Exception("Invalid Player ID")
        
        self.driver.switch_to.default_content()
        original_player_id = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, PLAYER_ID_LOCATION_XPATH))).text.strip()
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

        status = self.driver.execute_script(f"document.querySelector('{PLAYER_ID_SWITCH_INITIATE_BUTTON_SELECTOR}').click();return 'clicked player switch button';")
        
        print(status)

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
    
    def redeem_code(self, redeem_code):
        redeem_code_input_box = self.driver.find_element(By.XPATH, REDEEM_CODE_INPUT_BOX_XPATH)
        redeem_code_input_box.send_keys(redeem_code)
        

        self.driver.execute_script(
            f'document.querySelector("{REDEEM_INITIATE_BUTTON_SELECTOR}").click()'
        )
        
        submit_redeem_btn = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, SUBMIT_REDEEM_CODE_BUTTON_XPATH))
        )

        self.driver.execute_script(
            'arguments[0].click()',
            submit_redeem_btn
        )

        time.sleep(3)

        try:
            return self.driver.find_element(By.XPATH, REDEEM_ERROR_NOTICE_XPATH).text
        except:...

        
        try:
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, REDEEM_SUCCESS_NOTICE_XPATH))
            )
            return True
        except:
            try:
                return self.driver.find_element(By.XPATH, REDEEM_ERROR_NOTICE_XPATH).text
            except:...
            return 'Failed to Redeem Code for UNKNOWN REASON'

