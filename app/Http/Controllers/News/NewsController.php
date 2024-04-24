<?php

// namespace App\Http\Controllers\News;

// use App\Http\Controllers\Controller;
// use App\Models\News\News;
// use Illuminate\Http\Request;
// use Inertia\Inertia;
// use Inertia\Response;

// class NewsController extends Controller
// {
//     public function index()
//     {
        
//         $news = News::select('speacies')->distinct()->get();
//         return Inertia::render('TimberCategory', ['species' => $news]);
//     }

//     public function show($news)
//     {
//         $news = News::where('speacies', $news)->get();
//         return Inertia::render('TimberChart', ['entries' => $news, 'species' => $news]);
//     }
// }
