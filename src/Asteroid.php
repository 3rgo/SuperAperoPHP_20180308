<?php

namespace Doomsday;

class Asteroid
{
    protected $hp;

    function __construct()
    {
        $this->hp = 10000;
    }

    public function sendMissile (Missile\AbstractMissile $missile){
        if($missile->willHit()){
            $this->hp -= $missile->getDamage();
            return true;
        } else {
            $this->hp = round($this->hp * 1.1);
            return false;
        }
    }

    public function getHp(){
        return $this->hp;
    }

    public function isKo(){
        return $this->hp <= 0;
    }
}