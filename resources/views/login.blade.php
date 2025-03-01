<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 400px;
            text-align: center;
        }
        input {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .link {
            margin-top: 10px;
            display: block;
        }
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 300px;
        }

        .alert {
            background-color: #f4433684; /* Kırmızı zemin */
            color: white; /* Beyaz yazı */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: opacity 0.5s ease;
        }

        .alert strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    @if ($errors->any())
        <div class="alert-container">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <strong>Hata:</strong> {{ $error }}
                </div>
            @endforeach
        </div>
    @endif
    <div class="container">
        <h2>Giriş Yap</h2>
        <form action="/login" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <button type="submit">Giriş Yap</button>
        </form>
        <a class="link" href="/register">Kayıt Ol</a>
    </div>
    <script>
        window.onload = function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach((alert, index) => {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 500);
                }, 3000 * (index + 1));
            });
        };
    </script>
</body>
</html>
