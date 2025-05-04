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
          </style>
    </head>
    <body>
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
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('blog.create') }}">Blog Oluştur</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('blog.myblogs',['id' => session('user')])}}">Bloglarım</a></li>
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
        <header class="masthead" style="background-image: url('{{asset('assets/img/post-bg.jpg')}}')">
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
                            <div class="d-flex justify-content-end mb-4">
                                <a href="{{route('blog.edit',$blog->id)}}" class="btn btn-primary">Düzenle</a>
                                <a href="{{route('blog.update', $blog->id)}}" class="btn btn-danger">Sil</a>
                            </div>
                        @endif
                        @if (Auth::check())
                        <!-- Comment Form -->
                        <form class="mt-4" action="{{route('comment.store')}}" method="POST"> 
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Yorum Yap</span>
                                <button type="submit" class="btn btn-success">Paylaş</button>
                            </div>
                            <textarea name="comment" class="form-control" rows="5" placeholder="Yorumunuzu yazın..." style="resize: none;"></textarea>
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
                        </form>
                        <!-- kullanıcı giriş yapmadığı zaman yorum yazma(textarea) gözüksün fakat kullanıcı tıkladığı zaman giriş yapma ekranı çıksın -->
                        @endif 
                        <hr class="my-4">
                        @foreach ($comments as $comment)
                            <div class="comment-container">
                                <div class="profile">
                                    <img src="Africa Twin.jpeg" alt="Profile Picture" class="profile-img">
                                    <div class="user-info">
                                        <span class="name">Vahdet Yıldız</span>
                                        <span class="date">18 Mart 2025</span>
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
        <script src="{{asset('js/scripts.js')}}"></script>
    </body>
</html>
