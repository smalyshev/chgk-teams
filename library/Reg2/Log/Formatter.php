<?php

class Reg2_Log_Formatter extends Zend_Log_Formatter_Simple
{
   /**
     * Formats data into a single line to be written by the writer.
     *
     * @param  array    $event    event data
     * @return string             formatted line to write to the log
     */
    public function format($event)
    {
        $event["timestamp"] = date("Y-m-d H:i:s");
        if(Zend_Registry::isRegistered('role')) {
            $role = Zend_Registry::get('role');
        } else {
            $role = "-";
        }
        $event["role"] = $role;

        return parent::format($event).PHP_EOL;
    }
}
