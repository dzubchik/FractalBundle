<?php

namespace Paymaxi\FractalBundle;

use Paymaxi\Component\Compiler\PrioritizedRegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class PaymaxiFractalBundle
 *
 * @package Paymaxi\FractalBundle
 */
class PaymaxiFractalBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PrioritizedRegistryPass('fractal.transformer.resolvers'));
    }

}
