[![Build Status](https://travis-ci.org/sparwelt/imgix-bundle.svg?branch=master)](https://travis-ci.org/sparwelt/imgix-bundle)
[![Coverage Status](https://coveralls.io/repos/github/sparwelt/imgix-bundle/badge.svg?branch=master)](https://coveralls.io/github/sparwelt/imgix-bundle?branch=master)

| php5.6 + sf2      | php7.1 + sf2      | php5.6 + sf3      | php7.1 + sf3      | php7.1 + sf4      |
|-------------------|-------------------|-------------------|-------------------|-------------------|
| [![Status][1]][6] | [![Status][2]][6] | [![Status][3]][6] | [![Status][4]][6] | [![Status][5]][6] |

[1]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/1
[2]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/2
[3]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/3
[4]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/4
[5]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/5
[6]: https://travis-ci.org/sparwelt/imgix-bundle

Imgix Bundle
===================

## Installation
```bash
composer require sparwelt/imgix-bundle
```
## Configuration
### Cdn configuration
#### Basic
```yaml
sparwelt_imgix:
  cdn_configurations:
    my_cdn:
      cdn_domains: ['cdn1.imgix.net', 'cdn1.imgix.net']
```
#### Multiple
```yaml
sparwelt_imgix:
  cdn_configurations:
    my_assets_cdn:
      cdn_domains: ['cdn1.imgix.net', 'cdn1.imgix.net']
      path_patterns: ['^bundles/']
      sign_key: 'mysignkey123'
    my_uploads_cdn:
      cdn_domains: ['other1.imgix.net', 'other2.imgix.net']
      source_domains: ['s3-uploads.mydomain.com']
      sign_key: 'mysignkey123'
```
#### Full
```yaml
sparwelt_imgix:
  cdn_configurations:
      bypass_assets_development:
        use_ssl: false
        cdn_domains: ['mydomain.test']
        source_domains: ['mydomain.test']
        path_patterns: ['^bundles/', '^assets/']
    my_assets_cdn:
      cdn_domains: ['cdn1.imgix.net', 'cdn1.imgix.net']
      path_patterns: ['^bundles/', '^assets/']
      sign_key: 'mysignkey123'
      shard_stategy: 'crc'
    my_uploads_cdn:
      cdn_domains: ['other1.imgix.net', 'other2.imgix.net']
      source_domains: ['s3-uploads.mydomain.com', 'mydomain.com']
      path_patterns: ['^uploads/', '^media/']
      sign_key: 'mysignkey123'
      shard_stategy: 'cycle'
```
### Usage
#### Url generation
```twig
<img src="{{ '/assets/test.png'|imgix_url({w: 100, max-h: 50, q: 85}) }}">

returns:

<img src="https://cdn1.imgix.net/assets/test.png?w=100&max-h=50&q=85">
```
#### Image generation

```twig
{{ imgix_image('/assets/test.png', {
  src: {w: 100, max-h: 50},
  srcset: {2x: {w: 200, max-h: 100}, 3x: {w: 300, max-h: 150}}},
  sizes: 'auto'
)}}

returns:

<img src="https://cdn1.imgix.net/assets/test.png?w=100&max-h=50"
        srcset="https://cdn1.imgix.net/assets/test.png?w=200&max-h=100 2x, https://cdn1.imgix.net/assets/test.png?w=300&max-h=150 3x"
        sizes="auto"
        >
```

#### Attribute generation

```twig
<img data-srcset="{{ 'test.png'|imgix_attr({2x: {w: 200, max-h: 100}, 3x: {w: 300, max-h: 150}}) }}">

returns:

<img data-srcset="https://cdn1.imgix.net/test.png?w=200&max-h=100 2x, https://cdn1.imgix.net/test.png?w=300&max-h=150 3x">
```

#### Html conversion
Simple conversion
```twig

{% set html = '<li><img src="/test.png" ng-src="/test2.png"><\li><li><img srcset="test3.png" data-srcset="/test4.png 2x, /test4.png 3x">' %} 
{{ html|imgix_html }}

returns:

<li><img src="https://cdn1.imgix.net/test.png" ng-src="https://cdn1.imgix.net/test2.png"><\li><li><img src="https://cdn1.imgix.net/test3.png" data-srcset="https://cdn1.imgix.net/test4.png 2x, https://cdn1.imgix.net/test4.png 3x">
```
Attribute conversion
```twig
{% set html = '<li><img src="/test.png" ng-src="/test2.png"><\li><li><img data-srcset="/test3.png 2x, /test3.png 3x">' %} 
{{ html|imgix_html{{src: {w: 10, h: 20}} }}

returns:

<li><img src="https://cdn1.imgix.net/test.png?w=10&h=20" ng-src="https://cdn1.imgix.net/test2.png"><\li><li><img data-srcset="https://cdn1.imgix.net/test3.png 2x, https://cdn1.imgix.net/test3.png 3x">
```
Advanced conversion (the filters params will be applied only for images that have the 'src' image)
```twig
{% set html = '<li><img src="/test.png" ng-src="/test2.png"><\li><li><img data-srcset="/test3.png 2x, /test3.png 3x">' %} 
{{ html|imgix_html{{src: {w: 10, h: 20}}, srcset={} }}

returns:

<li><img src="https://cdn1.imgix.net/test.png?w=10&h=20" ng-src="https://cdn1.imgix.net/test2.png"><\li><li><img data-srcset="https://cdn1.imgix.net/test3.png 2x, https://cdn1.imgix.net/test3.png 3x">
```

### Working with preconfigured filters
#### Basic
```yaml
sparwelt_imgix:
  image_filters:
    basic:
      src: [max-w: 200, max-h: 100, q: 85]
    responsive_thumbnail:
      
```
TBC

