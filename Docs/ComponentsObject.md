## Components Object

#### 固定字段

字段 | 类型 | 描述
--- | --- | ---
securitySchemes | [[SecuritySchemeObject](#SecuritySchemeObject)] | 【必须】
schemas | [[SchemaObject](#SchemaObject)] | 【必须】
responses | string | xxx
parameters | string | xxx
examples | string | xxx
requestBodies | string | xxx
headers | string | xxx
links | string | xxx
callbacks | string | xxx

#### 代码示例

### Security Scheme Object
<a name="SecuritySchemeObject"></a>

#### 固定字段
字段 | 类型 |适用于 |  描述
--- | --- | --- | ---
type | string | any | 【必须】有效的值有 `"apiKey"`,`"http"`,`"oauth2"`,`"openIdConnect"` 
name | string | apiKey | 【必须】apiKey在header、query、cookie中的名字
in | string | apiKey | 【必须】apiKey的位置，有效的值有 `"query"`, `"header"` , `"cookie"`
scheme | string | http| 【必须】http授权方案名称，可以使用的值有 `"bearer"`，`"basic"` 
bearerFormat | string | http("bearer") | 【可选】指定签名令牌如何格式化，可以是任意字符串。例如`"JWT"` 
flows | OAuth Flows Object | oauth2 | 【必须】
openIdConnectUrl | string | openIdConnect | 【必须】
description | string | any | 描述文字

#### 代码示例
```php
'securitySchemes' => [
    'bearerAuth' => [
        'type' => 'http',
        'scheme' => 'bearer',
        'bearerFormat' => 'JWT',
    ]
],
```

