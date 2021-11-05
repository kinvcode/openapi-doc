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
info | [InfoObject](./Docs/InfoObject.md) | 【必须】文档基础信息 
servers | [[ServersObject](#serversObject)] |【必须】 服务器信息
paths | [PathsObject](./Docs/PathsObject.md) | 【必须】 API信息
components | [ComponentsObject](./Docs/ComponentsObject.md) | 【必须】组件
security | [[SecurityRequirementObject](#SecurityRequirementObject)] | 认证方式
tags | tag object | 暂时无需填写
externalDocs | [externalDocumentionObject](#externalDocumentionObject) | 拓展文档 

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

### ServersObject
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

### SecurityRequirementObject
<a name="SecurityRequirementObject"></a>

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

### externalDocumentionObject
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
### 引用对象及其用法
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