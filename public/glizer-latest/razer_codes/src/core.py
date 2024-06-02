from src.browser import Browser

def process(razer_email, razer_password, initial_backup_code):
    browser = Browser()

    browser.visit_page()

    browser.sign_in(email_address=razer_email, password=razer_password)

    browser.navigate_to_account_page()

    codes = browser.generate_backup_codes(initial_backup_code=initial_backup_code)

    return codes