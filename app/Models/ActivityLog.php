<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Disable updated_at since logs are immutable history usually, but schema has default timestamp behavior? 
    // Schema says: created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP. No updated_at in schema for this table explicitly mentioned as required but standard migrations usage implies timestamps() which adds both. 
    // Wait, my migration used $table->timestamp('created_at')->useCurrent(); and no timestamps(); so only created_at exists.
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
