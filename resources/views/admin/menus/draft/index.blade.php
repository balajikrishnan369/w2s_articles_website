@extends('admin.index')

@section('content')
    <h2>Draft Article</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Description</th>
                        @can('isAdmin')<th>Actions</th>@endcan
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
                        <td class="text-center" colspan="@can('isAdmin') 4 @else 3 @endcan"> Draft Articles Not Yet Created..</td>
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
