
### Paths Object
<a name="pathsObject"></a>


#### 匹配字段
字段 | 类型 | 描述
--- | --- | ---
/{path} | [Path Item Object](#PathItemObject) | API路径


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
<a name=" PathItemObject"></a>

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
parameters | [[Parameter Object](#parameterObject) \| [Reference Object](../README.md#referenceObject)] | 请求参数；多个请求时该字段可以共用


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
security | [Security Requirement Object](../README.md#SecurityRequirementObject) |【可选】权限认证， 如果是需要身份认证的API则为必须
parameters |[[Parameter Object](#parameterObject) \| [Reference Object](../README.md#referenceObject)] | 请求参数
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

