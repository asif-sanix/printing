<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaItem extends Model
{
    use HasFactory;

    protected $fillable = [
	    'id', 'parameter', 'specification', 'result', 'coa_id'
	];
}
