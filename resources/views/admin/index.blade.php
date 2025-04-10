<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <style>
    .nav-link {
        color: #333;
        background-color: #f8f9fa; 
        padding: 10px;
        border-radius: 5px;
    }

    .nav-link:hover {
        background-color: #e2e6ea; 
    }

    .nav-link.active {
        background-color: #007bff !important; 
        color: white !important;
    }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar vh-100 p-3">
                <h4 class="mb-3">Admin Panel</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.articles.index') || request()->routeIs('admin.articles.edit') || request()->routeIs('admin.articles.create') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">
                            Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.drafts.index') ? 'active' : '' }}" href="{{ route('admin.drafts.index') }}">
                            Draft Articles
                        </a>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        @yield('content')
    </main>
</div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        setTimeout(() => {
            let alertBox = document.querySelector('.alert');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 2000);
    </script>
</body>
</html>
