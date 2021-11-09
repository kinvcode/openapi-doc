<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiFullDocController extends Controller
{
    const VERSION = '1.0.0';

    public $title = '【 xx公司 】API文档';

    public $description = '该文档仅供本公司内部员工使用';

    public $contact_email = 'kinvcode@gmail.com';

    protected function docInfo()
    {
        return [
            // 文档描述
            'description' => $this->description,
            // 文档版本
            'version' => self::VERSION,
            // 文档标题
            'title' => $this->title,
            // 联系方式
            'contact' => [
                'email' => $this->contact_email,
                'name' => 'Kinv',
                'url' => 'https://www.kinvcode.com'
            ],
        ];
    }

    final public function makeOpenAPiToJson()
    {
        // swagger版本
        $openApi = '3.0.0';
        // 文档基础信息
        $info = $this->docInfo();
        // 服务端
        $servers = [
            [
                'url' => 'http://openapi-doc.test/api/v1',
            ],
            [
                'url' => 'http://openapi-doc.test/api/v2',
                'description' => '开发环境服务器',
            ],
            [
                'url' => 'http://{domain}:{port}/api/{version}', // http://openapi-doc.test:80/api/v1
                'description' => '生产环境服务器',
                'variables' => [
                    'domain' => [
                        'default' => 'openapi-doc.test',
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
                ],
            ],
        ];
        // 通信协议
        $schemes = ['http', 'https'];
        // 组件
        $components = [
            'securitySchemes' => [
                'bearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                ]
            ],
            'schemas' => [
                "boolean" => $this->modelOfBoolean(),
                "string" => $this->modelOfString(),
                "stringLength" => $this->modelOfStringLength(),
                "stringFormat" => $this->modelOfStringFormat(),
                "stringPattern" => $this->modelOfStringPattern(),
                "number" => $this->modelOfNumber(),
                "numberLength" => $this->modelOfNumberLength(),
                "numberLength2" => $this->modelOfNumberLength2(),
                "numberMultiple" => $this->modelOfNumberMultiple(),
                "integer" => $this->modelOfInteger(),
                "array" => $this->modelOfArray(),
                "arrayComplex1" => $this->modelOfArrayComplex(),
                "arrayComplex2" => $this->modelOfArrayComplex2(),
                "arrayMixed" => $this->modelOfArrayMixed(),
                "arrayArbitrary" => $this->modelOfArrayArbitrary(),
                "arrayLength" => $this->modelOfArrayLength(),
                "arrayUnique" => $this->modelOfArrayUnique(),
                "object" => $this->modelOfObject(),
                "enum" => $this->modelOfEnum(),
            ],
        ];

        // API
        $paths = [
            '/version' => $this->apiVersion(),
            '/auth/register' => $this->apiRegister(),
            '/auth/login' => $this->apiLogin(),
            '/users/{id}' => $this->apiUserInfo(),
            '/user/name' => $this->apiUserName(),
            '/user/id' => $this->apiUserID(),
            '/debug' => $this->ApiDebug(),
            '/me/collection/{id}' => $this->apiNewMyCollection(),


            // 其他
            '/me/collection' => $this->apiMyCollection(),
        ];

        // 标记
        $tags = [
            [
                'name' => 'developer',
                'description' => 'developer homepage',
                'externalDocs' => [
                    'description' => '开发人员主页',
                    'url' => 'https://www.kinvcode.com',
                ]
            ],
        ];

        //
        $external_docs = [
            'description' => '开发人员主页',
            'url' => 'https://www.kinvcode.com',
        ];

        return [
            'openapi' => $openApi,
            'info' => $info,
            'servers' => $servers,
            'schemes' => $schemes,
            'paths' => $paths,
            'components' => $components,
            'tags' => $tags,
            'externalDocs' => $external_docs
        ];
    }

    public function openApiJson()
    {
        $data = $this->makeOpenAPiToJson();
        return new JsonResponse($data);
    }

    /**▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼[ API 列 表 开 始 ]▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼**/

    public function apiVersion()
    {
        return [
            'get' => [
                'tags' => ['基础'],
                'summary' => "基础的GET请求",
                'responses' => [
                    '200' => [
                        'description' => '版本信息',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'version' => [
                                            'type' => 'string',
                                            'example' => '1.0.0',
                                            'description' => '版本信息'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiRegister()
    {
        return [
            'post' => [
                'tags' => ['基础'],
                'summary' => "基础的POST请求",
                'description' => '该请求只返回固定的用户信息',
                'responses' => [
                    '200' => [
                        'description' => '用户信息',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => ['type' => 'string'],
                                        'email' => ['type' => 'string'],
                                        'updated_at' => ['type' => 'string'],
                                        'created_at' => ['type' => 'string'],
                                        'id' => ['type' => 'integer'],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiLogin()
    {
        return [
            'post' => [
                'tags' => ['请求参数'],
                'summary' => "通过请求体传参数",
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'required' => ['email', 'password'],
                                'properties' => [
                                    'email' => [
                                        'type' => 'string',
                                        'example' => 'kinvcode@gmail.com',
                                        'description' => '邮箱'
                                    ],
                                    'password' => ['type' => 'string', 'example' => '123456', 'description' => '密码']
                                ],
                            ]
                        ]

                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => '用户信息',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => ['type' => 'integer'],
                                        'name' => ['type' => 'string'],
                                        'email' => ['type' => 'string'],
                                        'email_verified_at' => ['type' => 'string'],
                                        'created_at' => ['type' => 'string'],
                                        'updated_at' => ['type' => 'string'],
                                        'api_token' => ['type' => 'string'],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiUserInfo()
    {
        return [
            'get' => [
                'tags' => ['请求参数'],
                'summary' => "URL路径参数",
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
                'responses' => [
                    '200' => [
                        'description' => '用户信息',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'example' => 1,
                                            'description' => '用户ID'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiUserName()
    {
        return [
            'get' => [
                'tags' => ['请求参数'],
                'summary' => "query参数",
                'parameters' => [
                    [
                        'name' => 'name',
                        'in' => 'query',
                        'required' => true,
                        'schema' => [
                            'type' => 'string',
                        ],
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => '用户信息',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'string',
                                            'example' => 'kinv',
                                            'description' => '用户名'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiUserID()
    {
        return [
            'get' => [
                'tags' => ['请求参数'],
                'summary' => "header参数",
                'parameters' => [
                    [
                        'name' => 'X-Request-ID',
                        'in' => 'header',
                        'required' => true,
                        'schema' => [
                            'type' => 'integer',
                        ],
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => '用户信息',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'example' => 1,
                                            'description' => '用户ID'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function ApiDebug()
    {
        return [
            'get' => [
                'tags' => ['请求参数'],
                'summary' => "cookie参数",
                'parameters' => [
                    [
                        'name' => 'debug',
                        'in' => 'cookie',
                        'required' => true,
                        'schema' => [
                            'type' => 'boolean',
                        ],
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => '调试模式',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'debug' => [
                                            'type' => 'boolean',
                                            'example' => false,
                                            'description' => 'debug'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiMyCollection()
    {
        return [
            'get' => [
                'tags' => ['其他'],
                'summary' => "已弃用的API",
                'description' => '展示我的收藏列表',
                'operationId' => 'me-collection',
                'deprecated' => true,
                'parameters' => [],
                'responses' => [
                    '200' => [
                        'description' => '收藏数据',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'info' => [
                                            'type' => 'string',
                                            'example' => '数据结构',
                                            'description' => '收藏信息'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function apiNewMyCollection()
    {
        return [
            'get' => [
                'tags' => ['权限认证'],
                'summary' => "权限认证API",
                'description' => '展示我的收藏列表',
                'operationId' => 'me-collection-id',
                'deprecated' => false,
                'parameters' => [],
                "security" => [
                    ['bearerAuth' => []]
                ],
                'responses' => [
                    '200' => [
                        'description' => '收藏数据',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'info' => [
                                            'type' => 'string',
                                            'example' => '数据结构',
                                            'description' => '收藏信息'
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }


    /**▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲[ API 列 表 结 束 ]▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲**/


    /**▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼[ 模 型 列 表 开 始 ]▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼**/


    public function modelOfBoolean()
    {
        return [
            'type' => 'boolean',
            'example' => false,
            'description' => '布尔类型数据',
            'title' => '布尔数据'
        ];
    }

    public function modelOfString()
    {
        return [
            'type' => 'string',
            'example' => 'kinvcode',
            'description' => '字符串类型数据',
            'title' => '字符串-基础'
        ];
    }

    public function modelOfStringLength()
    {
        return [
            'type' => 'string',
            'example' => 'kinvcode',
            'title' => '字符串-长度限制',
            'minLength' => 3,
            'maxLength' => 10,
        ];
    }

    public function modelOfStringFormat()
    {
        return [
            'type' => 'string',
            'example' => 'kinvcode',
            'title' => '字符串-格式化',
            'format' => 'password',
        ];
    }

    public function modelOfStringPattern()
    {
        return [
            'type' => 'string',
            'example' => 'kinvcode',
            'title' => '字符串-正则匹配',
            'pattern' => '^\d{3}-\d{2}-\d{4}$',
        ];
    }

    public function modelOfNumber()
    {
        return [
            'type' => 'number',
            'example' => 3.1415926,
            'description' => '数值类型数据',
            'title' => '数值-基础',
        ];
    }

    public function modelOfNumberLength()
    {
        return [
            'type' => 'number',
            'minimum' => 1,
            'maximum' => 10,
            'title' => '数值-大于等于&小于等于',
            'description' => '该数值必须符合 1 ≦ number ≦ 10',
        ];
    }

    public function modelOfNumberLength2()
    {
        return [
            'type' => 'number',
            'minimum' => 1,
            'maximum' => 10,
            'exclusiveMinimum' => true,
            'exclusiveMaximum' => true,
            'title' => '数值-大于&小于',
            'description' => '该数值必须符合 1 ﹤ number ﹤ 10',
        ];
    }

    public function modelOfNumberMultiple()
    {
        return [
            'type' => 'number',
            'minimum' => 2,
            'title' => '数值-倍数',
            'description' => '该数值必须是2的倍数',
        ];
    }

    public function modelOfInteger()
    {
        return [
            'type' => 'integer',
            'example' => 9527,
            'description' => '整数型数据',
            'title' => '整数',
        ];
    }

    public function modelOfArray()
    {
        return [
            'type' => 'array',
            'title' => '数组-普通',
            'example' => ['a', 'b', 'c'],
            'description' => '数组类型数据',
            'items' => [
                'type' => 'string'
            ]
        ];
    }

    public function modelOfArrayComplex()
    {
        return [
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
        ];
    }

    public function modelOfArrayComplex2()
    {
        return [
            'type' => 'array',
            'title' => '数组-复杂类型2',
            'example' => [['name' => 'keven'], ['name' => 'rouse'], ['name' => 'jack']],
            'description' => '数组类型数据',
            'items' => [
                'type' => 'object',
                'items' => [
                    'type' => 'string'
                ]
            ]
        ];
    }

    public function modelOfArrayMixed()
    {
        return [
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
        ];
    }

    public function modelOfArrayArbitrary()
    {
        return [
            'type' => 'array',
            'title' => '数组-任意类型',
            'example' => ['kinv', 9527, ['name' => 'kinv']],
            'description' => '数组类型数据',
            'items' => []
        ];
    }

    public function modelOfArrayLength()
    {
        return [
            'type' => 'array',
            'title' => '数组-长度限制',
            'example' => [0, 1, 2, 3, 4, 5],
            'description' => '数组元素最少是一个；最多有10个',
            'items' => [
                'type' => 'integer'
            ],
            'minItems' => 1,
            'maxItems' => 10,
        ];
    }

    public function modelOfArrayUnique()
    {
        return [
            'type' => 'array',
            'title' => '数组-元素唯一性',
            'example' => [0, 1, 2, 3, 4, 5],
            'description' => '数组中的元素不能重复',
            'items' => [
                'type' => 'integer'
            ],
            'uniqueItems' => true,
        ];
    }

    public function modelOfObject()
    {
        return [
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
        ];
    }

    public function modelOfEnum()
    {
        return [
            'type' => 'string',
            'example' => 'kinv',
            'title' => '枚举数据',
            'description' => '枚举',
            'enum' => ['kinv', 'google', 'facebook'],
        ];
    }


    /**▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲[ 模 型 列 表 结 束 ]▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲**/

}
