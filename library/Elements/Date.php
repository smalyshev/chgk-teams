<?php
class Reg2_Form_Element_Date extends Zend_Form_Element_Xhtml
{
    protected $_dateFormat = '%year%-%month%-%day%';
    protected $_day;
    protected $_month;
    protected $_year;

    public function setDay($value)
    {
        $this->_day = (int) $value;
        return $this;
    }

    public function getDay()
    {
        return $this->_day;
    }

    public function setMonth($value)
    {
        $this->_month = (int) $value;
        return $this;
    }

    public function getMonth()
    {
        return $this->_month;
    }

    public function setYear($value)
    {
        $this->_year = (int) $value;
        return $this;
    }

    public function getYear()
    {
        return $this->_year;
    }

    public function setValue($value)
    {
        if (is_int($value)) {
            $this->setDay(date('d', $value))
                 ->setMonth(date('m', $value))
                 ->setYear(date('Y', $value));
        } elseif (is_string($value)) {
            $date = strtotime($value);
            $this->setDay(date('d', $date))
                 ->setMonth(date('m', $date))
                 ->setYear(date('Y', $date));
        } elseif (is_array($value)
            && (isset($value['day'])
                && isset($value['month'])
                && isset($value['year'])
            )
        ) {
            $this->setDay($value['day'])
                 ->setMonth($value['month'])
                 ->setYear($value['year']);
        } else {
            throw new Exception('Invalid date value provided');
        }

        return $this;
    }

    public function getValue()
    {
        return str_replace(
            array('%year%', '%month%', '%day%'),
            array($this->getYear(), sprintf("%02d", $this->getMonth()),
            	 sprintf("%02d", $this->getDay())),
            $this->_dateFormat
        );
    }
}