<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    const VERSION = '1.0.0';

    public $api_path_prefix = 'https://www.apidoc.test/api/v1';

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
                'url' => $this->api_path_prefix,
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
//                "loginSuccess" => $this->modelLoginSuccess(),
            ],
        ];

        // API
        $paths = [
//            '/login' => $this->apiLogin(),
        ];

        $tags = [
            [
                'name'=>'pet',
                'description'=>'pets operations',
//                '$external_docs'=>
            ]

        ];

        $external_docs = [
                'description'=>'开发人员主页',
                'url'=>'https://www.kinvcode.com',
        ];

        return [
            'openapi' => $openApi,
            'info' => $info,
            'servers' => $servers,
            'schemes' => $schemes,
            'paths' => $paths,
            'components' => $components,
            'tags' => $tags,
            'externalDocs'=>$external_docs
        ];
    }

    public function openApiJson()
    {
        $data = $this->makeOpenAPiToJson();
        return new JsonResponse($data);
    }
}
