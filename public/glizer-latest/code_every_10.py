import time
import os


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
            if seco in range(0, 100, 10):
                print(seco)
                os.system("python ./glizer.py")
                time.sleep(1)
        except Exception as e:
            print(f'error  : {e}')
            pass
