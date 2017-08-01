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
    public $flat_commision;
    public $flat_commision_amount;
    public $percentage_commision;
    public $percentage_value;
    public $notification_charges_amount;
    public $settlement_bank;
    public $settlement_account;

    protected $zones;
    
    public function getZones() {
        return $this->zones;
    }
}

