<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Transformers\ArticleTransformer;

class ArticlesController extends Controller
{
    public function __construct()
    {
//        $this->middleware('jwt.auth');

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return json()->withPagination(
            \App\Article::paginate(5),
            new ArticleTransformer
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $article = \App\Article::with('comments', 'tags', 'attachments')->findOrFail($id);

        return json()->withItem(
            $article,
            new ArticleTransformer
        );
    }
}
