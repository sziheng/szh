<?php

namespace Bedrock\Models;

class Category extends Model
{
    protected $table = "ims_weshop_category";

    public $timestamps = false;

    public function list()
    {
        return $this->where('level', '=', '1')->get();
    }
}
