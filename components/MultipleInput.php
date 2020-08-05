<?php


namespace app\components;


class MultipleInput extends \unclead\multipleinput\MultipleInput
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->iconSource = 'fa';
    }
}