<?php
declare(strict_types=1);

namespace Paymaxi\FractalBundle\Resolver;

use League\Fractal\TransformerAbstract;

/**
 * Class DirectoryResolver
 *
 * @package Paycore\Bundle\PaycoreBundle\Service
 */
final class DirectoryResolver implements ResolverInterface
{
    /** @var string */
    private $suffix;

    /** @var  array */
    private $map = [];

    /** @var string */
    private $namespaceSuffix;

    /**
     * DirectoryResolver constructor.
     *
     * @param string $classSuffix
     * @param string $namespaceSuffix
     */
    public function __construct(string $classSuffix = 'Transformer', string $namespaceSuffix = 'Transformer')
    {
        $this->suffix = $classSuffix;
        $this->namespaceSuffix = $namespaceSuffix;
    }


    /**
     * @param string $class
     *
     * @param $resourceTransformer
     *
     * @return bool
     */
    public function supports(string $class, $resourceTransformer): bool
    {
        if (array_key_exists($class, $this->map)) {
            return true;
        }

        $parts = explode('\\', $class);
        $className = array_pop($parts);
        $transformerClassName = $className . $this->suffix;

        array_pop($parts); // remove class directory
        $parts[] = $this->namespaceSuffix;
        $parts[] = $transformerClassName;

        $newClass = implode('\\', $parts);

        if (class_exists($newClass)) {
            $reflection = new \ReflectionClass($newClass);
            if ($reflection->hasMethod('__construct')
                && 0 !== $reflection->getMethod('__construct')->getNumberOfRequiredParameters()
            ) {
                return false;
            }

            $this->map[$class] = new $newClass;
            return true;
        }

        return false;
    }

    /**
     * @param string $class
     *
     * @param $resourceTransformer
     *
     * @return TransformerAbstract
     */
    public function resolve(string $class, $resourceTransformer): TransformerAbstract
    {
        return $this->map[$class];
    }
}