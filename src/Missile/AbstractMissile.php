<?php

namespace Doomsday\Missile;

abstract class AbstractMissile
{
    protected $name;

    protected $precision;

    protected $damage;

    public function willHit(){
        return mt_rand(1,100) <= $this->precision;
    }

    public function getDamage(){
        return $this->damage;
    }
}