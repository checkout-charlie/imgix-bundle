<?php

namespace Sparwelt\ImgixBundle\Twig;

use Sparwelt\ImgixLib\ImgixService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author Federico Infanti <federico.infanti@sparwelt.de>
 *
 * @since  22.07.18 23:09
 */
class ImgixTwigExtension extends AbstractExtension
{
    /** @var ImgixService */
    private $imgix;

    public function __construct(ImgixService $imgix)
    {
        $this->imgix = $imgix;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new TwigFilter('imgix_url', [$this, 'generateUrl']),
            new TwigFilter('imgix_attr', [$this, 'generateAttributeValue']),
            new TwigFilter('imgix_html', [$this, 'generateHtml']),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('imgix_image', [$this, 'generateImage']),
        ];
    }

    /**
     * @param string       $originalUrl
     * @param array|string $filtersOrConfigurationKey
     */
    public function generateUrl($originalUrl, $filtersOrConfigurationKey = [])
    {
        $this->imgix->generateUrl($originalUrl, $filtersOrConfigurationKey);
    }

    /**
     * @param string       $originalUrl
     * @param array|string $filtersOrConfigurationKey
     */
    public function generrateAttribute($originalUrl, $filtersOrConfigurationKey = [])
    {
        $this->imgix->generateAttributeValue($originalUrl, $filtersOrConfigurationKey);
    }

    /**
     * @param string       $originalUrl
     * @param array|string $attributesFiltersOrConfigurationKey
     */
    public function generateImage($originalUrl, $attributesFiltersOrConfigurationKey = [])
    {
        $this->imgix->generateImage($originalUrl, $attributesFiltersOrConfigurationKey);
    }

    /**
     * @param string       $originalHtml
     * @param array|string $attributesFiltersOrConfigurationKey
     */
    public function convertHtml($originalHtml, $attributesFiltersOrConfigurationKey = [])
    {
        $this->imgix->convertHtml($originalHtml, $attributesFiltersOrConfigurationKey);
    }
}
