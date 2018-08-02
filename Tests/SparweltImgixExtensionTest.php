<?php

use Sparwelt\ImgixBundle\DependencyInjection\SparweltImgixExtension;
use Sparwelt\ImgixBundle\Twig\ImgixTwigExtension;
use Sparwelt\ImgixLib\ImgixService;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Federico Infanti <federico.infanti@sparwelt.de>
 *
 * @since  24.07.18 10:24
 */
class SparweltImgixExtensionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var SparweltImgixExtension
     */
    private $extension;

    public function setUp()
    {
        parent::setUp();

        $this->extension = new SparweltImgixExtension();
    }

    public function testCdnConfiguration()
    {
        $configs = [
            'sparwelt_imgix' => [
                'cdn_configurations' => [
                    'uploads' => [
                        'cdn_domains' => ['sparwelt-cdn-assets-development.imgix.net'],
                        'source_domains' => ['s3-static-dev.sparwelt.de', 'sparwelt.test', null],
                        'path_patterns' => ['^[/]?media/', '^[/]?uploads/'],
                    ],
                    'assets_absolute' => [
                        'use_ssl' => true,
                        'cdn_domains' => ['sparwelt.test'],
                        'source_domains' => ['sparwelt.test'],
                    ],
                    'assets_relative' => [
                        'use_ssl' => true,
                        'cdn_domains' => ['sparwelt.test'],
                        'path_patterns' => ['^[/]?bundles/'],
                    ],
                ],
            ],
        ];

        $container = new ContainerBuilder();
        $this->extension->load($configs, $container);

        $this->assertInstanceOf(ImgixService::class, $container->get('Sparwelt\ImgixLib\ImgixService'));
        $this->assertInstanceOf(ImgixTwigExtension::class, $container->get('Sparwelt\ImgixBundle\Twig\ImgixTwigExtension'));
    }

    public function testCdnConfigurationWithFilters()
    {
        $configs = [
            'sparwelt_imgix' => [
                'cdn_configurations' => [
                    'uploads' => [
                        'cdn_domains' => ['sparwelt-cdn-assets-development.imgix.net'],
                        'source_domains' => ['s3-static-dev.sparwelt.de', 'sparwelt.test', null],
                        'path_patterns' => ['^[/]?media/', '^[/]?uploads/'],
                        'use_ssl' => true,
                        'default_query_params' => ['cb' => 1234],
                        'generate_filter_params' => true,
                    ],
                ],
                'image_filters' => [
                    'test' => [
                        'src' => ['w' => 100, 'h' => 100],
                        'srcset' => ['1x' => ['w' => 100, 'h' => 100], '2x' => ['w' => 100, 'h' => 100]],
                        'sizes' => 'auto',
                    ],
                    'test2' => [
                        'src' => ['w' => 100, 'h' => 100],
                    ],
                ],
            ],
        ];

        $container = new ContainerBuilder();
        $this->extension->load($configs, $container);

        $this->assertInstanceOf(ImgixService::class, $container->get('Sparwelt\ImgixLib\ImgixService'));
        $this->assertInstanceOf(ImgixTwigExtension::class, $container->get('Sparwelt\ImgixBundle\Twig\ImgixTwigExtension'));
    }

    public function testMissingCdnConfiguration()
    {
        $this->expectException(InvalidConfigurationException::class);
        $configs = [
            'sparwelt_imgix' => [
                'image_filters' => [
                    'test' => [
                        'src' => ['w' => 100, 'h' => 100],
                        'srcset' => ['1x' => ['w' => 100, 'h' => 100], '2x' => ['w' => 100, 'h' => 100]],
                        'sizes' => 'auto',
                    ],
                    'test2' => [
                        'src' => ['w' => 100, 'h' => 100],
                    ],
                ],
            ],
        ];

        $container = new ContainerBuilder();
        $this->extension->load($configs, $container);
    }
}
