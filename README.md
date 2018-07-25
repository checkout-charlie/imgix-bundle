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
### Filters configuration

TBC

