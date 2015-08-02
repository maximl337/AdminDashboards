<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTemplateRequest;

class TemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $templates = Template::approved()->get();

        $templates = $templates->toArray();

        return view('template.browse', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CreateTemplateRequest $request)
    {
        $input = $request->input();

        $input['price'] = round($input['price']);

        $input['price_multiple'] = round($request->get('price_multiple'));

        $input['price_extended'] = round($request->get('price_extended'));

        $template = new Template($input);

        Auth::user()->templates()->save($template);

        return redirect()->action('TemplateController@show', [ $template->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $template = Template::findOrFail($id);

        return view('template.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
