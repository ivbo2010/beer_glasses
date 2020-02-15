<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\PubCategory;
use Illuminate\Http\Request;

class PubCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PubCategory::all();
        return view('admin.pubcategory.index', compact('data'));
           // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.pubcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    =>  'required',
            'image'         =>  'image'
        ]);

        $image = $request->file('image');

        if ($image) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
        } else {
            $new_name = '';
        }
        $input_data = array(
            'name'       =>   $request->name,
            'image'            =>   $new_name
        );

        PubCategory::create($input_data);

        return redirect('admin/pubcategory')->with('Success', 'Pub Category Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PubCategory::findOrFail($id);
        return view('admin.pubcategory.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PubCategory::findOrFail($id);
        return view('admin.pubcategory.edit', compact('data'));
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


        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '')  // here is the if part when you dont want to update the image required
        {
            $request->validate([
                'name'    =>  'required',
                'image'         =>  'image'
            ]);

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
        }
        else  // this is the else part when you dont want to update the image not required
        {
            $request->validate([
                'name'    =>  'required',
            ]);
        }

        $input_data = array(
            'name'       =>   $request->name,
            'image'            =>   $image_name
        );

        PubCategory::whereId($id)->update($input_data);

        return redirect('admin/pubcategory')->with('Success', 'Pub Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PubCategory::findOrFail($id);
        $data->delete();

        return redirect('admin/pubcategory')->with('error', 'Pub Category Deleted Successfully ');
    }
}
