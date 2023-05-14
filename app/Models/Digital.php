<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digital extends Model{
    use HasFactory;
    protected $table = "digital";
    protected $primaryKey = "id_digital";
    protected $incrementing = false;
    protected $keyType = 'string';
    protected $timestamps = false;
    protected $fillable = [
        // '',

    ];
    protected $hidden = [
        // ""
    ];
    protected $casts = [
        // ''
    ];
} 
?>