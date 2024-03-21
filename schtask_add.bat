
schtasks /Create /TN PYTHON /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:\xampp\htdocs\personal\valinteca\empty\python\glizer.py" /SC MINUTE /MO 10


schtasks /Create /TN PYTHON /TR "python C:/xampp/htdocs/personal/valinteca/empty/python/glizer.py" /SC MINUTE /MO 1

schtasks /Create /TN PYTHON2 /TR "C:/xampp/php/php.exe C:/xampp/htdocs/personal/valinteca/empty/artisan schedule:run" /SC MINUTE /MO 1



schtasks /Query /TN PYTHON
schtasks /Run /TN PYTHON

schtasks /Delete /TN PYTHON /F


wTVW6wgf2m2a5cgfRe
