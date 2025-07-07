<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Merhaba</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <!-- resources/views/layouts/app.blade.php ya da ilgili Blade dosyanızın <head> içine -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @viteReactRefresh
        @vite('resources/js/main.jsx')
    </head>
    <body>
        <div id="main"></div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('js/scripts.js')}}"></script>
        <!--ChatBot Script-->
        <script>
            function toggleChat() {
                var box = document.getElementById('chat-box');
                box.style.display = (box.style.display === 'none') ? 'block' : 'none';
            }
        
            function sendMessage() {
                var input = document.getElementById('chat-input');
                var message = input.value.trim();
                if (!message) return;
        
                addMessage('Siz', message);
        
                fetch('/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ prompt: message })
                })
                .then(response => response.json())
                .then(data => {
                    addMessage('Bot', data.response || 'Cevap alınamadı.');
                })
                .catch(() => {
                    addMessage('Bot', 'Hata oluştu.');
                });
        
                input.value = '';
            }
        
            function addMessage(sender, message) {
                var messages = document.getElementById('chat-messages');
                var div = document.createElement('div');
                div.innerHTML = `<strong>${sender}:</strong> ${message}`;
                div.style.marginBottom = '10px';
                messages.appendChild(div);
                messages.scrollTop = messages.scrollHeight;
            }
        </script>
    </body>       
</html>