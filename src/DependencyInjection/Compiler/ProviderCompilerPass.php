<?php

namespace App\DependencyInjection\Compiler;

use App\Service\ProviderService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProviderCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ProviderService::class)) {
            return;
        }

        $defination = $container->findDefinition(ProviderService::class);

        $taggedServices = $container->findTaggedServiceIds("provider.api");
        foreach ($taggedServices as $id=>$taggedService) {
            $defination->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}