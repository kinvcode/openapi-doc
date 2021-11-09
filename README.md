[toc]

# Swagger&OpenApi文档开发指引
​    	本文档工具以**OpenAPI规范【v3.0.0】**为基础，使用**swaggerUI【v3.x】**作为客户端工具，采用json数据描述**OpenAPI**。为方便**PHP开发人员**利于理解OpenAPI结构，文档内代码示例暂时用**PHP数组**类型数据表示**JSON**，但最终这些数组都需要转为JSON格式数据。

​		项目开发推荐使用`标准OpenAPI`文件中所用的结构，`完整OpenAPI`文件作为参考使用。

## 依赖
* [OpenApi 3.0.0](https://github.com/OAI/OpenAPI-Specification/blob/main/versions/3.0.0.md)
* [SwaggerUI 3.X](https://github.com/swagger-api/swagger-ui/tree/3.x/dist)

## 核心开发文件
* 标准OpenAPI【推荐】：`App\Http\Controllers\ApiDocController`
* 完整OpenAPI【参考】：`App\Http\Controllers\ApiFullDocController`
* 视图文件：`resources\views\welcome.blade.php`
* 资源文件夹：`public\static\swagger`

## 项目开发指引
复制**资源文件夹**、**视图文件**、**标准OpenAPI文件**到项目中

视图中的获取json数据的路由，根据项目实际情况进行修改

访问该文档视图的路由需要进行身份认证才能访问，如果使用了**larave-admin**插件，可以放到后台路由中。如果项目中没有使用laravel-admin，可以使用其他身份认证的方式（例如**laravel**自带的**auth路由**及中间件）。

## 数据结构体

### 顶层结构
​		顶层结构是OpenAPI的结构框架，所有的数据都汇总在这里。具体细节请参考各字段下对象结构。

#### 固定字段
字段名 | 类型 | 描述
--- | --- | :--
openapi | string | 【必须】OpenAPI规范的版本号，本文档采用`3.0.0`版本 
info | [Info Object](#infoObject) | 【必须】文档基础信息 
servers | [[Servers Object](#serversObject)] |【必须】 服务器信息
paths | [Paths Object](#pathsObject) | 【必须】 API信息
components | [Components Object](#componentsObject) | 【必须】组件
security | [[Security Requirement Object](#securityRequirementObject)] | 认证方式
tags | tag object | 暂时无需填写
externalDocs | [External Documention Object](#externalDocumentionObject) | 拓展文档 

#### 代码示例
```php
[
    "openapi" => "3.0.0",
    "info" => [
        "description" => "该文档仅供本公司内部员工使用",
        "version" => "1.0.0",
        "title" => "【 xx公司 】API文档",
        "contact" => [
                "email" => "kinvcode@gmail.com"
            ]
    ],
    "servers" => [
        ["url" => "https://www.api.test/api/v1"]
    ],
    "schemes" => ["http","https"],
    "paths" => [],
    "components" => [
        "securitySchemes" => [],
        "schemas" => []
    ]
]
```

### Servers Object
<a name="serversObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
url | string | 服务器域名
description | string | 服务器描述
variables | [ServerVariableObject] | 服务器变量

#### 代码示例
```php
"servers" => [
    [
        'url' => 'http://www.api.test/api/v1',
    ],
    [
        'url' => 'http://www.api.test/api/v2',
        'description' => '开发环境服务器',
    ],
    [
        'url' => 'http://www.{domain}:{port}/api/{version}', // http://www.api.test:80/api/v1
        'description' => '生产环境服务器',
        'variables' => [
            'domain' => [
                'default' => 'api.test',
            ],
            'port' => [
                'enum' => ['80', '8080'],
                'default' => '80',
            ],
            'version' => [
                'enum' => ['v1', 'v2'],
                'default' => 'v1',
                'description' => 'API文档版本',
            ]
        ]
	]
]
```

### Security Requirement Object
<a name="securityRequirementObject"></a>

#### 匹配字段
匹配字段 | 类型 | 描述
--- | --- | ---
{name} | [string] | Security Schemes中的一个

#### 代码示例
```php
[
    "api_key"=>[]
]
```

### External Documention Object
<a name="externalDocumentionObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
url | string | 【必须】文档地址，必须是url格式
description | string | 文档描述

#### 代码示例
```
"externalDocs"=>[
    'description' => '开发人员主页',
    'url' => 'https://www.kinvcode.com',
]
```
### Reference Object【引用对象及其用法】
<a name="referenceObject"></a>
​		**引用对象**（Reference Object）的作用是将JSON数据中某个节点的数据直接拿来用，利于减少数据冗余。其中字段名**$ref**是固定的，不能写作其他名字。节点路径使用 **/** 符号进行分割并在路径前面加上 **#** 符号。引用对象的使用在文档中非常频繁，掌握使用引用对象的方法对开发文档十分重要。

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
$ref | string | 引用的资源

#### 代码示例
```
[
	"$ref"=>'#/components/schemas/Pet',
]
```

### Info Object
<a name="infoObject"></a>
该对象提供API的基本数据

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
title | string | 【必须】应用标题
version | string | 【必须】版本号
description | string | 描述
contact | [Contact Object](#contactObject) | 联系信息

#### 示例
```php
[
    'description' => '该文档仅供本公司内部员工使用',
    'version' => '1.0.0',
    'title' => '【 xx公司 】API文档',
    'contact' => [],
];
```

### Contact Object
<a name="contactObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
name | string | 联系人名字
url | string | 必须是url格式
email | string | 必须是邮件地址格式

#### 示例
```php
[
    'contact' => [
        'name' => 'kinv',
        'url' => 'https://www.kinvcode.com',
        'email' => 'kinvcode@gmail.com',
    ]
];
```

### Components Object
<a name="componentsObject"></a>

#### 固定字段

字段 | 类型 | 描述
--- | --- | ---
securitySchemes | [[SecuritySchemeObject](#securitySchemeObject)] | 【必须】
schemas | [[SchemaObject](#schemaObject)] | 【必须】
responses | string | xxx
parameters | string | xxx
examples | string | xxx
requestBodies | string | xxx
headers | string | xxx
links | string | xxx
callbacks | string | xxx

#### 代码示例

### Security Scheme Object
<a name="securitySchemeObject"></a>

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


### Paths Object
<a name="pathsObject"></a>


#### 匹配字段
字段 | 类型 | 描述
--- | --- | ---
/{path} | [Path Item Object](#pathItemObject) | API路径


#### 代码示例

```php
'/version' => [
    'get' => [
        'tags' => ['基础'],
        'summary' => "基础的GET请求",
        'responses' => [
        ]
    ]
],
```

###  Path Item Object
<a name=" pathItemObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
$ref | string | xx
get | [Operation Object](#Operation Object) | GET请求
post | [Operation Object](#Operation Object) |POST请求
put | [Operation Object](#Operation Object) | PUT请求
delete | [Operation Object](#Operation Object) | DELETE请求
patch | [Operation Object](#Operation Object) | PATCH请求
options | [Operation Object](#Operation Object) | OPTIONS请求
head | [Operation Object](#Operation Object) | HEAD请求
trace | [Operation Object](#Operation Object) | TRACE请求
parameters | [[Parameter Object](#parameterObject) \| [Reference Object](#referenceObject)] | 请求参数；多个请求时该字段可以共用


#### 代码示例
```php
'get' => [
    'tags' => ['基础'],
    'summary' => "url路径参数",
    'responses' => []
],
'parameters' => [
    [
        'name' => 'id',
        'in' => 'path',
        'required' => true,
        'schema' => [
            'type' => 'integer',
        ],
        'description' => '用户ID',
        'allowEmptyValue' => false,
    ]
],
```

### Operation Object
<a name="operationObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
tags | [string] | 【必须】标记
summary | string | 【必须】概要描述
description | string | 【可选】描述
security | [Security Requirement Object](#securityRequirementObject) |【可选】权限认证， 如果是需要身份认证的API则为必须
parameters |[[Parameter Object](#parameterObject) \| [Reference Object](#referenceObject)] | 请求参数
requestBody | Request Body Object | Reference Object 
responses | Responses Object | 【必须】响应体
deprecated | boolean | 是否已弃用
operationId | string | 用于标识操作的唯一字符串

#### 代码示例
```php
'get' => [
    'tags' => ['基础'],
    'summary' => "我的收藏",
    'description' => '展示我的收藏列表',
    'operationId' => 'me-collection-id',
    'deprecated' => false,
    'parameters' => [],
    "security" => [
        ['bearerAuth' => []]
    ],
    'responses' => []
],
```


### Parameter Object
<a name="parameterObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
name | string | 【必须】参数名
in | string | 【必须】参数位置，可用值有：`path`、`query`、`header`、`cookie`
schema | [Schema Object](#schemaObject) | 【必须】参数类型
required | boolean | 如果是路径参数则`required`必须为`true` 
description | string | 描述文字 
allowEmptyValue | boolean | 是否允许为空

#### 代码示例
```php
'parameters' => [
    [
        'name' => 'id',
        'in' => 'path',
        'required' => true,
        'schema' => [
        	'type' => 'integer',
    	],
        'description' => '用户ID',
        'allowEmptyValue' => false,
    ],
]
```

### Schema Object
<a name="schemaObject"></a>

#### 固定字段
字段 | 类型 | 描述
--- | --- | ---
type | string | 【必须】类型
required | array | 必须的字段
example | mixed | 例子
description | string | 描述文字
default | mixed | 默认值
properties | [Schema Object](#schemaObject) | 【object】字段列表 
format | string | 格式化信息，详情请参考[格式化列表](#format) 
title | string | 标题（用于文档显示）
items | [Schema Object](#schemaObject) | 【array】用于表示数组元素 
minLength | integer | 【string】最小长度
maxLength | integer | 【string】最大长度
pattern | 正则表达式 | 【string】正则匹配表达式
minimum | integer | 【number、integer】最小值
maximum | integer | 【number、integer】最大值
exclusiveMinimum | boolean | 【number、integer】默认为false；如果为true则该数值不能等于最小值
exclusiveMaximum | boolean | 【number、integer】默认为false；如果为true则该数值不能等于最大值
multipleOf | integer | 【number、integer】必须是该数值的倍数；可以是小数但不推荐；不能是负数。
minItems | integer | 【array】数组最小元素个数
maxItems | integer | 【array】数组最大元素个数
uniqueItems | boolean | 【array】数组元素不能有重复的值


#### 代码示例 - 布尔数据
```php
[
    'type' => 'boolean',
    'example' => false,
    'description' => '布尔类型数据',
    'title' => '布尔数据'
]
```

#### 代码示例 - 字符串（基础）
```php
[
    'type' => 'string',
    'example' => 'kinvcode',
    'description' => '字符串类型数据',
    'title' => '字符串-基础'
]
```

#### 代码示例 - 字符串（长度限制）
```php
[
    'type' => 'string',
    'example' => 'kinvcode',
    'title' => '字符串-长度限制',
    'minLength' => 3,
    'maxLength' => 10,
]
```

#### 代码示例 - 字符串（格式化）
```php
[
    'type' => 'string',
    'example' => 'kinvcode',
    'title' => '字符串-格式化',
    'format' => 'password',
]
```

#### 代码示例 - 字符串（正则匹配）
```php
[
    'type' => 'string',
    'example' => 'kinvcode',
    'title' => '字符串-正则匹配',
    'pattern' => '^\d{3}-\d{2}-\d{4}$',
]
```

#### 代码示例 - 数值（基础）
```php
[
    'type' => 'number',
    'example' => 3.1415926,
    'description' => '数值类型数据',
    'title' => '数值-基础',
]
```

#### 代码示例 - 数值（大于等于&小于等于）
```php
[
    'type' => 'number',
    'minimum' => 1,
    'maximum' => 10,
    'title' => '数值-大于等于&小于等于',
    'description' => '该数值必须符合 1 ≦ number ≦ 10',
]
```

#### 代码示例 - 数值（大于&小于）
```php
[
    'type' => 'number',
    'minimum' => 1,
    'maximum' => 10,
    'exclusiveMinimum' => true,
    'exclusiveMaximum' => true,
    'title' => '数值-大于&小于',
    'description' => '该数值必须符合 1 ﹤ number ﹤ 10',
]
```

#### 代码示例 - 数值（倍数）
```php
[
    'type' => 'number',
    'minimum' => 2,
    'title' => '数值-倍数',
    'description' => '该数值必须是2的倍数',
]
```
#### 代码示例 - 整数
>数值类型的格式化方式同样适用于整数，这里就不再列举整数的格式化例子了。
```php
[
    'type' => 'integer',
    'example' => 9527,
    'description' => '整数型数据',
    'title' => '整数',
]
```

#### 代码示例 - 数组（普通）
```php
[
    'type' => 'array',
    'title' => '数组-普通',
    'example' => ['a', 'b', 'c'],
    'description' => '数组类型数据',
    'items' => [
    	'type' => 'string'
    ]
]
```

#### 代码示例 - 数组（复杂类型1）
```php
[
    'type' => 'array',
    'title' => '数组-复杂类型1',
    'example' => [[0, 1], [0, 1], [0, 1]],
    'description' => '数组类型数据',
    'items' => [
        'type' => 'array',
        'items' => [
        	'type' => 'integer'
        ]
    ]
]
```

#### 代码示例 - 数组（复杂类型2）
```php
[
    'type' => 'array',
    'title' => '数组-复杂类型2',
    'example' => [
    	['name' => 'keven'], 
    	['name' => 'rouse'], 
    	['name' => 'jack']
    ],
    'description' => '数组类型数据',
    'items' => [
        'type' => 'object',
        'items' => [
        	'type' => 'string'
        ]
    ]
]
```

#### 代码示例 - 数组（混合类型）
>多种类型的混合数组
```php
[
    'type' => 'array',
    'title' => '数组-混合类型',
    'example' => ['kinv', 9527],
    'description' => '数组类型数据',
    'items' => [
        'oneOf' => [
            ['type' => 'string'],
            ['type' => 'integer'],
        ]
    ]
]
```

#### 代码示例 - 数组（任意类型）
>注意任意类型与混合类型不同，任意类型的数组，元素可以是任意类型的数据
```php
[
    'type' => 'array',
    'title' => '数组-任意类型',
    'example' => ['kinv', 9527, ['name' => 'kinv']],
    'description' => '数组类型数据',
    'items' => []
]
```

#### 代码示例 - 数组（长度限制）
```php
[
    'type' => 'array',
    'title' => '数组-长度限制',
    'example' => [0, 1, 2, 3, 4, 5],
    'description' => '数组元素最少是一个；最多有10个',
    'items' => [
    	'type' => 'integer'
    ],
    'minItems' => 1,
    'maxItems' => 10,
]
```

#### 代码示例 - 数组（元素唯一性）
```php
[
    'type' => 'array',
    'title' => '数组-元素唯一性',
    'example' => [0, 1, 2, 3, 4, 5],
    'description' => '数组中的元素不能重复',
    'items' => [
    	'type' => 'integer'
    ],
    'uniqueItems' => true,
]
```

#### 代码示例 - 对象类型
```php
[
    'type' => 'object',
    'title' => '对象类型',
    'properties' => [
        'name' => [
            'type' => 'string',
            'example' => 'kinv',
            'description' => '姓名',
        ],
        'age' => [
            'type' => 'integer',
            'example' => 18,
            'description' => '年龄',
        ]
    ],
]
```

#### 代码示例 - 枚举数据
```php
[
    'type' => 'string',
    'example' => 'kinv',
    'title' => '枚举数据',
    'description' => '枚举',
    'enum' => ['kinv', 'google', 'facebook'],
]
```

### 数据格式化
<a name="format"></a>

type | format | 描述
--- | --- | ---
boolean | - | `true` or `false`
number | - | 数值 
number | float | 单精度浮点数
number | double | 双精度浮点数
integer | - | 整数
integer | int32 | 有符号32位整数
integer | int64 | 有符号64位整数
string | - | 字符串 
string | byte | base64编码的字符
string | binary | 二进制数据 
string | date | 日期类型，例如`2012-12-12`
string | date-time | 完整日期类型，例如`2012-12-12 12:00:00`
string | password | 模糊输入
string | email | 【非规范】邮箱 
string | uuid | 【非规范】UUID 
string | uri | 【非规范】URI 
string | hostname | 【非规范】hostname 
string | ipv4 | 【非规范】ipv4 
string | ipv6 | 【非规范】ipv6 

