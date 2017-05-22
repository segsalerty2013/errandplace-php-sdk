<?php

namespace Errandplace\data;

class PartnerObject{
    
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
    
    /*
     * cannot be set but get only
     */
    private $id;
    private $zones;
    
    /**
     * Load properties of the class from an array
     * @param type $arr
     */
    public function load($arr){
        foreach($arr as $key=>$value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }
    
    /**
     * Use this to get array of data body to push to api
     * @return type array
     */
    public function getPayload(){
        $ret = [];
        $arr = get_object_vars($this);
        foreach ($arr as $key=>$value){
            if($value){
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
    
    public function getZones() {
        return $this->zones;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}

