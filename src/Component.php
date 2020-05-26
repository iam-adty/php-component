<?php namespace IamAdty;

use IamAdty\Config\ConfigCollectionTrait;
use IamAdty\Variable\Rule\GroupArrayToType;

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
                \string::class
            ],
            'config' => Config::class
        ];
    }

    public function __construct(...$params)
    {
        $params = Variable::from($params)->filter(
            GroupArrayToType::create($this->paramType())
        )->result();

        // d($params);

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
