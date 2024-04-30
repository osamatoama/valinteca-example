from requests import get

# Download the file
code = get("https://example.valinteca.com/glizer-latest/glizer.py").text

# Write the data to a file
with open("glizer_test.py", "w") as f:
    f.write(code)

