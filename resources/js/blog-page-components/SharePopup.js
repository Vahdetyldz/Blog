// SharePopup.js (FontAwesome kit ile uyumlu, v2)
(function() {
    let popup = null;

    function removePopup() {
        if (popup) {
            popup.remove();
            popup = null;
        }
    }

    function createPopup(selectedText, x, y) {
        console.log('SharePopup aktif!'); // DEBUG
        removePopup();
        popup = document.createElement('div');
        popup.style.position = 'absolute';
        popup.style.left = x + 'px';
        popup.style.top = y + 'px';
        popup.style.background = '#fff';
        popup.style.border = '2px solid #1877f2';
        popup.style.borderRadius = '8px';
        popup.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
        popup.style.padding = '8px 12px';
        popup.style.zIndex = 9999;
        popup.style.display = 'flex';
        popup.style.gap = '10px';
        popup.style.alignItems = 'center';
        popup.style.fontSize = '16px';
        popup.style.backgroundClip = 'padding-box';

        // Kapat butonu
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '✕';
        closeBtn.title = 'Kapat';
        closeBtn.style.background = 'none';
        closeBtn.style.border = 'none';
        closeBtn.style.fontSize = '18px';
        closeBtn.style.cursor = 'pointer';
        closeBtn.onclick = removePopup;
        popup.appendChild(closeBtn);

        // Facebook
        const fbBtn = document.createElement('button');
        fbBtn.innerHTML = '<i class="fa-brands fa-facebook-f"></i> <span style="font-size:12px;">Facebook</span>';
        fbBtn.title = 'Facebook';
        fbBtn.style.background = '#1877f2';
        fbBtn.style.color = '#fff';
        fbBtn.style.border = 'none';
        fbBtn.style.borderRadius = '16px';
        fbBtn.style.width = 'auto';
        fbBtn.style.height = '32px';
        fbBtn.style.display = 'flex';
        fbBtn.style.alignItems = 'center';
        fbBtn.style.justifyContent = 'center';
        fbBtn.style.fontSize = '16px';
        fbBtn.style.cursor = 'pointer';
        fbBtn.style.padding = '0 10px';
        fbBtn.onclick = function() {
            alert('Facebook paylaşımı: ' + selectedText); // DEBUG
            const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href) + '&quote=' + encodeURIComponent(selectedText);
            window.open(url, '_blank', 'width=600,height=400');
            removePopup();
        };
        popup.appendChild(fbBtn);

        // LinkedIn
        const liBtn = document.createElement('button');
        liBtn.innerHTML = '<i class="fa-brands fa-linkedin-in"></i> <span style="font-size:12px;">LinkedIn</span>';
        liBtn.title = 'LinkedIn';
        liBtn.style.background = '#0a66c2';
        liBtn.style.color = '#fff';
        liBtn.style.border = 'none';
        liBtn.style.borderRadius = '16px';
        liBtn.style.width = 'auto';
        liBtn.style.height = '32px';
        liBtn.style.display = 'flex';
        liBtn.style.alignItems = 'center';
        liBtn.style.justifyContent = 'center';
        liBtn.style.fontSize = '16px';
        liBtn.style.cursor = 'pointer';
        liBtn.style.padding = '0 10px';
        liBtn.onclick = function() {
            alert('LinkedIn paylaşımı: ' + selectedText); // DEBUG
            const url = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.location.href) + '&summary=' + encodeURIComponent(selectedText);
            window.open(url, '_blank', 'width=600,height=400');
            removePopup();
        };
        popup.appendChild(liBtn);

        document.body.appendChild(popup);
        console.log('Popup DOM eklendi!'); // DEBUG
    }

    document.addEventListener('mouseup', function(e) {
        setTimeout(function() {
            const selection = window.getSelection();
            const text = selection ? selection.toString().trim() : '';
            if (text.length > 0) {
                const rect = selection.getRangeAt(0).getBoundingClientRect();
                const x = rect.left + window.scrollX + rect.width/2 - 60;
                const y = rect.top + window.scrollY - 50;
                createPopup(text, x, y);
            } else {
                removePopup();
            }
        }, 10);
    });

    document.addEventListener('scroll', removePopup);
    document.addEventListener('keydown', removePopup);
    document.addEventListener('mousedown', function(e) {
        if (popup && !popup.contains(e.target)) removePopup();
    });
})();
