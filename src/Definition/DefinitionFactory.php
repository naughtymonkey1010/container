<?php

namespace League\Container\Definition;

use League\Container\ImmutableContainerAwareInterface;
use League\Container\ImmutableContainerAwareTrait;

class DefinitionFactory implements DefinitionFactoryInterface, ImmutableContainerAwareInterface
{
    use ImmutableContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getDefinition($alias, $concrete)
    {
        if (is_callable($concrete)) {
            return (new CallableDefinition($alias, $concrete))->setContainer($this->container);
        }

        if (is_string($concrete) && class_exists($concrete)) {
            return (new ClassDefinition($alias, $concrete, $this->container))->setContainer($this->container);
        }

        // if the item is not defineable we just return the value to be stored
        // in the container as an arbitrary value/instance
        return $concrete;
    }
}
