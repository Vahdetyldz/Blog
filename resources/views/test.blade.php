<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Seçilen Metni Paylaş</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
    }

    .share-popup {
      display: none;
      position: absolute;
      background: #fff;
      border: 1px solid #ccc;
      padding: 8px 10px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .share-popup a {
      margin: 0 6px;
      font-size: 18px;
      text-decoration: none;
    }

    .share-popup a:hover {
      opacity: 0.75;
    }
  </style>
  <meta property="og:title" content="Proxy Nedir? - Blog Başlığı">
  <meta property="og:description" content="Proxy nedir, nasıl çalışır? Kısa ve anlaşılır açıklama.">
  <meta property="og:image" content="https://seninsiten.com/path/to/og-image.jpg">
  <meta property="og:url" content="https://seninsiten.com/bu-sayfa-url">
  <meta property="og:type" content="article">
</head>
<body>

<h2>Proxy Nedir?</h2>
<p>
  Bilgisayarlar ve internet ile bağlantılı olarak “proxy” kelimesini kullandığımızda, genellikle bir <strong>proxy IP adresi</strong>, onun adına hareket ederek gerçek IP adresinizi gizlemeye yardımcı olur.
</p>
<p>
  Bir web sitesine eriştiğinizde, sitenin size belirli bir sonuç vermek için yürüttüğü sürece siteyle etkileşime girersiniz. Bir proxy, bu istekleri yakalar ve çoğu durumda bu isteği alarak ya da isteği istenen site sunucusuna ileterek bunları bilgisayarınız adına getirildiğinde, <strong>proxy</strong> verileri size geri gönderir.
</p>

<div class="share-popup" id="sharePopup">
  <a href="#" target="_blank" id="shareX" title="X (Twitter)">𝕏</a>
  <a href="#" target="_blank" id="shareFB" title="Facebook" style="color:#1877f2;font-weight:bold;"> 
    <svg width="20" height="20" viewBox="0 0 320 512" style="vertical-align:middle;"><path fill="#1877f2" d="M279.14 288l14.22-92.66h-88.91V127.91c0-25.35 12.42-50.06 52.24-50.06H293V6.26S259.5 0 225.36 0c-73.22 0-121 44.38-121 124.72v70.62H22.89V288h81.47v224h100.2V288z"/></svg>
  </a>
  <a href="#" target="_blank" id="shareLN" title="LinkedIn" style="color:#0a66c2;font-weight:bold;">
    <svg width="20" height="20" viewBox="0 0 448 512" style="vertical-align:middle;"><path fill="#0a66c2" d="M100.28 448H7.4V148.9h92.88zm-46.44-340.7C24.09 107.3 0 83.2 0 53.6A53.6 53.6 0 0 1 53.6 0a53.6 53.6 0 0 1 53.6 53.6c0 29.6-24.09 53.7-53.36 53.7zM447.8 448h-92.4V302.4c0-34.7-12.4-58.4-43.3-58.4-23.6 0-37.6 15.9-43.7 31.3-2.3 5.6-2.8 13.4-2.8 21.2V448h-92.4s1.2-242.1 0-267.1h92.4v37.9c12.3-19 34.3-46.1 83.5-46.1 60.9 0 106.7 39.8 106.7 125.4V448z"/></svg>
  </a>
</div>

<script>
  const popup = document.getElementById("sharePopup");
  const shareX = document.getElementById("shareX");
  const shareFB = document.getElementById("shareFB");
  const shareLN = document.getElementById("shareLN");

  document.addEventListener("mouseup", function (e) {
    setTimeout(() => {
      const selection = window.getSelection();
      const text = selection.toString().trim();

      if (text.length > 0) {
        const x = e.pageX;
        const y = e.pageY;

        const encodedText = encodeURIComponent(text);
        const currentURL = encodeURIComponent(window.location.href);

        // X (Twitter)
        shareX.href = `https://twitter.com/intent/tweet?text=${encodedText}%20${currentURL}`;
        // Facebook (sadece link paylaşımı)
        shareFB.href = `https://www.facebook.com/sharer/sharer.php?u=${currentURL}`;
        // LinkedIn (sadece link paylaşımı)
        shareLN.href = `https://www.linkedin.com/sharing/share-offsite/?url=${currentURL}`;

        popup.style.left = `${x}px`;
        popup.style.top = `${y}px`;
        popup.style.display = "block";
      } else {
        popup.style.display = "none";
      }
    }, 10); // kısa bir gecikme, seçim işleminden sonra çalışması için
  });

  document.addEventListener("click", function (e) {
    if (!popup.contains(e.target)) {
      popup.style.display = "none";
    }
  });
</script>

</body>
</html>
