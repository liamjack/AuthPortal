<html>
    <head>
        <meta charset="utf-8">
        <title>lab.cuonic.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/base-min.css">
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="big"><i class="fa fa-exclamation-triangle"></i></div>
        <h1>Error 500</h1>
        <h2>An error has been encountered on the server</h2>
        <p>
            Error : <?php echo $message; ?><br/>
            File : <?php echo $file; ?>:<?php echo $line; ?>
        </p>
    </body>
</html>
