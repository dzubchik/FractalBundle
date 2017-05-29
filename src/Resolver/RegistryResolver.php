<?php
declare(strict_types=1);

namespace Paymaxi\FractalBundle\Resolver;

use League\Fractal\TransformerAbstract;
use Sylius\Component\Registry\ServiceRegistryInterface;


/**
 * Class RegistryResolver
 *
 * @package Paymaxi\FractalBundle\Resolver
 */
final class RegistryResolver implements ResolverInterface
{
    /** @var  ServiceRegistryInterface */
    private $registry;

    /**
     * RegistryResolver constructor.
     *
     * @param ServiceRegistryInterface $registry
     */
    public function __construct(ServiceRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param string $class
     *
     * @return bool
     *
     */
    public function supports(string $class)
    {
        return $this->registry->has($class);
    }

    /**
     *
     * @param string $class
     *
     * @return TransformerAbstract
     */
    public function resolve(string $class)
    {
        return $this->registry->get($class);
    }
}