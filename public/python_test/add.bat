
schtasks /Create /TN PYTHON /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\public/python_live\glizer.py" /SC MINUTE /MO 1

schtasks /Create /TN PYTHON2 /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\public\python_live\glizer_old_good_one.py" /SC MINUTE /MO 1


schtasks /Create /TN PYTHON3 /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\public/python_live\glizer.py" /SC MINUTE /MO 3


schtasks /Create /TN PYTHON4 /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\public\python_live\glizer_old_good_one.py" /SC MINUTE /MO 4



schtasks /Query /TN PYTHON
schtasks /Run /TN PYTHON
schtasks /Delete /TN PYTHON /F







