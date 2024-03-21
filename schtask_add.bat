
schtasks /Create /TN PYTHON /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\python\glizer.py" /SC MINUTE /MO 3

schtasks /Create /TN PYTHON2 /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\python\glizer.py" /SC MINUTE /MO 4

schtasks /Create /TN PYTHON3 /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\python\glizer.py" /SC MINUTE /MO 7




schtasks /Query /TN PYTHON
schtasks /Run /TN PYTHON
schtasks /Delete /TN PYTHON /F





schtasks /Create /TN PYTHON2 /TR "C:/xampp/php/php.exe C:/xampp/htdocs/personal/valinteca/empty/artisan schedule:run" /SC MINUTE /MO 1


