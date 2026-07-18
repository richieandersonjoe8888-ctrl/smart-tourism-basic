import os
from PIL import Image

def fix_image(path):
    img = Image.open(path).convert('RGBA')
    pixels = img.load()
    width, height = img.size
    for y in range(height):
        for x in range(width):
            r, g, b, a = pixels[x, y]
            # Detect light gray/white checkered pattern
            if abs(r - g) < 10 and abs(g - b) < 10:
                if (180 < r < 215) or (240 < r <= 255):
                    pixels[x, y] = (255, 255, 255, 255)
    img.save(path)

base_dir = r"c:\User files\School\Semester 4\FSWD\UAS\App"
paths = [
    os.path.join(base_dir, "auth-service", "public", "images", "app_icon.png"),
    os.path.join(base_dir, "vendor-service", "public", "images", "app_icon.png"),
    os.path.join(base_dir, "blog-service", "public", "images", "app_icon.png")
]

for p in paths:
    if os.path.exists(p):
        fix_image(p)
        print("Fixed:", p)
