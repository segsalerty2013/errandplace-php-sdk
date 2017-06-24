<?php

namespace Errandplace;

use Errandplace\Util;
use Errandplace\data\LogisticObject;

class Errand{
    
    /**
     * Example of payload commented below
     * @param \Errandplace\Config $config
     * @param type $payload 
     * @param type $channel
     * @return type
     */
    public static function query(Config $config, $payload, $channel='php-sdk'){
        $client = Util::getClient($config);
        $payload['channel'] = $channel;
        $body = json_decode($client->request('POST', '/logistics/query', [
            'json' => $payload
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 
            'data'=>isset($body->data->ref)?$body->data->ref:null];    
    }
    
    public static function queryFeedback(Config $config, $payload, $channel='php-sdk'){
        $client = Util::getClient($config);
        $payload['channel'] = $channel;
        $payload['respond'] = true;
        $body = json_decode($client->request('POST', '/logistics/query', [
            'json' => $payload
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 
            'data'=>isset($body->data)?$body->data:null];    
    }
    
    public static function pull(Config $config, $id){
        $client = Util::getClient($config);
        $body = json_decode($client->request('GET', '/logistics/pull/'.$id)->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    public static function push(Config $config, LogisticObject $logisticsObj){
        $client = Util::getClient($config);
        $body = json_decode($client->request('PUT', '/logistics/push/'.$logisticsObj->getId(), [
            'json' => $logisticsObj->getPayload()
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 
            'data'=>isset($body->data)?$body->data:null];  
    }
    
    public static function logTracking(Config $config, $tracking, $system=null, $payload=[]){
        $client = Util::getClient($config);
        $body = json_decode($client->request('PUT', '/logistics/tracking/add/'.$tracking, [
            'json' => $payload,
            'headers'=>[
                'system'=>$system
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 
            'data'=>isset($body->data)?$body->data:null];
    }
    
    public static function adminUpdate(Config $config, $tracking, $system=null, $payload=[]){
        $client = Util::getClient($config);
        $body = json_decode($client->request('PUT', '/logistics/tracking/admin/'.$tracking, [
            'json' => $payload,
            'headers'=>[
                'system'=>$system
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 
            'data'=>isset($body->data)?$body->data:null];
    }

    public static function update(Config $config, LogisticObject $logisticsObj, $system=null){
        $client = Util::getClient($config);
        $body = json_decode($client->request('PUT', '/logistics/update/'.$logisticsObj->getId(), [
            'json' => $logisticsObj->getPayload(),
            'headers'=>[
                'system'=>$system
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 
            'data'=>isset($body->data)?$body->data:null];  
    }
    
    public static function search(Config $config, $keyword=null, $page=null, 
            $ordering=null, $token=null, $system=null){
        $pageNum = $page? $page : '1';
        $sort_by = $ordering ? $ordering : 'createdAt desc';
        $api_query = "?page=".$pageNum."&sort=".$sort_by;
        if($keyword){$api_query.='&keyword='.$keyword;}
        
        $client = Util::getClient($config);
        if($token){
            $command = $client->request('POST', '/vendor/logistics'.$api_query, [
                'headers'=>[
                    'token' => $token
                ]
            ]);
        }
        else{
            $command = $client->request('POST', '/logistics'.$api_query, [
                'headers'=>[
                    'system'=>$system
                ]
            ]);
        }
        $body = json_decode($command->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
}

