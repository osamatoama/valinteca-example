

import os

url = r'C:\xampp\htdocs\personal\valinteca\empty\public\run_code_v2'

def run():
    os.system(f"start cmd /k py {url}\\code_every_10.py")
    # time.sleep(30)

run()
