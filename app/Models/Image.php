<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['parameter_id', 'type', 'filename', 'original_filename'];

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
