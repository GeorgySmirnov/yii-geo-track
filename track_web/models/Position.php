<?php

namespace app\models;

use yii\db\ActiveRecord;

class Position extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%position}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'time', 'longitude', 'latitude'], 'required'],
            [
                'time',
                'datetime',
                'timestampAttribute' => 'time',
                'timestampAttributeFormat' => 'yyyy-MM-dd HH:mm:ss'
            ],
            ['longitude', 'double', 'min' => -180, 'max' => 180],
            ['latitude', 'double', 'min' => -90, 'max' => 90],
        ];
    }

    public function setIsoTime(string $newTime): void
    {
        $this->time = $newTime;
    }

    public function getIsoTime(): string
    {
        return \Yii::$app->formatter->asDatetime($this->time);
    }

    public function getDistanceToYekaterinburg(): float
    {
        $cityLat = 56.8575;
        $cityLon = 60.6125;

        return $this->haversine($cityLat, $this->latitude, $cityLon, $this->longitude);
    }


    /*
     * Calculate distance betwen two points on Earth
     * using haversine formula.
     */ 
    private function haversine(float $lat1, float $lat2, float $lon1, float $lon2): float
    {
        // Earth radius in meters
        $earthRadius = 6371008;

        // deltas of latitude/longitude in radians
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        // apply haversine formula
        $havLat = sin($dLat/2) * sin($dLat/2);
        $havLon = sin($dLon/2) * sin($dLon/2);
        $h = $havLat + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * $havLon;
        $radianDistance = 2 * asin(sqrt($h));
        $distance = $earthRadius * $radianDistance;
	
        return $distance;
    }
}
