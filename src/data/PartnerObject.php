<?php

namespace Errandplace\data;

class PartnerObject extends DataObject{
    
    public $name;
    public $business_name;
    public $desciption;
    public $logo;
    public $country;
    public $email;
    public $phone;
    public $insurance;
    public $visibility;
    public $module;
    public $measurement;
    
    protected $zones;
    
    public function getZones() {
        return $this->zones;
    }
}

