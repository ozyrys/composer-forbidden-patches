# composer-forbidden-patches

This has to be added to project's composer.json file:
```
"autoload": {
        "psr-4": {
            "Ozyrys\\ForbiddenPatches\\Composer\\": "vendor/ozyrys/composer-forbidden-patches/src"
        }
}
```