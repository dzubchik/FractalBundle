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
     * @param $resourceTransformer
     *
     * @return bool
     */
    public function supports(string $class, $resourceTransformer);

    /**
     * @param string $class
     *
     * @param $resourceTransformer
     *
     * @return TransformerAbstract
     */
    public function resolve(string $class, $resourceTransformer);
}