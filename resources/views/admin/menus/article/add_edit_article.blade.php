@extends('admin.index')

@section('content')
    <h2>{{ isset($articles) ? 'Edit Article' : 'Add New Article' }}</h2>
    <form action="{{ isset($articles) ? route('admin.articles.update', $articles->id) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($articles))
            @method('PUT')  
        @endif
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="@if(@$articles) {{ @$articles->title }} @endif">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="form-control" @error('image') is-invalid @enderror">
            @if(@$articles)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $articles->image) }}" class="img-fluid rounded" alt="Article Image" width="100">
                </div>
            @endif
            @error('error')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            @php 
            if(isset($articles)){
                $description =  $articles->description;
            } else if(old('description') != null){
                $description =  old('description');
            }else {
                $description =  '';
            }
            @endphp
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ $description }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="publishing_date">@if(isset($articles) && $articles->status == 'published') Published @else Publish  @endif Date and Time</label>
            <input type="datetime-local" @if(isset($articles) && $articles->status == 'published') readonly @endif name="publishing_date" id="publishing_date" class="form-control @error('publishing_date') is-invalid @enderror" value="{{ old('publishing_date', isset($articles) && $articles->publishing_date ? \Carbon\Carbon::parse($articles->publishing_date)->format('Y-m-d\TH:i') : '') }}">
            @error('publishing_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success btn-sm mt-3">{{ isset($articles) ? 'Update Article' : 'Save Article' }}</button>
        <a href="{{ isset($articles) && $articles->status == 'published' ? route('admin.articles.index') : route('admin.drafts.index') }}" class="btn btn-danger btn-sm mt-3">Cancel</a>
    </form>

    <script>
        // this is restriction for choosing past date and time
        const now = new Date().toISOString().slice(0, 16); 
        document.getElementById('publishing_date').setAttribute('min', now);

        ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
    </script>
@endsection
