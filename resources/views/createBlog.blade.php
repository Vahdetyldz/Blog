<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Blog Oluştur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-md w-[800px]">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Form Sayfası</h2>

        <form action="{{route('post.store')}}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="input1" class="block text-gray-600">Başlık</label>
                <input type="text" id="input1" name="title" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label for="input2" class="block text-gray-600">Alt Başlık</label>
                <input type="text" id="input2" name="subTitle" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label for="textarea" class="block text-gray-600">İçerik</label>
                <textarea id="textarea" name="content" rows="4" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 h-[350px]"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Gönder</button>
        </form>
    </div>

</body>
</html>
