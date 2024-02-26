# composer-forbidden-patches

To make this plugin functionsl, this has to be added to project's composer.json file:
```
"autoload": {
        "psr-4": {
            "Ozyrys\\ForbiddenPatches\\Composer\\": "vendor/ozyrys/composer-forbidden-patches/src"
        }
}
```
This plugin is disabled by default, therfore it has to be enabled through config set as follows:
```
"extra": {
    "ozyrys-patch-event-subscriber": {
        "enable-forbidden-patches": true
    }
}
```