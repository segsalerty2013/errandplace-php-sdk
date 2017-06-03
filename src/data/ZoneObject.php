<?php

namespace Errandplace\data;

class ZoneObject extends DataObject{
    
    public $name;
    public $description;
    public $enabled;
    public $mode; //enum values accepted pickup or drop
    public $vendor;
    
    protected $pricing;
    protected $routes;
    
    public function getPricing() {
        return $this->pricing;
    }

    public function getRoutes() {
        return $this->routes;
    }
    
}