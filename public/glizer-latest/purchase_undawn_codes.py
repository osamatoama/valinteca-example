import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException, TimeoutException, ElementNotVisibleException
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.chrome.service import Service as ChromeService
from webdriver_manager.chrome import ChromeDriverManager


COOKIE_CONSENT_POPUP_XPATH="//div[@class='PopCookie_btn_wrap_block__26ldQ']/div[1]/div"
NAVIGATION_SIGN_IN_XPATH="//div[@data-iformat='login']"
EMAIL_INPUT_BOX_XPATH="//div[@class='input-box']/p/input[@placeholder='Oturum açmak veya kaydolmak için e-posta adresini girin']"
PASSWORD_INPUT_BOX_XPATH="//input[@type='password' and @tabindex='1']"
COMFIRM_BUTTON_XPATH="//div[@class='form-box']/div[3]/div"
LOGIN_BUTTON_XPATH="//div[@class='mess']/div[@class='btn-wrap btn-wraps']/div"
IFRAME_XPATH="//iframe[@id='login-iframe']"
NAVIGATION_XPATH="//p[@class='MobileNav_tablet_show__spkaJ MobileNav_pc_show__57cEq']"
CHECKBOX_WRAPPER_XPATH="//div[@class='FilterIndexPc_check_box__XBqxo false']"
RAZER_GOLD_FILTER_XPATH="//div[@class='FilterIndexPc_check_box__XBqxo false'][2]"
PAYMENT_POPUP_XPATH="//div[@class='ChannelListB_pop_mode_box__N5jHh ChannelListB_l_pop__q7l41 ChannelListB_main_pop__IDQkc ChannelListB_in__9OBKY ChannelListB_active__gvs2K visible']"
PAYMENT_POPUP_BUTTON_XPATH="//div[@class='Button_btn__P0ibl Button_btn_primary__1ncdM' and @data-pay-button='true']"
CHECKOUT_BUTTON_XPATH="//button[@id='onetrust-reject-all-handler']"
RAZER_GOLD_EMAIL_XPATH="//input[@id='loginEmail']"
RAZER_GOLD_PASSWORD_XPATH="//input[@id='loginPassword']"
RAZER_GOLD_LOGIN_BUTTON_XPATH="//button[@id='btn-log-in']"
RAZER_PAYMENT_BUTTON_XPATH="//button[@id='btn99']"
FOOTER_XPATH="//footer"
RAZER_OTP_XPATH="//iframe[@id='razerOTP']"
ALT_METHODS_XPATH="//div[@class='alt-methods']/button"
CHANGE_AUTH_METHOD_XPATH="//ul[@class='alt-menu ']/li[2]/button"
INPUTS_WRAPPER_XPATH="//div[@class='input-group-otp-2']/input"
SUCCESS_PAYMENT_XPATH="//div[@class='section-display']"


def purchase_undawn_code(user_data):
    WINDOW_SIZE = "1920,1080"
    options = webdriver.ChromeOptions()
    #options.add_argument('--headless=new') uncomment if you want faster execution without browser
    #options.add_argument('--no-sandbox')
    #options.add_argument('--disable-dev-shm-usage')
    options.add_argument("--window-size=%s" %WINDOW_SIZE)

    driver = webdriver.Chrome(service = ChromeService(ChromeDriverManager().install()), options=options)
    wait = WebDriverWait(driver, 2)


    try:
        # Go to Midasbuy website
        driver.get("https://www.midasbuy.com/midasbuy/tr/buy/undawngl")

        # Wait for and close the cookie consent popup
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, COOKIE_CONSENT_POPUP_XPATH))).click()


        # Sign in
        driver.find_element(By.XPATH, NAVIGATION_SIGN_IN_XPATH).click()
        driver.switch_to.frame('login-iframe')

        # Wait for the email input box to be visible and enter the email
        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.XPATH, EMAIL_INPUT_BOX_XPATH))).send_keys(user_data["email"])

        # Click the confirm button
        driver.find_element(By.XPATH, COMFIRM_BUTTON_XPATH).click()

        # Wait for the password input box to appear
        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.XPATH, PASSWORD_INPUT_BOX_XPATH))).send_keys(user_data["password"])

        # Click the "Giriş Yap" (Log In) button
        driver.find_element(By.XPATH, LOGIN_BUTTON_XPATH).click()

        # Switch back to the main content
        driver.switch_to.default_content()

        # Wait for the login iframe to disappear and the page to fully load
        WebDriverWait(driver, 10).until(EC.invisibility_of_element_located((By.XPATH, IFRAME_XPATH)))
        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.XPATH, NAVIGATION_XPATH)))
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, CHECKBOX_WRAPPER_XPATH)))

        # Apply the Razer Gold filter
        driver.find_element(By.XPATH, RAZER_GOLD_FILTER_XPATH).click()

        # Select the product and proceed to checkout
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, PRODUCT_CARD_XPATH))).click()
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, PAYMENT_POPUP_XPATH)))
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, PAYMENT_POPUP_BUTTON_XPATH))).click()
        #driver.find_element(By.XPATH, PAYMENT_POPUP_BUTTON_XPATH).click()

        # Handle the new tab for Razer Gold payment
        WebDriverWait(driver, 20).until(EC.number_of_windows_to_be(2))  # Wait until there are 2 open windows (original window + new tab)
        new_tab_handle = driver.window_handles[1]  # Assuming the new tab is the second window handle
        driver.switch_to.window(new_tab_handle)  # Switch to the new tab

        # Wait for the new tab to load
        WebDriverWait(driver, 20).until(EC.title_contains("The New Razer Gold & Silver"))
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, CHECKOUT_BUTTON_XPATH))).click()

        # Perform Razer Gold login
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, RAZER_GOLD_EMAIL_XPATH))).send_keys(user_data["razer_email"])
        driver.find_element(By.XPATH, RAZER_GOLD_PASSWORD_XPATH).send_keys(user_data["razer_password"])
        driver.find_element(By.XPATH, RAZER_GOLD_LOGIN_BUTTON_XPATH).click()

        # Proceed with the payment
        WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, RAZER_PAYMENT_BUTTON_XPATH))).click()

        # Scroll down to the footer
        footer = driver.find_element(By.XPATH, FOOTER_XPATH)
        driver.execute_script("arguments[0].scrollIntoView(true);", footer)
        actions = ActionChains(driver)
        actions.move_to_element(footer).perform()

        # Handle OTP verification
        WebDriverWait(driver, 10).until(EC.frame_to_be_available_and_switch_to_it((By.XPATH, RAZER_OTP_XPATH)))
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, ALT_METHODS_XPATH)))

        button = driver.find_element(By.XPATH, ALT_METHODS_XPATH)
        driver.execute_script("arguments[0].scrollIntoView(true);", button)

        actions = ActionChains(driver)
        actions.move_to_element(button).perform()

        driver.find_element(By.XPATH, ALT_METHODS_XPATH).click()

        driver.find_element(By.XPATH, CHANGE_AUTH_METHOD_XPATH).click()

        # Use backup code for verification
        backup_code = user_data["backup_code"]

        # Wait for a successful element (like a section or title) to appear
        backup_codes = driver.find_elements(By.XPATH, INPUTS_WRAPPER_XPATH)

        # Iterate through backup codes inputs and send corresponding digits
        for index in range(0, len(backup_codes)):
          if index < len(backup_code):
            backup_codes[index].send_keys(backup_code[index])

        # Wait for a successful element (like a section or title) to appear
        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.XPATH, SUCCESS_PAYMENT_XPATH)))

        print("Success") # Here goes api call for success

    except (Exception, ElementNotVisibleException, NoSuchElementException, TimeoutException) as e:
        # send_api_response("fail", str(e))  Here goes api call for failure
        print("error")
        print(e)
    finally:
        driver.quit()


if __name__ == "__main__":
    # Here goes api call data
    user_data = {
        "email": "layeho9565@hbkio.com",
        "password": "Zz102030",
        "player_id": "13005236967",
        "player_server": "Kayp sehir",
        "razer_email": "osamatoama96@gmail.com",
        "razer_password": "Rc2SaU.vb9jC4Xr",
        "backup_code": "76119701",
        "product_id": "1460000219_1400050_tr"
    }
    PRODUCT_CARD_XPATH = f'//div[@data-product-id="{user_data["product_id"]}"]'
    purchase_undawn_code(user_data)