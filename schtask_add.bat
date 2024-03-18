
schtasks /Create /TN XAMPP /TR "C:\Users\altoa\AppData\Local\Programs\Python\Python312\python.exe C:/xampp/htdocs/personal/valinteca/empty/python/glizer.py" /SC MINUTE /MO 1

schtasks /Create /TN XAMPP2 /TR "C:/xampp/php/php.exe C:/xampp/htdocs/personal/valinteca/empty/artisan schedule:run" /SC MINUTE /MO 1



schtasks /Query /TN XAMPP
schtasks /Run /TN XAMPP

schtasks /Delete /TN XAMPP /F


