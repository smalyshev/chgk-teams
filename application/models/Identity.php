<?php
class Reg2_Model_Identity 
{
    public $role;
    public $data;
    function __construct($role, $data = null) {
        $this->role = $role;
        $this->data = $data;
    }
    
}
