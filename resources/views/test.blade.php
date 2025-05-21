<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Blog Sitesi Yönetim Paneli')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text">Blog Sitesi Admin <sup></sup></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item @if (Request::segment(2) == 'panel') active @endif ">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Panel</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                İçerik Yönetimi
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(2) == 'yazilar') in @else collapsed @endif " href="#"
                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-edit"></i>
                    <span>Yazılar</span>
                </a>
                <div id="collapseTwo" class="collapse @if (Request::segment(2) == 'yazilar') show @endif"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Yazı İşlemleri:</h6>
                        <a class="collapse-item  @if (Request::segment(2) == 'yazilar' and !Request::segment(3)) active @endif"
                            href="">Tüm Yazılar</a>
                        <a class="collapse-item  @if (Request::segment(2) == 'yazilar' and Request::segment(3) == 'create') active @endif"
                            href="">Yazı Oluştur</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Kategoriler</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(2) == 'sayfalar') in @else collapsed @endif " href="#"
                    data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
                    aria-controls="collapsePage">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Sayfalar</span>
                </a>
                <div id="collapsePage" class="collapse @if (Request::segment(2) == 'sayfalar') show @endif"
                    aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sayfa İşlemleri:</h6>
                        <a class="collapse-item  @if (Request::segment(2) == 'sayfalar' and !Request::segment(3)) active @endif"
                            href="">Tüm Sayfalar</a>
                        <a class="collapse-item  @if (Request::segment(2) == 'sayfalar' and Request::segment(3) == 'create') active @endif"
                            href="">Sayfa Oluştur</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">ELİF EKİN BİÇER</span>

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Çıkış Yap
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                        <a href="" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-globe fa-sm text-white-50"></i> Siteyi görüntüle</a>
                    </div>
                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weighy-bold text-primary">@yield('title')</h6>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label> Yazı Başlığı</label>
                                    <input type="text" name="title" class="form-control" required></input>
                                </div>

                                <div class="form-group">
                                    <label> Yazı Kategorisi</label>
                                    <select class="form-control" name="category" required>
                                        <option value="">Seçim Yapınız</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label> Yazı Fotoğrafı</label>
                                    <input type="file" name="image" class="form-control" required></input>
                                </div>

                                <div class="form-group">
                                    <label> Yazı İçeriği</label>
                                    <textarea id="editör" name="content" class="form-control" rows=4
                                        required></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Yazıyı Oluştur</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Blog Sitesi Admin {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Çıkış yapmak istediğinden emin misin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">İptal</button>
                    <a class="btn btn-primary" href="">Çıkış yap</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/js/demo/chart-area-demo.js"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/js/demo/chart-pie-demo.js"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/datatables/jquery.dataTables.min.js">
    </script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/vendor/datatables/dataTables.bootstrap4.min.js">
    </script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages') }}/js/demo/datatables-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#editör').summernote({
                'height': 300
            });
        });
    </script>
</body>
</html>
@section('title', 'Yazı Oluştur')