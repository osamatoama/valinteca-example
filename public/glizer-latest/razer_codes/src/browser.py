from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.chrome.service import Service as ChromeService




class Browser:
    def __init__(self) -> None:
        options = Options()
        options.page_load_strategy = 'none'
        self.driver = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()), options=options)
        self.original_window = self.driver.current_window_handle

    def visit_page(self):
        self.driver.maximize_window()
        self.driver.get('https://razerid.razer.com/')

    def sign_in(self, email_address, password):
        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//input[@id="input-login-email"]'))
        )
        self.driver.find_element(By.XPATH,'//button[@id="onetrust-accept-btn-handler"]').click()
        time.sleep(3)
        email_input_field=self.driver.find_element(By.XPATH,'//input[@id="input-login-email"]')
        email_input_field.send_keys(email_address)

        password_input_field=self.driver.find_element(By.XPATH,'//input[@id="input-login-password"]')
        password_input_field.send_keys(password)

        login_button = self.driver.find_element(By.XPATH, '//button[@id="btn-log-in"]')
        login_button.click()

    def navigate_to_account_page(self):
        time.sleep(10)
        #popup = self.driver.find_element(By.XPATH, '/html/body/div[4]/div[1]/div/div/div/button[2]')
        #popup.click()


        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//a[@href="/account" and text()="Account"]'))
        ).click()

    def put_backup_code(self, backup_code):
        input_boxes = self.driver.find_elements(By.XPATH, '//input[@class=" input-otp"]')
        for i in range(0, 8):
            input_boxes[i].send_keys(str(backup_code)[i])

    def generate_backup_codes(self, initial_backup_code):
        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//a[@id="section-backup-codes"]'))
        ).click()

        option = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//li[@id="otp-listbox-backup"]/button'))
        )

        self.driver.execute_script(
            'arguments[0].click();',
            option
        )

        time.sleep(2)

        self.put_backup_code(backup_code=initial_backup_code)

        generate_new_code_button = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//button[text()="Generate New Codes"]'))
        )

        generate_new_code_button.click()

        generate_button  = WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//button[@id="btn-generate"]'))
        )

        time.sleep(2)

        generate_button.click()

        WebDriverWait(self.driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//div[text()="Generated"]'))
        )
        codes = []
        code_elements  = self.driver.find_elements(By.XPATH,'//div[@class="codes"]//div[@class=" item"]')
        for code_element in code_elements:
            code=code_element.text
            codes.append(code)
            print(code)


        return codes

