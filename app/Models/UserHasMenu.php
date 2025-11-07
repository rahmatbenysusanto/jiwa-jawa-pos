<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasMenu extends Model
{
    protected $table = 'user_has_menu';
    protected $fillable = ['user_id', 'access_menu_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accessMenu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccessMenu::class);
    }
}
