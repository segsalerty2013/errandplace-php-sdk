<?php

namespace Errandplace\data;

class RouteObject extends DataObject{
    
//    public $from;
//    public $from_state;
    public $from_doorstep;
//    public $to;
//    public $to_state;
    public $to_doorstep;
    public $enabled;
    public $means;
    public $zone;
    
    protected $vendor;

    public function getVendor() {
        return $this->vendor;
    }
    
}