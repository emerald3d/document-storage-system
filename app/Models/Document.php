<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Document extends Model
{
    use Sortable, HasFactory, SoftDeletes;

    const PAGINATE_NUMBER = 8;

    public static function getPaginateNumber(): int
    {
        return static::PAGINATE_NUMBER;
    }

    protected $table = 'documents';
    protected $fillable = ['name', 'user_id', 'file_name', 'file_path'];
    public $sortable = ['name', 'updated_at', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
