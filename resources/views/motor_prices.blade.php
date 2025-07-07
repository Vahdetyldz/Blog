<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motosiklet Fiyat Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        h1,
        h2,
        h4 {
            font-family: 'Segoe UI', sans-serif;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .brand-section {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px #0001;
            padding: 2rem 1rem;
            margin-bottom: 2.5rem;
        }

        .brand-section h2 {
            border-left: 5px solid #0d6efd;
            padding-left: 12px;
        }

        .category-title {
            color: #6c757d;
            font-size: 1.1rem;
            margin-top: 1.5rem;
        }
    </style>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Clean Blog - Start Bootstrap Theme</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
        rel="stylesheet" type="text/css" />

    <!-- Sosyal Medya İkonları -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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
            flex-direction: column;
            /* İsim ve tarih alt alta olacak */
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
    <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">Motosiklet Fiyatları</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/">Ana Sayfa</a></li>
                    <!--Blog Sayfasına yönlendir-->
                    <!--<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="#">Hakkımda</a></li>-->
                    @if (Auth::check())
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('admin.dashboard') }}">Admin Paneli</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('motor.prices') }}">Motosiklet Fiyatları</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('blog.create') }}">Blog Oluştur</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('blog.myblogs', ['id' => session('user')])}}">Bloglarım</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('logout') }}">Çıkış
                                Yap</a></li>

                    @else
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('motor.prices') }}">Motosiklet Fiyatları</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('login.form') }}">Giriş Yap</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{ route('register.form') }}">Kayıt Ol</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead" style="
        background-image: url('/assets/img/africa-twin.jpeg');
        background-size: cover;
        background-position: center;
        /* height: 400px; */ /* isteğe bağlı */
    ">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading text-center py-5">
                        <h1>Clean Blog</h1>
                        <span class="subheading">Motosiklet Blog Sayfası</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container py-5">
        <h1 class="mb-4 text-center fw-bold">Motosiklet Fiyat Listesi</h1>
        <ul class="nav nav-tabs justify-content-center mb-4" id="brandTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="yamaha-tab" data-bs-toggle="tab" data-bs-target="#yamaha"
                    type="button" role="tab" aria-controls="yamaha" aria-selected="true">Yamaha</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kawasaki-tab" data-bs-toggle="tab" data-bs-target="#kawasaki" type="button"
                    role="tab" aria-controls="kawasaki" aria-selected="false">Kawasaki</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cfmoto-tab" data-bs-toggle="tab" data-bs-target="#cfmoto" type="button"
                    role="tab" aria-controls="cfmoto" aria-selected="false">CFMOTO</button>
            </li>
        </ul>
        <div id="loading" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Yükleniyor...</span>
            </div>
        </div>
        <div class="tab-content" id="brandTabsContent" style="display:none;">
            <div class="tab-pane fade show active" id="yamaha" role="tabpanel" aria-labelledby="yamaha-tab"></div>
            <div class="tab-pane fade" id="kawasaki" role="tabpanel" aria-labelledby="kawasaki-tab"></div>
            <div class="tab-pane fade" id="cfmoto" role="tabpanel" aria-labelledby="cfmoto-tab"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function groupBy(arr, key) {
            return arr.reduce((acc, item) => {
                (acc[item[key]] = acc[item[key]] || []).push(item);
                return acc;
            }, {});
        }

        fetch('http://localhost:5000/api/motor-prices')
            .then(res => res.json())
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('brandTabsContent').style.display = '';
                const grouped = groupBy(data, 'brand');
                // Yamaha
                let yamahaHtml = `<div class='table-responsive'><table class='table table-striped table-bordered align-middle'>`;
                yamahaHtml += `<thead><tr><th>Model</th><th>Yıl</th><th>Fiyat</th></tr></thead><tbody>`;
                (grouped['Yamaha'] || []).forEach(row => {
                    yamahaHtml += `<tr><td>${row.model}</td><td>${row.year}</td><td>${row.price}</td></tr>`;
                });
                yamahaHtml += `</tbody></table></div>`;
                document.getElementById('yamaha').innerHTML = yamahaHtml;
                // Kawasaki
                let kawasakiHtml = `<div class='table-responsive'><table class='table table-striped table-bordered align-middle'>`;
                kawasakiHtml += `<thead><tr><th>Tür</th><th>Model</th><th>Fiyat</th></tr></thead><tbody>`;
                (grouped['Kawasaki'] || []).forEach(row => {
                    kawasakiHtml += `<tr><td>${row.category ? row.category : ''}</td><td>${row.model}</td><td>${row.price}</td></tr>`;
                });
                kawasakiHtml += `</tbody></table></div>`;
                document.getElementById('kawasaki').innerHTML = kawasakiHtml;
                // CFMOTO
                let cfmotoHtml = '';
                const byCat = groupBy(grouped['CFMOTO'] || [], 'category');
                Object.keys(byCat).forEach(cat => {
                    cfmotoHtml += `<div class='category-title'>${cat}</div>`;
                    cfmotoHtml += `<div class='table-responsive'><table class='table table-striped table-bordered align-middle'>`;
                    cfmotoHtml += `<thead><tr><th>Tür</th><th>Model</th><th>Fiyat</th></tr></thead><tbody>`;
                    byCat[cat].forEach(row => {
                        cfmotoHtml += `<tr><td>${row.type ? row.type : ''}</td><td>${row.model}</td><td>${row.price}</td></tr>`;
                    });
                    cfmotoHtml += `</tbody></table></div>`;
                });
                document.getElementById('cfmoto').innerHTML = cfmotoHtml;
            })
            .catch(() => {
                document.getElementById('loading').innerHTML = '<div class="alert alert-danger">Veriler alınamadı.</div>';
            });
    </script>
</body>

</html>