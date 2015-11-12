# Method-Override
Provides a PSR-7 compliant middleware that overrides the default HTTP VERB by inspecting the URI.

```
URI: ?_method=<YOURVERB>

GET /index.php/youraction?_method=POST
Would actually turn into a POST request
```
