<?php namespace IamAdty\Component;

trait ComponentBuilderTrait
{
    public static function build(...$params)
    {
        return new self(...$params);
    }
}
