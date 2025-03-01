<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Düzenle</title>
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
        input, textarea {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Blog Düzenle</h2>
        <form action="{{ route('post.update', ['id' => $blog->id]) }}" method="POST">
            @csrf
            @method('POST')
            <label>Başlık:</label>
            <input type="text" name="title" value="{{ $blog->title }}" required>
            <label>İçerik:</label>
            <textarea name="content" required>{{ $blog->content }}</textarea>
            <button type="submit">Güncelle</button>
        </form>
    </div>
</body>
</html>
