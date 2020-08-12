<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class BookController extends Controller
{

    public function bookAuth() {
        $data = "Welcome " . Auth::user()->name;
        return response()->json($data, 200);
    }

    public function books()
    {
        $books = Book::all();
        return response()->json(compact('books'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($create_by = "")
    {
        $data = (object)
        [
           'books' => Book::where('create_by',$create_by)->get()
        ];

        return response()->json(compact('data'));
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
        $data = $request->all();

        $validator = Validator::make($data,[
           'name' => 'required',
           'type' => 'required',
           'price' => 'required',
           'stock' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
               'status' => "fail",
                'messages' => $validator->errors()->first(),
            ],400);
        }

        $input = [
          'name' => $data['name'],
          'type' => $data['type'],
          'price' => $data['price'],
          'stock' => $data['stock'],
          'create_by' => Auth::user()->id,
        ];

        Book::firstOrCreate($input);

        return response()->json([
           'status' => 'ok',
           'messages' => 'Berhasil membuat data'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Book::find($id);
        return $data;
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
        $data = $request->all();

        $validator = Validator::make($data,[
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'fail',
               'messages'=> $validator->errors()->first(),
            ],400);
        }

        $input = [
            'name' => $data['name'],
            'type' => $data['type'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'create_by' => Auth::user()->id,
        ];

        Book::find($id)->update($input);

        return response()->json([
            'status' => 'ok',
            'messages' => 'Berhasil update data'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::destroy($id);
        return response()->json([
           'status' => 'ok',
           'messages' => 'Berhasil menghapus data'
        ]);
    }
}
