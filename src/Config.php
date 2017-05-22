<?php

namespace Errandplace;

class Config{
    
    private $endpoint;
    
    public function __construct($endp="http://localhost;1337/api") {
        $this->endpoint = $endp;
    }
    
    function getEndpoint() {
        return $this->endpoint;
    }
}