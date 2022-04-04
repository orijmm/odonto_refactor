<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name_company',
        'description',
        'address',
        'region',
        'commune',
        'country',
        'phone',
        'email',
        'locale',
        'timezone'
    ];

    /**
     * Get all of the media for settings.
     */
    public function media()
    {
        return $this->morphToMany(Media::class, 'mediable');
    }
}
