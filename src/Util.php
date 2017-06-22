<?php

namespace Errandplace;
use GuzzleHttp\Client;

class Util{
    
    public static function getClient(Config $config){
        return new Client([
            'base_uri'=>$config->getEndpoint(),
            'allow_redirects'=>true,
            'timeout'=>30 //30 seconds
        ]);
    }
    
    /**
     * This function checks the availability of a business name if it is 
     * available for use or taken
     * @param \Errandplace\Config $config
     * @param type $name The business name to check its availability
     */
    public static function namecheck(Config $config, $name){
        $client = self::getClient($config);   
        $body = json_decode($client->request('POST', '/vendor/name/check', ['json' => ['name' => $name]])->getBody()->getContents());
        return (object)['status'=>$body->code=='00'?true:false, 'message'=>$body->message];
    }
    
    public static function states(Config $config, $country='nigeria'){
        $client = self::getClient($config);   
        $body = json_decode($client->request('GET', '/location/'.$country.'/states')->getBody()->getContents());
        return (object)['status'=>$body->code=='00'?true:false, 'message'=>$body->message, 
            'data'=> array_combine($body->data, $body->data)];
    }
    
    /**
     * Search for areas recognized in our system
     * @param \Errandplace\Config $config
     * @param type $keyword
     * @param type $country
     * @return type
     */
    public static function locationLookup(Config $config, $keyword="", $country='nigeria'){
        $client = self::getClient($config);   
        $body = json_decode($client->request('GET', '/routes/match?country='.$country.'&keyword='.$keyword)->getBody()->getContents());
        return (object)['status'=>$body->code=='00'?true:false, 'message'=>$body->message, 
            'data'=> $body->data];
    }
}