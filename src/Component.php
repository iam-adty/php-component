<?php namespace IamAdty;

use IamAdty\Component\Html\Script;
use IamAdty\Config\ConfigCollectionTrait;
use IamAdty\Variable\Rule\GroupArrayToType;
use IamAdty\Variable\Rule\Is\String_;

class Component
{
    protected $children = [];
    protected $config = [];

    use ConfigCollectionTrait;

    protected function paramType()
    {
        return [
            'children' => [
                Component::class,
                String_::class
            ],
            'config' => Config::class
        ];
    }

    public function __construct(...$params)
    {
        $params = Variable::from($params)->filter(
            GroupArrayToType::create($this->paramType())
        )->result();

        foreach ($params as $name => $value) {
            $this->{$name} = $value;
        }

        foreach ($this->config as $config) {
            /** @var Config $config */
            $this->setConfig($config);
        }
    }

    public function compile()
    {
        $result = "";
        foreach ($this->children as $children) {
            if (is_subclass_of($children, Component::class)) {
                $result .= $children->compile();
            } else {
                $result .= $children;
            }
        }
        return $result;
    }

    public function render()
    {
        echo $this->compile();
    }
}
