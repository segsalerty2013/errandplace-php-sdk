<?php

namespace Errandplace;

use Errandplace\data\ZoneObject;
use Errandplace\Util;
use Errandplace\Config;

class Zone{
    
    /**
     * Adds a new zone to the designated partner
     * @param Config $config
     * @param ZoneObject $zone
     * @param type $token Access token of the partner
     * @return type
     */
    public static function add(Config $config, ZoneObject $zone, $token=null){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('POST', '/vendor/zone', [
            'json' => $zone->getPayload(),
            'headers'=>[
                'token' => $token
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == 201?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    /**
     * Update a zone by its id. ZoneObject needs to be setId()
     * @param Config $config
     * @param ZoneObject $zone
     * @param type $token
     * @return type
     */
    public static function update(Config $config, ZoneObject $zone, $token=null){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('PUT', '/vendor/zone/'.$zone->getId().'/edit', [
            'json' => $zone->getPayload(),
            'headers'=>[
                'token' => $token
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }

    /**
     * Get a zone by its ID
     * @param Config $config
     * @param type $id
     */
    public static function get(Config $config, $id){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('GET', '/zone/'.$id)->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }

    /**
     * Do a lookup of zones stored, search, sort them accordingly. Results are paginated
     * @param Config $config
     * @param type $keyword
     * @param type $page
     * @param type $ordering
     * @param type $token
     * @param type $system
     */
    public static function search(Config $config, $keyword=null, $page=null, 
            $ordering=null, $token=null, $system=null){
        $pageNum = $page? $page : '1';
        $sort_by = $ordering ? $ordering : 'createdAt desc';
        $api_query = "?page=".$pageNum."&sort=".$sort_by;
        if($keyword){$api_query.='&keyword='.$keyword;}
        
        $client = Util::getClient($config);
        if($token){
            $command = $client->request('POST', '/vendor/zones'.$api_query, [
                'headers'=>[
                    'token' => $token
                ]
            ]);
        }
        else{
            $command = $client->request('POST', '/zone/search'.$api_query, [
                'headers'=>[
                    'system'=>$system
                ]
            ]);
        }
        $body = json_decode($command->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
}