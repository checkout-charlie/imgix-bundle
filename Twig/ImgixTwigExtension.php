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
            new TwigFilter('imgix_url', [$this, 'generateUrl'], ['is_safe' => ['html']]),
            new TwigFilter('imgix_image', [$this, 'generateImage'], ['is_safe' => ['html']]),
            new TwigFilter('imgix_attr', [$this, 'generateAttributeValue'], ['is_safe' => ['html']]),
            new TwigFilter('imgix_html', [$this, 'generateHtml'], ['is_safe' => ['html']]),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('imgix_url', [$this, 'generateUrl'], ['is_safe' => ['html']]),
            new TwigFunction('imgix_image', [$this, 'generateImage'], ['is_safe' => ['html']]),
            new TwigFunction('imgix_attr', [$this, 'generateAttributeValue'], ['is_safe' => ['html']]),
            new TwigFunction('imgix_html', [$this, 'generateHtml'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string       $originalUrl
     * @param array|string $filtersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     */
    public function generateUrl($originalUrl, $filtersOrConfigurationKey = [], $extraFilters = [])
    {
        return $this->imgix->generateUrl($originalUrl, $filtersOrConfigurationKey, $extraFilters);
    }

    /**
     * @param string       $originalUrl
     * @param array|string $filtersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     */
    public function generateAttributeValue($originalUrl, $filtersOrConfigurationKey = [], $extraFilters = [])
    {
        return $this->imgix->generateAttributeValue($originalUrl, $filtersOrConfigurationKey, $extraFilters);
    }

    /**
     * @param string       $originalUrl
     * @param array|string $attributesFiltersOrConfigurationKey
     *
     * @param array        $extraFilters
     * @return string
     */
    public function generateImage($originalUrl, $attributesFiltersOrConfigurationKey = [], $extraFilters = [])
    {
        return $this->imgix->generateImage($originalUrl, $attributesFiltersOrConfigurationKey, $extraFilters);
    }

    /**
     * @param string       $originalHtml
     * @param array|string $attributesFiltersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     */
    public function convertHtml($originalHtml, $attributesFiltersOrConfigurationKey = [], $extraFilters = [])
    {
        return $this->imgix->convertHtml($originalHtml, $attributesFiltersOrConfigurationKey, $extraFilters);
    }
}
