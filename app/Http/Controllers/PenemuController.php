<?php

namespace App\Http\Controllers;
use App\Models\Penemu;
use Illuminate\Http\Request;

class PenemuController extends Controller
{

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penemu = Penemu::all();

        return response()->json(['data'=>$penemu],200);
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
        try{
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'author' => 'required|string|max:255',
            // 'image' => 'required|string',
        ]);


        $data = [
          'title'=>$request->title,
          'body'=>$request->body,
          'author'=>$request->author,
          'user_id'=>auth()->user()->id,
        ];

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique name
            $image->move(public_path('images'), $imageName); // Move the image to public/images directory
            $data['image'] = 'images/' . $imageName;
        }

       $penemu = Penemu::create($data);

        return response()->json(['data'=>$penemu],201);
    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->validator->errors(),
        ], 422);
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
        $penemu = Penemu::find($id);

        return response()->json(['data'=>$penemu],200);
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

        try{
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'author' => 'required|string|max:255',
                // 'image' => 'required|string',
            ]);

            $penemu = Penemu::find($id);

            if(!$penemu){
                return response()->json([
                    'success' => false,
                    'errors' => 'data not found',
                ], 404);
            }


            $data = [
              'title'=>$request->title,
              'body'=>$request->body,
              'author'=>$request->author,
            ];

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique name
                $image->move(public_path('images'), $imageName); // Move the image to public/images directory
                $data['image'] = 'images/' . $imageName;
            }

           $update = $penemu->update($data);

            return response()->json(['data'=>$penemu],201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
            ], 422);
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
       $penemu = Penemu::find($id);

       if(!$penemu){
        return response()->json([
            'success' => false,
            'errors' => 'data not found',
        ], 404);
     }

     $penemu->delete();

     return response()->json(['data'=>null],201);
    }
}