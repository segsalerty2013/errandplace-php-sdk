<?php

namespace Errandplace\data;

class DataObject{
    
    protected $id;
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
            if($value !== null){
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}