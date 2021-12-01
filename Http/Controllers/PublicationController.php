<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicationResource;
use App\Models\Kee;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Inertia\Inertia;

class PublicationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
   */
  public function index()
  {
    return PublicationResource::collection(Publication::all()->sortByDesc('created_at'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Inertia\Response
   */
  public function create(Request $request)
  {
    $path = $request->fullUrl();
    $query = parse_url($path, PHP_URL_QUERY);
    parse_str($query, $params);
    $kee_id = $params['kee'];
    return Inertia::render('LeicaComponent/Publication/PublicationForm', [
      'kee' => $kee_id,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return \Inertia\Response
   */
  public function store(Request $request)
  {
    //dd(auth()->user());
    if (auth()->user()->hasRole(['super-admin', 'admin'])) {
    $this->publication_validation($request);
    $pub = Publication::create([
      'name' => strip_tags($request->name),
      'status' => strip_tags($request->status),
      'description' => strip_tags($request->description),
      'url_link' => strip_tags($request->url_link),
      'kee_id' => strip_tags($request->kee)
    ]);

    $pub->save();

    return Inertia::render('LeicaComponent/Publication/PublicationAddEditConfirmation');
  }
}

  /**
   * Display the specified resource.
   *
   * @param Publication $publication
   * @return PublicationResource
   */
    public function show(Publication $publication)
    {
        return new PublicationResource($publication);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
      return Inertia::render('LeicaComponent/Publication/PublicationEdit');
    }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Publication $publication
   * @return PublicationResource
   */
    public function update(Request $request, Publication $publication)
    {
      //if (auth()->user()->hasRole(['super-admin', 'admin'])) {
      $this->publication_validation($request);

      $publication->update($request->all());
      //$publication->kee_id = strip_tags($request->kee_id);
      $publication->save();

      return new PublicationResource($publication);
    //}
}

  /**
   * Remove the specified resource from storage.
   *
   * @param Publication $publication
   * @return Response
   */
  public function destroy(Publication $publication)
  {
    //if (auth()->user()->hasRole(['super-admin', 'admin'])) {
    $publication->delete();
    // }
  }

  public function publication_validation($request)
  {
    $request->validate(
      [
        'name' => 'required|string|min:2|max:250',
        'status' => 'string|max:20',
        'description' => 'string',
        'url_link' => 'url',
        'kee_id' => 'Number'
      ]);
  }
}
