<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    const VERSION = '1.0.0';

    public $title = '【 xx公司 】API文档';

    public $description = '该文档仅供本公司内部员工使用';

    protected function docInfo()
    {
        return [
            // 文档描述
            'description' => $this->description,
            // 文档版本
            'version' => self::VERSION,
            // 文档标题
            'title' => $this->title,
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
            ]
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
                "number" => $this->modelOfNumber(),
                "integer" => $this->modelOfInteger(),
                "array" => $this->modelOfArray(),
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
            '/response' => $this->apiResponse(),
            '/request' => $this->apiRequest(),
            '/request/file' => $this->apiRequestForFile(),
        ];

        return [
            'openapi' => $openApi,
            'info' => $info,
            'servers' => $servers,
            'schemes' => $schemes,
            'paths' => $paths,
            'components' => $components,
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

    public function apiResponse()
    {
        return [
            'get' => [
                'tags' => ['响应体'],
                'summary' => "普通响应体",
                'responses' => [
                    '200' => [
                        'description' => '成功获取数据',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'info' => [
                                            'type' => 'string',
                                            'example' => '数据结构',
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ],
                    'default' => [
                        'description' => '获取数据失败',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'status' => [
                                            'type' => 'integer',
                                            'example' => -1,
                                        ],
                                        'msg' => [
                                            'type' => 'string',
                                            'example' => 'fail',
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

    public function apiRequest()
    {
        return [
            'post' => [
                'tags' => ['请求体'],
                'summary' => "普通请求体",
                'requestBody' => [
                    'description' => '请求体描述',
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => [
                                        'type' => 'string',
                                        'example' => 'kinv'
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => '成功获取数据',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'string',
                                            'example' => 'kinv',
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ],
                ]
            ],
        ];
    }

    public function apiRequestForFile()
    {
        return [
            'post' => [
                'tags' => ['请求体'],
                'summary' => "带有文件的请求",
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'required' => ['avatar', 'type'],
                                'properties' => [
                                    'avatar' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                        'description' => '图片文件：jpg,jpeg,png'
                                    ],
                                    'type' => [
                                        'type' => 'string',
                                        'enum' => ['avatar'],
                                        'example' => 'avatar',
                                        'description' => '图片的类型'
                                    ],
                                ],
                            ]
                        ]
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => '成功获取数据',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'file_name' => [
                                            'type' => 'string',
                                            'example' => 'demo.jpg',
                                        ],
                                    ],
                                ]
                            ]
                        ]
                    ],
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

    public function modelOfNumber()
    {
        return [
            'type' => 'number',
            'example' => 3.1415926,
            'description' => '数值类型数据',
            'title' => '数值-基础',
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
