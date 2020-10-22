<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    
    \DB::listen(function ($query) {
      info($query->sql);
    });

    // $page_size = $request->get('page_size');
    $moviesQuery = Movie::query();

    $title = $request->get('title', '');
    if ($title) {
      $moviesQuery->where('title', 'like', '%' . $title . '%');
    }

    $orderBy = $request->get('orderBy', null);
    $orderDirection = $request->get('orderDir', 'asc');
    if ($orderBy) {
      $moviesQuery->orderBy($orderBy, $orderDirection);
    }


    $take = $request->get('take', null);
    $skip = $request->get('skip', 0);
    if ($take) {
      $moviesQuery->skip($skip)->take($take);
    }
    
    $movies = $moviesQuery->paginate();
    return response()->json($movies);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateMovieRequest $request)
  {
    $data = $request->validated();
    $movie = Movie::create([
      "title" => $data['title'],
      "director" => $data['director'],
      "image_url" => $data['image_url'],
      'duration' => $data['duration'],
      'release_date' => $data['release_date'],
      'genre' => $data['genre'],
    ]);
    return $movie;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $movie = Movie::findOrFail($id);
    return response()->json($movie);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateMovieRequest $request, $id)
  {
    $movie = Movie::findOrFail($id);
    $movie->update($request->validated());
    return $movie;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $movie = Movie::findOrFail($id);
    $movie->delete();
    return $movie;
  }
}
