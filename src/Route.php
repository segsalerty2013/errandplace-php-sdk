<?php

namespace Errandplace;

use Errandplace\Util;
use Errandplace\Config;
use Errandplace\data\RouteObject;

class Route{
    
    public static function search(Config $config, $from, $keyword=null, $page=null, 
            $ordering=null, $token=null, $system=null){
        $pageNum = $page? $page : '1';
        $sort_by = $ordering ? $ordering : 'to asc';
        $api_query = "?from=".$from."&page=".$pageNum."&sort=".$sort_by;
        if($keyword){$api_query.='&keyword='.$keyword;}
        
        $client = Util::getClient($config);
        if($token){
            $command = $client->request('POST', '/routes/nigeria'.$api_query, [
                'headers'=>[
                    'token' => $token
                ]
            ]);
        }
        else{
            $command = $client->request('POST', '/routes/nigeria/all'.$api_query, [
                'headers'=>[
                    'system'=>$system
                ]
            ]);
        }
        $body = json_decode($command->getBody()->getContents());
        /**
         * might need to call this endpoint again
         */
        if(isset($body->data->recall)){
            return Route::search($config, $from, $keyword, $page, $ordering, $token, $system);
        }
        else{
            return (object)['status'=>$body->code == '00'?true:false, 'data'=>$body->message, 'data'=>$body->data];
        }
    }
    
    public static function update(Config $config, RouteObject $route, $token){
        $client = Util::getClient($config);   
        $body = json_decode($client->request('PUT', '/routes/'.$route->getId().'/edit', [
            'json' => $route->getPayload(),
            'headers' => [
                'token' => $token
            ]
        ])->getBody()->getContents());
        return (object)['status'=>$body->code == "00"?true:false, 'message'=>$body->message, 'data'=>$body->data];
    }
}