<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Imgur;
use Auth;
use App\User;
use App\Tag;
use Storage;
use OpenCloud\Rackspace;
use App\Contracts\FileStorage;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTemplateRequest;

class TemplateController extends Controller
{

    protected $storage;

    public function __construct(FileStorage $storage)
    {
        $this->middleware('auth', ['only' => ['create', 'store']]);

        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getTemplates()
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
    public function makeTemplate()
    {
        $tags = Tag::all();

        return view('template.create')->with(compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function saveTemplate(CreateTemplateRequest $request)
    {
        $input = $request->input();

        $input['price'] = round($input['price']);

        $input['price_multiple'] = round($request->get('price_multiple'));

        $input['price_extended'] = round($request->get('price_extended'));

        if(!empty($input['frameworks']))

            $input['frameworks'] = implode(", ", $input['frameworks']);

        if(!empty($input['browser']))

            $input['browser'] = implode(", ", $input['browser']);

        if(!empty($input['build_tools']))

            $input['build_tools'] = implode(", ", $input['build_tools']);

        // Handle Image
        $image_path = $request->file('screenshot')->getRealPath();

        $imageData = array(
            'image' => $image_path,
            'type'  => 'file'
        );

        $basic = Imgur::api('image')->upload($imageData);

        //parse response
        $resp = $basic->getData();

        $input['screenshot'] = $resp['link'];

        $fileDestination = 'templates/' 
                            . Auth::id() 
                            . '-' . Auth::user()->templates()->count()
                            . '-' . $request->file('files')->getClientOriginalName();

        $this->storage->put($fileDestination, $request->file('files')->getRealPath());     

        $input['files_url'] = $fileDestination;

        $template = new Template($input);

        Auth::user()->templates()->save($template);

        $data = [
            'template'      => $template,
            'amount'        => $template->price,
            'license_type'  => 'single'
        ];

        return redirect()->action('TemplateController@getTemplate', $data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getTemplate($id, Request $request)
    {
        $template = Template::findOrFail($id);

        $license_type = $request->get('license_type') ?: 'single';

        if($license_type == 'single') {

            $amount = $template->price;
        }
        elseif($license_type == 'multiple') {

            $amount = $template->price * 4;
        }
        elseif($license_type == 'extended') {

            $amount = "80.00";
        }

        $data = [
            'template'      => $template,
            'amount'        => $amount,
            'license_type'  => $license_type,
            'author'        => User::find($template->user_id)
        ];

        return view('template.show', compact('data'));
    }

    /**
     * index
     * 
     * @return get all templates
     */     
    public function index()
    {
        $templates = Template::with('user')
                                ->with('orders')
                                ->latest()->get();

        return view('admin.templates.index', compact('templates'));
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

        $fileUrl = $this->storage->getTempUrl($template->files_url);

        return view('admin.templates.show')->with([
                'template'  => $template,
                'files'     => $fileUrl
            ]);

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

    public function templateActions($id, Request $request)
    {
        $template = Template::findOrFail($id);

        $input = $request->input();

        $template->approved = !empty($input['approved']) ? true : false;

        $template->rejected = !empty($input['rejected']) ? true : false;

        $template->disabled = !empty($input['disabled']) ? true : false;

        $template->save();

        return back()->with('status', "Template Updated");
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
