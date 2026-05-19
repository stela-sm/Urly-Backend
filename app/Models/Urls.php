<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['shortcode', 'url'])]
#[Hidden(['id'])]
class Urls extends Model
{
    // Disable automatic Eloquent timestamps since we use custom unsignedInteger created_at
    public $timestamps = false;
}
