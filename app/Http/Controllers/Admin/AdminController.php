<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(){
        $articles = Article::where('status', 'published')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        
        return view('admin.menus.article.index', compact('articles'));
    }

    public function create(){
        return view('admin.menus.article.add_edit_article');
    }

    public function draft(){
        $articles = Article::where('status','draft')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5);
        
        return view('admin.menus.draft.index', compact('articles'));
    }

    public function article_view($id){
        $articles = Article::find($id);
        if (!$articles) {
            return redirect()->route('admin.articles.index')->with('error', 'Article not found');
        }

        return view('admin.menus.view', compact('articles'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'publishing_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $publishingDate = Carbon::parse($value, 'Asia/Kolkata');
                    $currentTime = Carbon::now('Asia/Kolkata');
        
                    if ($publishingDate->lessThan($currentTime)) {
                        $fail('The publishing date must be in the future.');
                    }
                },
            ],
        ]);
        
        //store image
        $imagePath = $request->file('image')->store('articles', 'public');
        
        $article = Article::create([
            'title' => $validated['title'],
            'image' => $imagePath,
            'description' => $validated['description'],
            'publishing_date' =>\Carbon\Carbon::parse($validated['publishing_date'])->timezone('UTC'),
        ]);

        return redirect()->route('admin.drafts.index')->with('success', 'Article created successfully.');
    }

    public function edit($id){
        if (!ctype_digit($id)) {
            abort(400, "Invalid ID: Must be an integer.");
        }    
        $articles = Article::find($id);
        if (!$articles) {
            return redirect()->route('admin.articles.index')->with('error', 'Article not found');
        }
    
        return view('admin.menus.article.add_edit_article', compact('articles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $article = Article::findOrFail($id);
    
        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        } else {
            $imagePath = $article->image;
        }
        // update article
        $updateData = [
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'image'       => $imagePath,
        ];
        // update date only if article status is still in draft
        if ($article->status == 'draft') {
            $updateData['publishing_date'] = Carbon::parse($validated['publishing_date'])->timezone('UTC');
        }

        $article->update($updateData);

        if($article->status == 'published'){
            return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
        }else{
            return redirect()->route('admin.draft.index')->with('success', 'Article updated successfully.');
        }
    }

    public function delete($id){
        if (!ctype_digit($id)) {
            abort(400, "Invalid ID: Must be an integer.");
        }    
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('admin.articles.index')->with('error', 'Article not found');
        }
        // delete images while delete the article
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }

}
