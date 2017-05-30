<?php
declare(strict_types=1);

namespace Paymaxi\FractalBundle\Resolver;


use League\Fractal\TransformerAbstract;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ContainerAwareResolver
 *
 * @package Paymaxi\FractalBundle\Resolver
 */
final class ContainerAwareResolver implements ResolverInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param string $class
     *
     * @param $resourceTransformer
     *
     * @return bool
     */
    public function supports(string $class, $resourceTransformer)
    {
        return is_string($resourceTransformer) && $this->container->has($resourceTransformer);
    }

    /**
     * @param string $class
     *
     * @param $resourceTransformer
     *
     * @return TransformerAbstract|object
     */
    public function resolve(string $class, $resourceTransformer)
    {
        return $this->container->get($resourceTransformer);
    }
}