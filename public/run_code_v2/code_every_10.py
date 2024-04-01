import time
import os
import requests

def get_server_time():
    try:
        hour = -1
        minu = -1
        seco = -1
        try:
            time_ = time.localtime()
            hour = time_.tm_hour
            minu = time_.tm_min
            seco = time_.tm_sec
        except Exception as e:
            print(f'error  get_server_time : {e}')
            pass
    except Exception as e:
        print(f'error  get_server_time : {e}')
        pass
    return hour, minu, seco



while True :
        try:
            hour, minu, seco  = get_server_time()
            if seco in range(0, 100, 5):
                print(seco)
                headers={"Content-Type":"application/json", "Accept":"application/json","X-Authorization": "HnweAEO5T7SArZCiy5SjzOx9cZ96qGEejaiIkvyZLZW1PrBZX64ofs5lO6s6UCmK","X-Device":"osama-new-code"}
                r = requests.get(url="https://example.valinteca.com/api/true", headers=headers)
                url = r'C:\xampp\htdocs\personal\valinteca\empty\public\run_code_v2'
                print("Hello")
                if(r.json()['success'] == False):
                    print("Hello")
                    exit()

                os.system(f"start cmd  /k py {url}\\glizer.py && move nul 2>&0")
                #os.system("python ./glizer.py")
                time.sleep(1)
        except Exception as e:
            print(f'error  : {e}')
            pass
