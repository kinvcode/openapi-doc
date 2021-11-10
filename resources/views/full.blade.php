<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OpenApi文档</title>
    <meta name="keywords" content="OpenApi,Swagger,SwaggerUI,OpenAPI文档"/>
    <meta name="description" content="基于swaggerUI和OpenAPI构建的api文档"/>
    <link rel="stylesheet" href="static/swagger/swagger-ui.css">
    <script src="static/swagger/swagger-ui-bundle.js"></script>
    <script src="static/swagger/swagger-ui-standalone-preset.js"></script>
</head>
<body>
<div id="swagger-ui"></div>
</body>
<script>
  window.onload = function () {
    const ui = SwaggerUIBundle({
      url: "json/full",
      dom_id: '#swagger-ui',
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIBundle.SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
      ],
    });

    window.ui = ui
  }
</script>
</html>
