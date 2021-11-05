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
//                "loginSuccess" => $this->modelLoginSuccess(),
            ],
        ];

        // API
        $paths = [
//            '/version' => $this->apiVersion(),
            '/version' => [
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
                ]
            ],
        ];

        // 标记
        $tags = [
            [
                'name' => 'pet',
                'description' => 'pets operations',
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
            ]
        ];
    }


    /**▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲[ API 列 表 结 束 ]▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲**/


    /**▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼[ 模 型 列 表 开 始 ]▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼**/


    /**▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲[ 模 型 列 表 结 束 ]▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲**/

}
