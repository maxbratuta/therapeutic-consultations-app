<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Consultation
 *
 * @property integer $id
 * @property integer $user_id
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consultation whereUserId($value)
 * @mixin \Eloquent
 */
class Consultation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'start_at',
        'end_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    /**
     * Relation to user.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
