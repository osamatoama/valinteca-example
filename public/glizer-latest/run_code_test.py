

import os

url = r'C:\xampp\htdocs\personal\valinteca\empty\public\run_code'

def run():
    os.system(f"start cmd /k py {url}\\code_every_1_test.py")
    # time.sleep(30)

run()
