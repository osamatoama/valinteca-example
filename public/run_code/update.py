from requests import get

# Download the file
code = get("https://example.valinteca.com/run_code/glizer.py").text

# Write the data to a file
with open("glizer.py", "w") as f:
    f.write(code)

