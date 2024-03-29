from requests import get

# Download the file
code = get("https://example.valinteca.com/python_live/emails-headless.py").text

# Write the data to a file
with open("main.py", "w") as f:
    f.write(code)

# Run the code
import main
