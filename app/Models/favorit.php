<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorit extends Model
{
    use HasFactory;

    protected $table = "favorit";
    protected $primaryKey = 'id_favorit';

    protected $fillable = [
        'wisatawan_id',
        'destination_id'
    ];

    public function wisatawan()
    {
        return $this->belongsTo(Wisatawan::class, 'wisatawan_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class,'destination_id');
    }
}
