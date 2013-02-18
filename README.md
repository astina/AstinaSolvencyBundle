Astina Solvency Bundle
======================

Integration bundle for risk checking services. The only implemented provider at the moment is DeltaVista.

## Install

### Step 1: Add to composer.json

```
"require" :  {
    // ...
    "astina/solvency-bundle":"dev-master",
}
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Astina\Bundle\SolvencyBundle\AstinaSolvencyBundle(),
    );
}
```

### Step 3: Configuration

Add the WSDL url and DeltaVista credentials to your config.yml:

```yaml
# app/config.yml

astina_solvency:
    provider:
        deltavista:
            wsdl_url: http://example.org/path/to.wsdl
            user: user
            password: 123
            endpoint_url: ~ # only needs to be set if another then the default one should be used (e.g. for testing)
```

## Caching

Per default, all requests are cached as the risk check provider usually charges per request. Because of that we don't use the Symfony cache dir but a separate one.
You can set the cache lifetime and dir in the config:

```yaml
# app/config.yml

astina_solvency:
    cache:
        cache_dir: /my/cache/dir
        lifetime: ~ # null means "forever"
```