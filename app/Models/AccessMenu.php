<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessMenu extends Model
{
    protected $table = 'access_menu';
    protected $fillable = ['name'];

    public function userHasMenu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserHasMenu::class, 'id', 'access_menu_id');
    }
}
