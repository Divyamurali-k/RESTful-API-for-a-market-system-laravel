<?php

namespace App\Models;
use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'users';
    protected $dates=['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
