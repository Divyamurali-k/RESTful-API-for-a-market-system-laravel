<?php

namespace App\Http\Controllers\Buyer;
use App\Models\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only(['index']);
        $this->middleware('can:view,buyer')->only(['show']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->allowedAdminAction();
        $buyers= Buyer:: has('transactions')->get();
        // return response()->json(['data' => $buyers], 200);
        return $this->showAll($buyers);
    }

   

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        // $buyer= Buyer:: has('transactions')->findOrFail($id);
        return $this->showOne($buyer);
    }

   
}
