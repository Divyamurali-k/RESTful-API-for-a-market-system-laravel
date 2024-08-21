<?php

namespace App\Models;
use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'users';
    protected $dates=['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
