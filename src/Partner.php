<?php

namespace Errandplace;

use Errandplace\data\PartnerObject;
use Errandplace\Util;
use Errandplace\Config;

class Partner{
    
    public static function register(Config $config, PartnerObject $partner){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('POST', '/vendor', ['json' => $partner->getPayload()])->getBody()->getContents());
        return (object)['status'=>$body->code == 201?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    public static function update(Config $config, PartnerObject $partner, $token){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('PUT', '/vendor/'.$partner->getId(), [
            'json' => $partner->getPayload(),
            'headers' => [
                'token' => $token
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    public static function toggleApproval(Config $config, $partner_id, $system){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('PUT', '/vendor/approval/toggle/'.$partner_id, [
            'headers' => [
                'system' => $system
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 'data'=>$body->data->approved];    
    }
    
    public static function resetAccesses(Config $config, $partner_id, $system){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('PUT', '/vendor/token/'.$partner_id, [
            'headers' => [
                'system' => $system
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 'data'=>$body->data->token];    
    }
}

