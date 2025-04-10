@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Articles</h2>
        <div>
            <span class="mr-3">Welcome, <strong>{{ auth()->user()->name }}</strong></span>
            <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <div class="row">
        @can('isAdmin')
        <div class="col-md-6">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-success btn-sm mb-3">Create New Article</a>
        </div>
        @endcan
        @if(session('success'))
            <div class="col-md-6 alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="col-md-6 alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Description</th>
                        @can('isAdmin') <th>Actions</th> @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td><a href="{{ route('admin.articles.view', ['id' => $article->id]) }}" title="View Article">{{ $article->title }}</a></td>
                            <td>
                                <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image" class="img-fluid rounded" style="max-width: 150px;">
                            </td>
                            <td><p>{!!$article->description !!}</p></td>
                            @can('isAdmin')
                                <td>
                                    <a href="{{ route('admin.articles.edit', ['id' => $article->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="@can('isAdmin') 4 @else 3 @endcan"> Articles Not Yet Published..</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $articles->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
