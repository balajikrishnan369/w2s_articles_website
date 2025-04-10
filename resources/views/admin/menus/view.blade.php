@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ isset($articles) && $articles->status == 'published' ? 'Published Article' : 'Draft Article' }}</h2>
        <a href="{{ isset($articles) && $articles->status == 'published' ? route('admin.articles.index') : route('admin.drafts.index') }}" class="btn btn-secondary btn-sm mt-3">back</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(isset($articles))
                @php 
                $image_path =  config('app.ADMIN_URL').$articles->image;
                @endphp
                <div class="card mb-4 p-3 shadow-sm">
                    <div class="row g-0 align-items-center">
                    <div class="col-md-3">
                        <img src="{{ asset('storage/' . $articles->image) }}" alt="Article Image" class="img-fluid rounded" style="max-width: 150px;">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title">{{ $articles->title }}</h5>
                            <p class="card-text">{!! $articles->description !!}</p>
                        </div>
                        <div class="d-flex justify-content-end"><p class="text-muted small mb-0"><em> {{ $articles->status == 'published' ? 'Published' : 'Publish' }} on: {{ \Carbon\Carbon::parse($articles->publishing_date)->format('d-m-Y h:i A') }}</em></p></div>
                    </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
