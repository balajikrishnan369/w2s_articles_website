<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Articles</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <style>
        .card-title {
            background: #e4dddd;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center bg-primary">Articles</h1>
        <div class="row">
            <div class="col-md-12">
                @forelse($articles as $article)
                    <div class="card mb-4 p-3 shadow-sm">
                        <div class="row g-0 align-items-center">
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image" class="img-fluid rounded" style="max-width: 150px;">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{!! $article->description !!}</p>
                            </div>
                            <div class="d-flex justify-content-end"><p class="text-muted small mb-0"><em>Published on: {{ \Carbon\Carbon::parse($article->publishing_date)->format('d-m-Y h:i A') }}</em></p></div>
                        </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No articles published.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $articles->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <script>
        $(document).on('keydown', function(e) {
            if (e.altKey && e.key.toLowerCase() === 'a') {
                window.location.href = "{{ route('admin.login') }}";
            }
        });
    </script>
</body>
</html>
