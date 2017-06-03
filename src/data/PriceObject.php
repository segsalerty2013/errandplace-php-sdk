<?php

namespace Errandplace\data;

class PriceObject extends DataObject{
    
    public $currency;
    public $amount;
    public $m_lower_bound;
    public $m_upper_bound;
    public $t_lower_bound;
    public $t_upper_bound;
    public $enabled;
    public $vendor;
    public $zone;

}