<?php

namespace App\Models\Adverts\Advert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Adverts\Advert\Photo
 *
 * @property int $id
 * @property string file
 * @property int $advert_id
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @mixin \Eloquent
 * @property string $file
 */
class Photo extends Model
{
    use HasFactory;

    protected $table = 'advert_advert_photos';

    public $timestamps = false;

    protected $fillable = ['file'];
}