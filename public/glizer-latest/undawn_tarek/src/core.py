
from src.browser import Browser


def process(email_address, password, player_id, razer_email, razer_password, backup_code, product, server_group,server_name):
    browser = Browser()

    browser.visit_page()

    try:
        browser.sign_in(email_address=email_address, password=password)
    except:
        raise Exception("Failed to sign in")

    try:
        browser.switch_player_id(player_id=player_id, server_group=server_group,server_name=server_name)
    except Exception as err:
        raise Exception(str(err))

    browser.filter_razer_gold()
    browser.select_item(product)
    browser.select_payment_channel()
    browser.proceed_to_payment()
    browser.switch_to_payment_window()
    browser.log_in_to_razer_id(razer_email, razer_password)
    browser.proceed_to_checkout()
    browser.select_different_authentication_method()
    browser.put_backup_code(backup_code=backup_code)

    return 'Purchase Successful'

