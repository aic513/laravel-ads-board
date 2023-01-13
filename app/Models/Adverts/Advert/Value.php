<?php

namespace App\Models\Adverts\Advert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Adverts\Advert\Value
 *
 * @property int $attribute_id
 * @property string $value
 * @property int $advert_id
 * @method static \Illuminate\Database\Eloquent\Builder|Value newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Value newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Value query()
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereValue($value)
 * @mixin \Eloquent
 */
class Value extends Model
{
    use HasFactory;

    protected $table = 'advert_advert_values';

    public $timestamps = false;

    protected $fillable = ['attribute_id', 'value'];
}