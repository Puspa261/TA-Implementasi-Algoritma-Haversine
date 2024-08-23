<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pegawai()
    {
        return $this->hasMany(User::class, 'id', 'id_pegawai');
    }

    public function scopeRangeFrom($query, $latitude, $longitude)
    {
        // Rumus Haversine dalam SQL
        $lat1 = "RADIANS($latitude)";
        $long1 = "RADIANS($longitude)";

        $lat2 = "RADIANS(latitude)";
        $long2 = "RADIANS(longitude)";

        $deltaLat = "($lat2 - $lat1)";
        $deltaLong = "($long2 - $long1)";

        $a = "SIN($deltaLat / 2) * SIN($deltaLat / 2) +
              COS(($lat1)) * COS(($lat2)) * 
              SIN($deltaLong / 2) * SIN($deltaLong / 2)";

        $c = "2 * ATAN2 (SQRT($a), SQRT(1-$a))";

        // $haversineFormula = "(6371 * $c)";

        $haversineFormula = "ROUND(6371 * $c, 2)";

        return $query->select('*')
            // ->selectRaw("{$lat1} AS lat1")
            // ->selectRaw("{$long1} AS long1")
            // ->selectRaw("{$lat2} AS lat2")
            // ->selectRaw("{$long2} AS long2")
            // ->selectRaw("{$deltaLat} AS deltaLat")
            // ->selectRaw("{$deltaLong} AS deltaLong")
            // ->selectRaw("{$a} AS a")
            // ->selectRaw("{$c} AS c")
            ->selectRaw("{$haversineFormula} AS jarak");
        // ->orderBy('jarak');
    }
}
