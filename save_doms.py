import requests

urls = {
    "honda": "https://www.honda.com.tr/motosiklet/motosiklet-fiyat-listesi-2025",
    "yamaha": "https://tr-yamaha-motor.com/fiyat-listesi/road-price-list.html?price",
    "kawasaki": "https://www.kawasaki.com.tr/Home/FiyatListesi",
    "cfmoto": "https://www.cfmoto.com.tr/fiyat-listesi?y=2024"
}

headers = {
    "User-Agent": "Mozilla/5.0",
    "Accept-Language": "tr-TR,tr;q=0.9,en;q=0.8"
}

for name, url in urls.items():
    response = requests.get(url, headers=headers)
    with open(f"{name}_dom.html", "w", encoding="utf-8") as f:
        f.write(response.text)
    print(f"{name}_dom.html kaydedildi.")
