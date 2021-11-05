# Info Object

该对象提供API的基本数据

字段 | 类型 | 描述
--- | --- | ---
title | string | 【必须】应用标题
version | string | 【必须】版本号
description | string | 描述
contact | [Contact Object](#contactObject) | 联系信息

### 示例
```php
[
    'description' => '该文档仅供本公司内部员工使用',
    'version' => '1.0.0',
    'title' => '【 xx公司 】API文档',
    'contact' => [],
];
```

## Contact Object
<a name="contactObject"></a>

### 固定字段
字段 | 类型 | 描述
--- | --- | ---
name | string | 联系人名字
url | string | 必须是url格式
email | string | 必须是邮件地址格式

### 示例
```php
[
    'contact' => [
        'name' => 'kinv',
        'url' => 'https://www.kinvcode.com',
        'email' => 'kinvcode@gmail.com',
    ]
];
```