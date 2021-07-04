<?php

namespace NLDev\FileSystem\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use NLDev\FileSystem\Traits\HasUuid;

class File extends Model
{
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_id',
        'name',
        'mimetype',
        'extension',
        'size',
        'directory',
        'callable_id',
        'callable_type',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'file_id';

    public function callable()
    {
        return $this->morphTo();
    }

    /**
     * Show file link
     *
     * @return string
     */
    public function getLinkAttribute(){
        return '<a href="'.$this->path.'" target="_blank">'.$this->file_name.'</a>';
    }

    /**
     * Show asset path to file
     *
     * @return string
     */
    public function getPathAttribute(){
        return asset($this->directory.'/'.$this->file_name);
    }

    /**
     * Show public path to file
     *
     * @return string
     */
    public function getPublicPathAttribute(){
        return public_path($this->directory.'/'.$this->file_name);
    }

    /**
     * Show delete form to delete file
     *
     * @return string
     */
    public function getDeleteFormAttribute(){
        return '<form action="'.route('files.destroy', $this).'" method="POST">'.
            csrf_field().''.method_field('DELETE')
                .'<button class="is-link is-danger">delete</button>'.
            '</form><br/>';
    }
}
