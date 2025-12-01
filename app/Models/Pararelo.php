<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pararelo extends Model
{
    //

    protected $table = 'pararelos';

    protected $fillable = [
        'nombre',
        'grado_id',
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

}
