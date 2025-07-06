<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <style>
        /* Genel stil ayarları */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif; /* Modern bir font */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #6e8efb, #a777e3); /* Gradient arka plan */
            overflow: hidden;
        }

        /* Kart stil */
        .container {
            background: rgba(255, 255, 255, 0.95); /* Şeffaf beyaz arka plan */
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Daha yumuşak gölge */
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(10px); /* Arka plan bulanıklığı */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        /* Başlık */
        h2 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            font-weight: 600;
        }

        /* Giriş alanları */
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 1rem;
            border: none;
            border-radius: 8px;
            background: #f9f9f9;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus {
            background: #fff;
            box-shadow: 0 0 0 3px rgba(110, 142, 251, 0.2);
        }

        /* Buton */
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #007bff, #0056b3); /* Mavi tonlarında gradient */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
            background: linear-gradient(90deg, #0056b3, #003d80);
        }

        /* Link */
        .link {
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Uyarı kutusu */
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 300px;
        }

        .alert {
            background-color: #f4433684;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
            animation: fadeInOut 3s ease forwards;
            opacity: 0;
        }

        .alert strong {
            font-weight: 600;
        }

        /* Animasyon */
        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Responsive tasarım */
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 1.5rem;
            }
            h2 {
                font-size: 1.5rem;
            }
            input, button {
                padding: 10px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @viteReactRefresh
    @vite('resources/js/register.jsx')
</head>
<body>
    <div id="register"></div>
</body>
</html>
