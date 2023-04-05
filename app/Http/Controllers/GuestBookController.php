<?php

namespace App\Http\Controllers;

use App\Models\GuestBooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use mysql_xdevapi\Exception;

class GuestBookController extends Controller
{
    /**
     * Controller Config
     */
    private $cacheTTL;
    private $context;

    public function __construct()
    {
    	$this->cacheTTL = 3600;
    	$this->context = 'guest';
    }

    /**
     * Display a listing of the Guest Book Data.
     * with GET Method
     * via API Routes : /guest-book
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Cache::remember($this->context, $this->cacheTTL, function () {
                return GuestBooks::all();
            });
            return response()->json([
                    "result" => $data,
                    "message" => "Data Retrieved",
                    "error" => false,
                    "code" => 200
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                    "result" => null,
                    "message" => $e->getMessage(),
                    "error" => true,
                    "code" => 500
                ]
            );
        }
    }

    /**
     * Store a newly created Guest Book Data in storage.
     * with POST Method
     * via API Routes : /guest-book
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|min:3',
            'email' => 'required|email',
            'address' => 'required|string|min:4',
            'message' => 'string'
        ]);

        try {
            $data = array(
                'fullName' => $request->fullName,
                'email' => $request->email,
                'address' => $request->address,
                'message' => $request->message
            );
            $result = GuestBooks::create($data);
            return response()->json([
                    "result" => $result,
                    "message" => "Data Saved",
                    "error" => false,
                    "code" => 201
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                    "result" => "Failed to Create Data",
                    "message" => $e->getMessage(),
                    "error" => true,
                    "code" => 500
                ]
            );
        }
    }

    /**
     * Display the specified Guest Book Data.
     * with GET Method
     * via API Routes : /guest-book/{id}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return response()->json([
                    "result" => GuestBooks::find($id),
                    "message" => "Data Retrieved",
                    "error" => false,
                    "code" => 200
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                    "result" => null,
                    "message" => $e->getMessage(),
                    "error" => true,
                    "code" => 500
                ]
            );
        }
    }

    /**
     * Update the specified resource in Guest Book.
     * with PUT Method
     * via API Routes : /guest-book/{id}
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fullName' => 'string',
            'email' => 'email',
            'address' => 'string',
            'message' => 'string'
        ]);

        try {
            $data = array(
                'fullName' => $request->fullName,
                'email' => $request->email,
                'address' => $request->address,
                'message' => $request->message
            );
            $result = GuestBooks::where('_id', $id)->update($data);
            if ($result) {
                return response()->json([
                        "result" => GuestBooks::find($id),
                        "message" => "Data Updated",
                        "error" => false,
                        "code" => 200
                    ]
                );
            } else {
                return response()->json([
                        "result" => GuestBooks::find($id),
                        "message" => "Data Failed to Update",
                        "error" => false,
                        "code" => 304
                    ]
                );
            }
        } catch (\Exception $e) {
            return response()->json([
                    "result" => "Failed to Update Data",
                    "message" => $e->getMessage(),
                    "error" => true,
                    "code" => 500
                ]
            );
        }
    }

    /**
     * Remove the specified resource from Guest Book.
     * with DELETE Method
     * via API Routes : /guest-book/{id}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = GuestBooks::find($id);
        $isDestroyed = GuestBooks::destroy($id);
        if ($isDestroyed) {
            return response()->json([
                    "result" => $data,
                    "message" => "Data Destroyed",
                    "error" => false,
                    "code" => 200
                ]
            );
        } else {
            return response()->json([
                    "result" => $data,
                    "message" => "Failed to Destroy Data",
                    "error" => false,
                    "code" => 200
                ]
            );
        }
    }
}
