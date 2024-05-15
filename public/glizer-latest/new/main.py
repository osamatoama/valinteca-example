# Developer: Tarek Rahman

from src.core import process
from src import api

import time
import requests

def main() -> None:
    # implement data recieving API here instead of hardcoding
    headers={"Content-Type":"application/json", "Accept":"application/json","X-Authorization": "HnweAEO5T7SArZCiy5SjzOx9cZ96qGEejaiIkvyZLZW1PrBZX64ofs5lO6s6UCmK","X-Device":"hetzner-server-1-new-code-1"}
    r = requests.get(url="https://sahwa.valantica.com/api/v1/retry/11543", headers=headers)
    print(r.json())
    if(r.json()['success'] == False):
        exit()

    email_address=r.json()['email']
    password=r.json()['password']
    player_id=533038203 #r.json()['player_id']
    redeem_code='qYNuUEZt2e2454e5a2'#r.json()['code']
    code_id = r.json()['code_id']

    start_time = time.ctime()

    try:
        result = process(
            email_address=email_address,
            password=password,
            player_id=player_id,
            redeem_code=redeem_code
        )
        print("SUCCESS: ", result)
        api.handle_success(success_message=result,code=redeem_code,code_id=code_id,email=email_address)
    except Exception as error:
        print("ERROR: ", str(error))
        api.handle_failure(error_message=str(error).strip(),code=redeem_code,code_id=code_id,email=email_address)


    print(start_time)
    print(time.ctime())


if __name__=="__main__":
    main()

