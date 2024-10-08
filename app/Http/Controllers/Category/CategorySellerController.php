<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorySellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $this->allowedAdminAction();
        $sellers=$category->products()
        ->with('seller')
        ->get()
        ->pluck('seller')
        ->unique()
        ->values();

        return $this->showAll($sellers);
    }

}
