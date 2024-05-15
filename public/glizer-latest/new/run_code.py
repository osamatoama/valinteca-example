

import os
import os

url = os.getcwd()

def run():
    os.system(f"start cmd /k py {url}\\code_every_5.py")
    os.system(f"start cmd /k py {url}\\code_every_10.py")
    # time.sleep(30)

run()
