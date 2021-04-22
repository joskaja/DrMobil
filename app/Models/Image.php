<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Image extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'path', 'type'];

    /**
     * Delete image from database and storage
     * @return bool|null
     * @throws Exception
     */
    public function delete(): ?bool
    {
        if(File::exists($this->path)){
           File::delete($this->path);
        }
        return parent::delete();
    }

}
