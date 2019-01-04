<?php

namespace App\Http\Controllers;


class GraphController extends Controller
{

    /**
     * Show the  graph.
     *
     * @param string $uuid
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function graph()
    {
        return response()->json([
                'data' => [
                    'total' => [
                        [ "timestamp" => "2018-12-20T11:52:57Z" ,"total" => 500 ],
                        [ "timestamp" => "2018-11-20T11:52:57Z" ,"total" => 320 ],
                        [ "timestamp" => "2018-10-20T11:52:57Z" ,"total" => 100 ],
                    ]  
                ] 
        ]);
    }
    public function index(){
        return view('welcome');
    }

}
