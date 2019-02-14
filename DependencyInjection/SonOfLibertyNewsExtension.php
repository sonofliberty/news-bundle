<?php
/**
 * Copyright (c) 2019 Aleksander Winter <aleksander.winter.89@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */

namespace SonOfLiberty\NewsBundle\DependencyInjection;

use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use SonOfLiberty\NewsBundle\SonOfLibertyNewsBundle;
use Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class SonOfLibertyNewsExtension
 * @package SonOfLiberty\NewsBundle\DependencyInjection
 */
class SonOfLibertyNewsExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // check if all required bundles are enabled
        $enabledBundles = $container->getParameter('kernel.bundles');
        $requiredBundles = [
            StofDoctrineExtensionsBundle::class,
            KnpPaginatorBundle::class
        ];
        foreach ($requiredBundles as $requiredBundle) {
            if (!in_array($requiredBundle, $enabledBundles)) {
                throw new \InvalidArgumentException("$requiredBundle must be installed before installing " . SonOfLibertyNewsBundle::class);
            }
        }

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('sol_news.author.class', $config['author']['class']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}