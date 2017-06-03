<?php

namespace Errandplace;

use Errandplace\data\PriceObject;
use Errandplace\Util;
use Errandplace\Config;

class Pricing{
    
    public static function add(Config $config, PriceObject $price, $token){
        $client = Util::getClient($config);
        $body = json_decode($client->request('POST', '/vendor/pricing', [
            'json' => $price->getPayload(),
            'headers' => [
                'token' => $token
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == 201?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    public static function get(Config $config, $id){
        $client = Util::getClient($config);
        $body = json_decode($client->request('GET', '/pricing/'.$id)->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    public static function update(Config $config, PriceObject $price, $token){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('PUT', '/vendor/pricing/'.$price->getId().'/edit', [
            'json' => $price->getPayload(),
            'headers' => [
                'token' => $token
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
    
    public static function search(Config $config, $keyword=null, $page=null, 
            $ordering=null, $token=null, $system=null){
        $pageNum = $page? $page : '1';
        $sort_by = $ordering ? $ordering : 'createdAt desc';
        $api_query = "?page=".$pageNum."&sort=".$sort_by;
        if($keyword){$api_query.='&keyword='.$keyword;}
        
        $client = Util::getClient($config);
        if($token){
            $command = $client->request('POST', '/vendor/pricings'.$api_query, [
                'headers'=>[
                    'token' => $token
                ]
            ]);
        }
        else{
            $command = $client->request('POST', '/pricings'.$api_query, [
                'headers'=>[
                    'system'=>$system
                ]
            ]);
        }
        $body = json_decode($command->getBody()->getContents());
        return (object)['status'=>$body->code == '00'?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
}