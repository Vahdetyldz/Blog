from flask import Flask, jsonify
import os
from bs4 import BeautifulSoup
import requests

app = Flask(__name__)

from flask_cors import CORS
CORS(app)



BASE_DIR = os.path.dirname(os.path.abspath(__file__))


# Yamaha scraping (live)
def scrape_yamaha():
    url = "https://tr-yamaha-motor.com/fiyat-listesi/road-price-list.html?price"
    r = requests.get(url, headers={"User-Agent": "Mozilla/5.0"})
    r.encoding = r.apparent_encoding  # Karakter bozulmasını önle
    soup = BeautifulSoup(r.text, "html.parser")
    prices = []
    for table in soup.find_all("table"):
        for row in table.find_all("tr"):
            cols = row.find_all("td")
            if len(cols) == 3:
                model = cols[0].get_text(strip=True)
                year = cols[1].get_text(strip=True)
                price = cols[2].get_text(strip=True)
                if model and price and year != "Model Yılı":
                    prices.append({"brand": "Yamaha", "model": model, "year": year, "price": price})
    return prices

# Kawasaki scraping (live)
def scrape_kawasaki():
    url = "https://www.kawasaki.com.tr/Home/FiyatListesi"
    r = requests.get(url, headers={"User-Agent": "Mozilla/5.0"})
    r.encoding = r.apparent_encoding
    soup = BeautifulSoup(r.text, "html.parser")
    prices = []
    for table in soup.find_all("table"):
        for row in table.find_all("tr"):
            cols = row.find_all("td")
            # Sadece 3 hücreli ve hepsinde <h6> olan satırlar gerçek veri satırı
            if len(cols) == 3 and all(col.find("h6") for col in cols):
                model = cols[0].find("h6").get_text(strip=True)
                category = cols[1].find("h6").get_text(strip=True)
                price = cols[2].find("h6").get_text(strip=True)
                # Fiyat sütununda rakam yoksa atla
                if not any(char.isdigit() for char in price):
                    continue
                prices.append({"brand": "Kawasaki", "model": model, "category": category, "price": price})
    return prices

# CFMOTO scraping (live)
def scrape_cfmoto():
    url = "https://www.cfmoto.com.tr/fiyat-listesi?y=2024"
    r = requests.get(url, headers={"User-Agent": "Mozilla/5.0"})
    r.encoding = 'iso-8859-9'  # Sayfa Latin-5 kodlaması kullanıyor
    soup = BeautifulSoup(r.text, "lxml")
    prices = []
    for table_box in soup.find_all("div", class_="table-box"):
        category = table_box.find("strong", class_="h2")
        category_name = category.get_text(strip=True) if category and category.get_text(strip=True) else "Diğer"
        rows = table_box.find_all("tr")
        for row in rows:
            cols = row.find_all("td")
            if len(cols) == 5:
                tip = cols[0].get_text(strip=True)
                model = cols[1].get_text(strip=True)
                price = cols[2].get_text(strip=True)
                # Başlık veya boş satırları atla
                if not model or not price:
                    continue
                if any(x in model.lower() for x in ["model", "tür", "kategori"]):
                    continue
                if any(x in price.lower() for x in ["model", "tür", "kategori"]):
                    continue
                prices.append({
                    "brand": "CFMOTO",
                    "category": category_name,
                    "type": tip,
                    "model": model,
                    "price": price
                })
            elif len(cols) == 2:
                model = cols[0].get_text(strip=True)
                price = cols[1].get_text(strip=True)
                if not model or not price:
                    continue
                if any(x in model.lower() for x in ["model", "tür", "kategori"]):
                    continue
                if any(x in price.lower() for x in ["model", "tür", "kategori"]):
                    continue
                prices.append({
                    "brand": "CFMOTO",
                    "category": category_name,
                    "model": model,
                    "price": price
                })
    return prices

@app.route('/api/motor-prices')
def get_all_prices():
    all_prices = []
    all_prices.extend(scrape_yamaha())
    all_prices.extend(scrape_kawasaki())
    all_prices.extend(scrape_cfmoto())
    return jsonify(all_prices)

if __name__ == '__main__':
    app.run(debug=True)
