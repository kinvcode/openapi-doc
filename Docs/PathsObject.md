# PathsObject



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
```

###  Path Item Object
<a name=" PathItemObject"></a>

#### 固定字段

#### 代码示例