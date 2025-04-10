<?php

namespace App\Http\Controllers\Website;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'nullable|integer|min:1'
        ]);

        $articles = Article::where('status','published')
                    ->whereNotNull('publishing_date')
                    ->orderBy('publishing_date', 'desc')
                    ->paginate(5);

        return view('website_index', compact('articles'));
    }
}
