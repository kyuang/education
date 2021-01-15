
<html>
<head>
    <title>Bootstrap</title>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="row" style="height:80px; background-color: red;"></div>
        <div class="row">
            <?php for($i=1;$i<10;$i++){?>
                <a href="#">
                 <div class="col-md-2" style="padding: 5px;border: 3px solid white;background-color: #a6e1ec;">
                     <p style="height: 60px; line-height: 60px;text-align: center">我们的祖国是花园</p>
                 </div>
                </a>
            <?php }?>
        </div>
    </div>
</body>
</html>