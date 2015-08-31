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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
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
            'license_type'  => $license_type
        ];

        return view('template.show', compact('data'));
    }

    public function testTempUrl($id)
    {
        // $client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
        //     'username' => getenv('RACKSPACE_USERNAME'),
        //     'apiKey'   => getenv('RACKSPACE_KEY')
        // ));

        // $objectStoreService = $client->objectStoreService(null, 'IAD');

        // $container = $objectStoreService->getContainer('bd-files');

        // $template = Template::find($id);

        // $object = $container->getObject($template->files_url);

        // $account = $objectStoreService->getAccount();

        // $account->setTempUrlSecret();

        // // Get a temporary URL that will expire in 3600 seconds (1 hour) from now
        // // and only allow GET HTTP requests to it.
        // $tempUrl = $object->getTemporaryUrl(3600, 'GET');

        $template = Template::findOrFail($id);

        return $this->stroage->getTempUrl($template->files_url);

        //return $tempUrl;
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
