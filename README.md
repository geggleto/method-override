# Method-Override
Provides a PSR-7 compliant middleware that overrides the default HTTP VERB by inspecting the URI and the _method of a message body

```
URI: ?_method=<YOURVERB>

GET /index.php/youraction?_method=POST
Would actually turn into a POST request

OR
A POST route may provide a _method='' override

OR
You can specify the header X-Http-Method-Override to override
```
