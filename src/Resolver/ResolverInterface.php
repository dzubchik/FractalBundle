<?php
declare(strict_types=1);

namespace Paymaxi\FractalBundle\Resolver;


use League\Fractal\TransformerAbstract;

/**
 * Interface ResolverInterface
 *
 * @package Paymaxi\FractalBundle\Resolver
 */
interface ResolverInterface
{
    /**
     * @param string $class
     *
     * @return bool
     *
     */
    public function supports(string $class);

    /**
     * @param string $class
     *
     * @return TransformerAbstract
     *
     */
    public function resolve(string $class);
}