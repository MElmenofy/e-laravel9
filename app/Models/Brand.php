<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];
    protected $fillable = ['is_active','photo'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatedAttributes = ['name'];

    public  function getActive(){
        return $this->is_active == 0 ? __('DeActive') : __('Active');
    }

    public function getPhotoAttribute($value){
        return ($value !== null) ?  asset('assets/images/brands/'.$value) : '';
    }

}
