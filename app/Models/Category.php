<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    
    public $transformer = CategoryTransformer::class;
    protected $dates=['deleted_at'];

    protected $fillable=[
        'name',
        'description',
    ];

    protected $hidden=[
        'pivot'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
