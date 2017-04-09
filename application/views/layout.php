<html>
<head>
    <title></title>
    <link rel="stylesheet" href="/static/css/bootstrap.css">
    <link rel="stylesheet" href="/static/css/app.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/js/bootstrap.js"></script>
    <script>
      var baseUrl = 'localhost';
      var util = [];
      
      util.getJson = function(url, success){
        var url = baseUrl + '/' + url;
        url = url.replace(/\/+/,'\/');
        url = 'http://' + url;
        $.get(url,success,'json');
      };
    </script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/gallery">Gallery</a></li>
            <li><a href="/image/submit">Submit</a></li>
        </div>
      </div>
    </nav>

	<?php $this->load->view($content);?>
</body>
</html>