<?php

class Ride
{
    public $distance;
    public $cabtype;
    public $luggage;
    public function __construct($distance, $cabtype, $luggage)
    {
        $this->distance = $distance;
        $this->cabtype = $cabtype;
        $this->luggage = $luggage;
    }

    public function cabtypeFare()
    {
        switch ($this->cabtype) {
            case 'CedMicro':
                return ['baseFare' => 50, 'distance1' => 13.5, 'distance2' => 12, 'distance3' => 10.2, 'distance4' => 8.5];
            case 'CedMini':
                return ['baseFare' => 150, 'distance1' => 14.5, 'distance2' => 13, 'distance3' => 11.2, 'distance4' => 9.5];
            case 'CedRoyal':
                return ['baseFare' => 200, 'distance1' => 15.5, 'distance2' => 14, 'distance3' => 12.2, 'distance4' => 10.5];
            case 'CedSUV':
                return ['baseFare' => 250, 'distance1' => 16.5, 'distance2' => 15, 'distance3' => 13.2, 'distance4' => 11.5];
        }
    }

    public function luggageFare()
    {
        $fare = 0;
        if ($this->cabtype == 'CedMicro') {
            return $fare;
        } else if ($this->luggage <= 0) {
            return $fare;
        } else {
            if ($this->luggage <= 10) {
                $fare = 50;
            } elseif ($this->luggage <= 20) {
                $fare = 100;
            } else {
                $fare = 200;
            }

            if ($this->cabtype == 'CedSUV') {
                return 2 * $fare;
            }
            return $fare;
        }
    }

    public function distanceFare($charges)
    {
        $fare = 0;
        if ($this->distance == 0) {
            return $fare;
        }

        $fare = $charges['baseFare'];
        $distance = $this->distance;
        if ($distance <= 10) {
            $fare += ($distance * $charges['distance1']);
            return $fare;
        }
        $distance -= 10;
        $fare += (10 * $charges['distance1']);
        if ($distance <= 50) {
            $fare += ($distance * $charges['distance2']);
            return $fare;
        }
        $distance -= 50;
        $fare += (50 * $charges['distance2']);
        if ($distance <= 100) {
            $fare += ($distance * $charges['distance3']);
            return $fare;
        }
        $distance -= 100;
        $fare += (100 * $charges['distance3']);
        $fare += ($distance * $charges['distance4']);
        return $fare;
    }
}
