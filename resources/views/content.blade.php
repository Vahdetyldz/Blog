<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Clean Blog - Start Bootstrap Theme</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        <style>
            .comment-container {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: 500px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
          }
          
          .profile {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: 15px;
          }
          
          .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
          }
          
          .user-info {
            display: flex;
            flex-direction: column; /* İsim ve tarih alt alta olacak */
            margin-left: 10px;
          }
          
          .name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
          }
          
          .date {
            font-size: 12px;
            color: #777;
          }
          
          .comment-text {
            flex-grow: 1;
          }
          
          .comment-text p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
            margin: 0;
          }
            /* Sadece share-popup ve içindeki butonları etkiler, global body fontunu değiştirmez */
            .share-popup {
                display: none;
                position: absolute;
                background: #fff;
                border: 1.5px solid #e0e4ea;
                padding: 8px 16px 12px 16px;
                border-radius: 12px;
                box-shadow: 0 6px 24px rgba(0,0,0,0.13);
                z-index: 10000;
                min-width: 120px;
                min-height: 40px;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 12px;
                transition: box-shadow 0.2s;
                font-family: inherit !important;
            }
            .share-popup::after {
                content: '';
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                bottom: -12px;
                width: 22px;
                height: 12px;
                background: transparent;
                pointer-events: none;
                z-index: 10001;
                border-left: 11px solid transparent;
                border-right: 11px solid transparent;
                border-top: 12px solid #fff;
                filter: drop-shadow(0 2px 2px rgba(0,0,0,0.07));
            }
            .share-popup a {
                margin: 0 2px;
                font-size: 18px;
                text-decoration: none;
                border-radius: 50%;
                width: 38px;
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f6f8fa;
                transition: background 0.15s, box-shadow 0.15s;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                font-family: inherit !important;
            }
            .share-popup a:hover {
                opacity: 1;
                background: #e9eef6;
                box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @viteReactRefresh
        @vite('resources/js/chatbot.jsx')
    </head>
    <body>
        <div id="chatbot"></div>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#">İÇERİK SAYFASI</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/">Ana Sayfa</a></li><!--Blog Sayfasına yönlendir-->
                        <!--<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="#">Hakkımda</a></li>-->
                        @if (Auth::check())
                            @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'root'))
                                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('admin.dashboard') }}">Admin Paneli</a></li>
                            @endif
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('motor.prices') }}">Motosiklet Fiyatları</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('blog.create') }}">Blog Oluştur</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('blog.myblogs',['id' => session('user')])}}">Bloglarım</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('logout') }}">Çıkış Yap</a></li>
                            
                        @else
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('motor.prices') }}">Motosiklet Fiyatları</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('login.form') }}">Giriş Yap</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('register.form') }}">Kayıt Ol</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Header-->
        <header class="masthead" style="background-image: url('{{ $blog->image ? asset('storage/' . $blog->image) : asset('assets/img/DefaultPitcure.png') }}')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                            <h1>{{$blog->title}}</h1>
                            <h2 class="subheading">{{$blog->subtitle}}</h2>
                            <span class="meta">
                                <a href="#!">{{$blog->user->name}} {{$blog->user->surname}}</a>
                                tarafından {{ \Carbon\Carbon::parse($blog->created_at)->locale('tr')->translatedFormat('j F Y') }} tarihinde paylaşıldı.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Post Content-->
        <article class="mb-4">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <!-- Content -->
                        <p><?php echo (nl2br($blog->content)) ?></p>
        
                        @if (Auth::id() == $blog->user_id)
                            <div class="d-flex justify-content-end mb-4" style="gap: 12px;">
                                <a href="/blogs/{{ $blog->id }}/edit" 
                                   class="btn"
                                   style="
                                        background: linear-gradient(135deg, #4f8cff 0%, #235390 100%);
                                        color: #fff;
                                        border: none;
                                        border-radius: 8px;
                                        padding: 10px 28px;
                                        font-weight: 600;
                                        box-shadow: 0 2px 8px rgba(79,140,255,0.10);
                                        transition: background 0.2s, box-shadow 0.2s;
                                   "
                                   onmouseover="this.style.background='#235390'"
                                   onmouseout="this.style.background='linear-gradient(135deg, #4f8cff 0%, #235390 100%)'"
                                >
                                    <i class="fas fa-edit"></i> Düzenle
                                </a>
                                <a href="{{route('blog.destroy', $blog->id)}}"
                                   class="btn"
                                   style="
                                        background: linear-gradient(135deg, #ff5e62 0%, #ff9966 100%);
                                        color: #fff;
                                        border: none;
                                        border-radius: 8px;
                                        padding: 10px 28px;
                                        font-weight: 600;
                                        box-shadow: 0 2px 8px rgba(255,94,98,0.10);
                                        transition: background 0.2s, box-shadow 0.2s;
                                   "
                                   onmouseover="this.style.background='#ff5e62'"
                                   onmouseout="this.style.background='linear-gradient(135deg, #ff5e62 0%, #ff9966 100%)'"
                                >
                                    <i class="fas fa-trash-alt"></i> Sil
                                </a>
                            </div>
                        @endif
                        @if (Auth::check())
                        <!-- Comment Form -->
                        <form class="mt-4" action="{{route('comment.store')}}" method="POST"> 
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Yorum Yap</span>
                                <button type="submit" 
                                    class="btn"
                                    style="
                                        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
                                        color: #fff;
                                        border: none;
                                        border-radius: 8px;
                                        padding: 8px 24px;
                                        font-weight: 600;
                                        box-shadow: 0 2px 8px rgba(67,233,123,0.10);
                                        transition: background 0.2s, box-shadow 0.2s;
                                    "
                                    onmouseover="this.style.background='#43e97b'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'"
                                >
                                    <i class="fas fa-paper-plane"></i> Paylaş
                                </button>
                            </div>
                            <textarea name="comment" class="form-control" rows="5" placeholder="Yorumunuzu yazın..." style="resize: none; border-radius: 8px; border: 1.5px solid #b3c6e0;"></textarea>
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
                        </form>
                        <!-- kullanıcı giriş yapmadığı zaman yorum yazma(textarea) gözüksün fakat kullanıcı tıkladığı zaman giriş yapma ekranı çıksın -->
                        @endif 
                        <hr class="my-4">
                        @foreach ($comments as $comment)
                            <div class="comment-container">
                                <div class="profile">
                                    <img src="/assets/img/DefaultProfilPhoto.png" alt="Profile Picture" class="profile-img">
                                    <div class="user-info">
                                        <span class="name">{{$comment->user->name}} {{$comment->user->surname}}</span>
                                        <span class="date">{{ \Carbon\Carbon::parse($comment->created_at)->locale('tr')->translatedFormat('j F Y') }}</span>
                                    </div>
                                </div>
                                <div class="comment-text">
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </div>
                            <hr class="my-4">
                        @endforeach
                        <!-- İçeriğin yorumları burda gözükecek -->
                    </div>
                </div>
            </div>
        </article>
        <!-- Share Popup -->
        <div class="share-popup" id="sharePopup" style="display:none;">
            <a href="#" target="_blank" id="shareX" title="X (Twitter)">𝕏</a>
            <a href="#" target="_blank" id="shareFB" title="Facebook" style="color:#1877f2;font-weight:bold;">
                <svg width="20" height="20" viewBox="0 0 320 512" style="vertical-align:middle;"><path fill="#1877f2" d="M279.14 288l14.22-92.66h-88.91V127.91c0-25.35 12.42-50.06 52.24-50.06H293V6.26S259.5 0 225.36 0c-73.22 0-121 44.38-121 124.72v70.62H22.89V288h81.47v224h100.2V288z"/></svg>
            </a>
            <a href="#" target="_blank" id="shareLN" title="LinkedIn" style="color:#0a66c2;font-weight:bold;">
                <svg width="20" height="20" viewBox="0 0 448 512" style="vertical-align:middle;"><path fill="#0a66c2" d="M100.28 448H7.4V148.9h92.88zm-46.44-340.7C24.09 107.3 0 83.2 0 53.6A53.6 53.6 0 0 1 53.6 0a53.6 53.6 0 0 1 53.6 53.6c0 29.6-24.09 53.7-53.36 53.7zM447.8 448h-92.4V302.4c0-34.7-12.4-58.4-43.3-58.4-23.6 0-37.6 15.9-43.7 31.3-2.3 5.6-2.8 13.4-2.8 21.2V448h-92.4s1.2-242.1 0-267.1h92.4v37.9c12.3-19 34.3-46.1 83.5-46.1 60.9 0 106.7 39.8 106.7 125.4V448z"/></svg>
            </a>
        </div>
        <!-- Footer-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center" style="font-size: 1.5rem;">
                            <!--Twitter-->
                            <li class="list-inline-item" style="margin: 0 8px;">
                                <a href="#" class="text-reset">
                                    <span class="fa-stack" style="font-size: 1em;">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <!--Facebook-->
                            <li class="list-inline-item" style="margin: 0 8px;">
                                <a href="#" class="text-reset">
                                    <span class="fa-stack" style="font-size: 1em;">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <!--Github-->
                            <li class="list-inline-item" style="margin: 0 8px;">
                                <a href="https://github.com/Vahdetyldz" class="text-reset">
                                    <span class="fa-stack" style="font-size: 1em;">
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
        <script src="{{asset('js/scripts.js')}}"></script>
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
                        const range = selection.getRangeAt(0);
                        const rect = range.getBoundingClientRect();
                        const scrollY = window.scrollY || window.pageYOffset;
                        const scrollX = window.scrollX || window.pageXOffset;
                        // Popup'ı seçili metnin alt ortasına hizala
                        const x = rect.left + rect.width/2 + scrollX - popup.offsetWidth/2;
                        const y = rect.bottom + scrollY + 8; // 8px aşağıda

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
                        popup.style.display = "flex";
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
