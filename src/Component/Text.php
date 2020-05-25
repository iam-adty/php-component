<?php namespace IamAdty\Component;

use IamAdty\Component;

class Text extends Component
{
    private $value = "";

    public function __construct($value = "")
    {
        $this->value = $value;
    }

    public function compile()
    {
        return $this->value;
    }

    public function value()
    {
        return $this->value();
    }

    public static function write($value = "")
    {
        return new self($value);
    }
}
