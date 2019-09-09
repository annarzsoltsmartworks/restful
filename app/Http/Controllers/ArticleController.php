<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article as ArticleResource;
use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
	    $articles = Article::orderBy('created_at', 'desc')->paginate(3);

	    // Return collection of article as a resource
		return ArticleResource::collection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$article = new Article;
	    $article->title = $request->input('title');
	    $article->body = $request->input('body');

	    if($article->save()){
	    	return new ArticleResource($article);
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    // Get articles
	    $article = Article::findOrFail($id);

	    // Return collection of article as a resource
	    return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
	    $article = Article::findOrFail($id);
	    $article->title = $request->input('title');
	    $article->body = $request->input('body');

	    if($article->save()){
		    return new ArticleResource($article);
	    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    // Get articles
	    $article = Article::findOrFail($id);

	    // Return collection of article as a resource
	    if($article->delete())
	    {
		    return new ArticleResource($article);
	    }
    }
}
