<?php

use Sparwelt\ImgixBundle\DependencyInjection\SparweltImgixExtension;
use Sparwelt\ImgixBundle\Twig\ImgixTwigExtension;
use Sparwelt\ImgixLib\ImgixService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author Federico Infanti <federico.infanti@sparwelt.de>
 *
 * @since  24.07.18 10:24
 */
class ImgixExtensionTest extends \PHPUnit\Framework\TestCase
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

    public function testTwigCalls()
    {
        $configs = [
            'sparwelt_imgix' => [
                'cdn_configurations' => [
                    'uploads' => [
                        'cdn_domains' => ['sparwelt-cdn-assets-development.imgix.net'],
                        'source_domains' => ['s3-static-dev.sparwelt.de', 'sparwelt.test', null],
                        'path_patterns' => ['^[/]?media/', '^[/]?uploads/'],
                    ],
                ],
            ],
        ];

        $imgixServiceMock = $this->getMockBuilder(ImgixService::class)->disableOriginalConstructor()->getMock();
        $imgixServiceMock->expects($this->exactly(1))->method('generateUrl')->with('test1.png', ['p1' => 1], ['p2' => 2])->willReturn('generateUrlCalled');
        $imgixServiceMock->expects($this->exactly(1))->method('generateAttributeValue')->with('test2.png', ['p3' => 3], ['p4' => 4])->willReturn('generateAttributeValueCalled');
        $imgixServiceMock->expects($this->exactly(1))->method('generateImage')->with('test3.png', ['p5' => 5], ['p6' => 6])->willReturn('generateImageCalled');
        $imgixServiceMock->expects($this->exactly(1))->method('convertHtml')->with('html', ['p7' => 7], ['p8' => 8])->willReturn('convertHtmlCalled');

        $container = new ContainerBuilder();
        $this->extension->load($configs, $container);

        $container->set(ImgixService::class, $imgixServiceMock);
        $this->assertEquals('generateUrlCalled', $container->get(ImgixTwigExtension::class)->generateUrl('test1.png', ['p1' => 1], ['p2' => 2]));
        $this->assertEquals('generateAttributeValueCalled', $container->get(ImgixTwigExtension::class)->generateAttributeValue('test2.png', ['p3' => 3], ['p4' => 4]));
        $this->assertEquals('generateImageCalled', $container->get(ImgixTwigExtension::class)->generateImage('test3.png', ['p5' => 5], ['p6' => 6]));
        $this->assertEquals('convertHtmlCalled', $container->get(ImgixTwigExtension::class)->transformHtml('html', ['p7' => 7], ['p8' => 8]));

        $filters = $container->get(ImgixTwigExtension::class)->getFilters();
        $this->assertInstanceOf(TwigFilter::class, $filters[0]);
        $this->assertInstanceOf(TwigFilter::class, $filters[1]);
        $this->assertInstanceOf(TwigFilter::class, $filters[2]);
        $this->assertInstanceOf(TwigFilter::class, $filters[3]);

        $functions = $container->get(ImgixTwigExtension::class)->getFunctions();
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
        $this->assertInstanceOf(TwigFunction::class, $functions[1]);
        $this->assertInstanceOf(TwigFunction::class, $functions[2]);
        $this->assertInstanceOf(TwigFunction::class, $functions[3]);
    }
}
