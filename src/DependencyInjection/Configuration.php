<?php

declare(strict_types=1);

namespace DH\ArtisAdminOrderEmptyProductCloneFeaturePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('artis_order_empty_product_clone_feature_plugin');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}