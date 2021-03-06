<?php

namespace NLDev\FileUploader\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use NLDev\FileUploader\Traits\HasUuid;

class FileUploaderModel extends Model
{
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_id',
        'file_name',
        'mimetype',
        'extension',
        'size',
        'directory',
        'callable_id',
        'callable_type',
    ];

    public $table = 'files';

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
     * Getters
     */

    /**
     * Show asset path to file
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return asset($this->directory . '/' . $this->file_name);
    }

    /**
     * Show public path to file
     *
     * @return string
     */
    public function getPublicPathAttribute()
    {
        return public_path($this->directory . '/' . $this->file_name);
    }

    public function getFileSizeAttribute($value)
    {
        $size = null;
        if (!$value) {
            if ($this->public_path) {
                if (file_exists($this->public_path)) {
                    $size = $this->formatBytes(fileSize($this->public_path));
                }
            }
        } else {
            $size = $this->formatBytes($value);
        }
        return $size;
    }

    public function getUploadedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function getSizeFormatedAttribute()
    {
        return $this->formatBytes($this->size);
    }

    public function getSizeAttribute($value){
        $size = null;
        if (!$value) {
            if ($this->public_path) {
                if (file_exists($this->public_path)) {
                    $size = fileSize($this->public_path);
                }
            }
        } else {
            $size = $value;
        }
        return $size;
    }

    /**
     * Affiche un lien vers le fichier
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        $icon = $this->getIcon();
        return '<a href="' . $this->path . '" target="_blank" class="has-text-centered">' .
            '<div class="icons">' .
            '<i class="las la-' . $icon['name'] . ' fa-lg has-text-' . $icon['color'] . '"></i>' .
            '</div>' .
            '</a>';
    }

    /**
     * Scopes
     */

    /**
     * Renvoie la taille total des fichiers sur le disque
     *
     * @param mixed $query
     *
     * @return string
     */
    public function scopeTotalDataOnDisk($query): string
    {
        return $this->formatBytes($query->get()->sum('size'));
    }

    /**
     * Helpers
     */

    /**
     * D??termine le type d'icone ?? utiliser
     *
     * @return array
     */
    private function getIcon(): array
    {
        $extension = $this->extension;
        $icons = $this->icons();

        $name = '';
        $color = '';

        foreach ($icons as $icon) {
            if (is_array($icon['type'])) {
                if (in_array($extension, $icon['type'])) {
                    $name = $icon['name'];
                    $color = $icon['color'];
                }
            } else {
                if ($icon['type'] == $extension) {
                    $name = $icon['name'];
                    $color = $icon['color'];
                }
            }
        }

        return compact('name', 'color');
    }

    /**
     * Tableau des icones
     *
     * @return array
     */
    private function icons()
    {
        return [
            ['type' => 'pdf', 'color' => 'danger', 'name' => 'file-pdf'],
            ['type' => ['png', 'jpeg', 'jpg'], 'color' => 'info', 'name' => 'file-image'],
            ['type' => ['doc', 'docx'], 'color' => 'info', 'name' => 'file-word'],
            ['type' => ['xls', 'xlsx'], 'color' => 'success', 'name' => 'file-excel'],
            ['type' => 'csv', 'color' => 'success', 'name' => 'file-csv'],
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
