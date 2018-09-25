<?php

namespace Sparwelt\ImgixBundle\Twig;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Sparwelt\ImgixLib\Exception\ResolutionException;
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
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string
     */
    private $logLevel;

    /**
     * @param ImgixService         $imgix
     * @param LoggerInterface|null $logger
     * @param string               $logLevel
     */
    public function __construct(ImgixService $imgix, LoggerInterface $logger = null, $logLevel = LogLevel::NOTICE)
    {
        $this->imgix = $imgix;
        $this->logger = null !== $logger ? $logger : new NullLogger();
        $this->logLevel = $logLevel;
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
            new TwigFilter('imgix_html', [$this, 'transformHtml'], ['is_safe' => ['html']]),
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
            new TwigFunction('imgix_html', [$this, 'transformHtml'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string       $originalUrl
     * @param array|string $filtersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     *
     * @throws \Sparwelt\ImgixLib\Exception\ResolutionException
     */
    public function generateUrl($originalUrl, $filtersOrConfigurationKey = [], $extraFilters = [])
    {
        try {
            return $this->imgix->generateUrl($originalUrl, $filtersOrConfigurationKey, $extraFilters);
        } catch (ResolutionException $e) {
            $this->logger->log($this->logLevel, $e->getMessage());
            return '';
        }
    }

    /**
     * @param string       $originalUrl
     * @param array|string $filtersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     *
     * @throws \Sparwelt\ImgixLib\Exception\ResolutionException
     */
    public function generateAttributeValue($originalUrl, $filtersOrConfigurationKey = [], $extraFilters = [])
    {
        try {
            return $this->imgix->generateAttributeValue($originalUrl, $filtersOrConfigurationKey, $extraFilters);
        } catch (ResolutionException $e) {
            $this->logger->log($this->logLevel, $e->getMessage());
            return '';
        }
    }

    /**
     * @param string       $originalUrl
     * @param array|string $attributesFiltersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     */
    public function generateImage($originalUrl, $attributesFiltersOrConfigurationKey = [], $extraFilters = [])
    {
        try {
            return $this->imgix->generateImage($originalUrl, $attributesFiltersOrConfigurationKey, $extraFilters);
        } catch (ResolutionException $e) {
            $this->logger->log($this->logLevel, $e->getMessage());
            return '';
        }
    }

    /**
     * @param string       $originalHtml
     * @param array|string $attributesFiltersOrConfigurationKey
     * @param array        $extraFilters
     *
     * @return string
     */
    public function transformHtml($originalHtml, $attributesFiltersOrConfigurationKey = [], $extraFilters = [])
    {
        return $this->imgix->transformHtml($originalHtml, $attributesFiltersOrConfigurationKey, $extraFilters);
    }
}
