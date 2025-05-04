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
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="/">ANA SAYFA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/">Ana Sayfa</a></li><!--Blog Sayfasına yönlendir-->
                        <!--<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="#">Hakkımda</a></li>-->
                        @if (Auth::check())
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('blog.create') }}">Blog Oluştur</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('blog.myblogs', 'Auth::id()')}}">Bloglarım</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('logout') }}">Çıkış Yap</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('login.form') }}">Giriş Yap</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('register.form') }}">Kayıt Ol</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        

        <!-- Page Header-->
        <header class="masthead" style="background-image: url('{{ asset('assets/img/africa-twin.jpeg') }}')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Clean Blog</h1>
                            <span class="subheading">Hazır Blog Sayfası</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div id="blog-container">
                        @foreach ($blogs->take(4) as $blog)
                            <div class="post-preview">
                                <a href="/blog-content/{{ $blog->id }}">
                                    <h2 class="post-title">{{ $blog->title }}</h2>
                                    <h3 class="post-subtitle">{{$blog->subtitle}}</h3>
                                </a>
                                <p class="post-meta">
                                    <a href="/blog-content/{{ $blog->id }}">{{ $blog->user->name }} {{$blog->user->surname}}</a>
                                    tarafından {{ \Carbon\Carbon::parse($blog->created_at)->locale('tr')->translatedFormat('j F Y') }} tarihinde paylaşıldı.
                                </p>
                            </div>
                            <hr class="my-4">
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <!--Bu div şimdilik gereksiz-->
                        <!--<button class="btn btn-primary text-uppercase" id="loadMoreBtn">Daha Fazla Göster</button>-->
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                       {{ $blogs->links() }}
                    </div>
                    
                </div>
            </div>
            <!-- ChatBot -->
            <div id="chat-widget" style="position: fixed; bottom: 20px; right: 20px;">
                <button onclick="toggleChat()" style="padding: 10px 15px; border-radius: 50%; background: #3490dc; color: white; border: none;">💬</button>
            
                <div id="chat-box" style="display: none; width: 300px; height: 400px; background: white; border: 1px solid #ccc; border-radius: 8px; margin-top: 10px; overflow: hidden;">
                    <div id="chat-messages" style="height: 340px; overflow-y: auto; padding: 10px;"></div>
                    <input type="text" id="chat-input" style="width: 100%; padding: 10px; border: none; border-top: 1px solid #ccc;" placeholder="Mesajınızı yazın..." onkeypress="if(event.key==='Enter'){sendMessage()}">
                </div>
            </div>
        </div>

        <!-- Footer-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center">
                            <!--Twitter-->
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <!--Facebook-->
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <!--Github-->
                            <li class="list-inline-item">
                                <a href="https://github.com/Vahdetyldz">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Vahdet Yıldız 2025</div>
                    </div>
                </div>
            </div>
        </footer>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
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