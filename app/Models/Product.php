<?php

namespace App\Models;

class Product extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'lista_id',
        'quantity',
        'value',
    ];

    public function lista()
    {
        return $this->belongsTo(Lista::class);
    }
}
