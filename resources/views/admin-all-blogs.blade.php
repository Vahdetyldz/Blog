<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kategori</title>
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
    @viteReactRefresh
    @vite('resources/js/allBlogs.jsx')
</head>
<body>
    <div id="allBlogs"></div>

    <script>
        window.currentUser = @json(Auth::user());
    </script>
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