<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the articles
        $articles = Article::paginate(15);
        // return a collection of articles as resources
        return ArticleResource::collection($articles);
    }

    /**
     * Display a single resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get the article
        $article = Article::findOrFail($id);
        // return the article as resource
        return new ArticleResource($article);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create the article
        $article = Article::create($request->all());
        // Return the article as Resource
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the article
        $article = Article::findOrFail($id);
        // Update the article
        $article->update($request->all());
        // Return the updated article as Resource
        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the article
        $article = Article::findOrFail($id);

        // Return the deteled article if its has been successfully deleted
        if($article->delete()){
            return new ArticleResource($article);
        }
    }
}
