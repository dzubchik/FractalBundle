<?php

namespace Paymaxi\FractalBundle;

use Doctrine\Common\Util\ClassUtils;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;
use Paymaxi\FractalBundle\Resolver\ResolverInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ContainerAwareManager
 *
 * @package Paymaxi\FractalBundle
 */
class ContainerAwareManager extends Manager implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Create Data.
     *
     * Main method to kick this all off. Make a resource then pass it over, and use toArray()
     *
     * @param ResourceInterface $resource
     * @param string            $scopeIdentifier
     * @param Scope             $parentScopeInstance
     *
     * @return Scope
     */
    public function createData(ResourceInterface $resource, $scopeIdentifier = null, Scope $parentScopeInstance = null)
    {
        $this->resolveTransformer($resource);
        $scopeInstance = new Scope($this, $resource, $scopeIdentifier);

        // Update scope history
        if ($parentScopeInstance !== null) {
            // This will be the new children list of parents (parents parents, plus the parent)
            $scopeArray = $parentScopeInstance->getParentScopes();
            $scopeArray[] = $parentScopeInstance->getScopeIdentifier();

            $scopeInstance->setParentScopes($scopeArray);
        }

        return $scopeInstance;
    }

    /**
     * @param ResourceInterface $resource
     */
    private function resolveTransformer(ResourceInterface $resource)
    {
        $resourceTransformer = $resource->getTransformer();

        if ($resourceTransformer instanceof TransformerAbstract) {
            return;
        }

        $serviceRegistry = $this->container->get('fractal.transformer.resolvers');

        if ($resource instanceof Item) {
            $instance = ClassUtils::getRealClass(get_class($resource->getData()));
        } elseif ($resource instanceof Collection) {
            $instance = ClassUtils::getRealClass(get_class($resource->getData()[0]));
        } else {
            return;
        }

        /** @var ResolverInterface $resolver */
        foreach ($serviceRegistry->all() as $resolver) {
            if ($resolver instanceof ContainerAwareInterface) {
                $resolver->setContainer($this->container);
            }

            if ($resolver->supports($instance, $resourceTransformer)) {
                $transformer = $resolver->resolve($instance, $resourceTransformer);
                $resource->setTransformer($transformer);
                continue;
            }
        }
    }
}
