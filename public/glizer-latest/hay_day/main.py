# Developer: Tarek Rahman

from src.core import process
from src import api

import time

def main() -> None:
    # implement data recieving API here instead of hardcoding
    email_address = 'lfqtkak110@imalias.com'
    password = 'Gg102030'
    player_id = "#2YYVPQCP0"
    razer_email = 'osamatoama96@gmail.com'
    razer_password = 'Rc2SaU.vb9jC4Xr'
    bacupcode = '12148119'
    product = '50'

    start_time = time.ctime()

    try:
        result = process(
            email_address=email_address,
            password=password,
            player_id=player_id,
            razer_email=razer_email,
            razer_password=razer_password,
            backup_code=bacupcode,
            product=product
        )
        print("SUCCESS: ", result)
        api.handle_success(success_message=result)
    except Exception as error:
        print("ERROR: ", str(error))
        api.handle_failure(error_message=str(error).strip())


    print(start_time)
    print(time.ctime())


if __name__=="__main__":
    main()

