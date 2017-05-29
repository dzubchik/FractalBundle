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
     * @return bool
     *
     */
    public function supports(string $class)
    {
        return $this->container->has($class);
    }

    /**
     * @param string $class
     *
     * @return TransformerAbstract|object
     *
     */
    public function resolve(string $class)
    {
        return $this->container->get($class);
    }
}