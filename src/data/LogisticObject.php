<?php

namespace Errandplace\data;

class LogisticObject extends DataObject{
    
    public $payload;
    public $payment_method;
    public $amount;
    public $total;
    public $email;
    public $phone;

    public $payment_object;
}