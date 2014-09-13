<?php

require __DIR__.'/vendor/autoload.php';
?>
<html>
    <head>
        <title>soChat</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
            $(function() {
                load();
            });

            function load()
            {
                var button = $('#button-connect');
                button.on('click', startChat);
            }

            function startChat()
            {
                var conn = new WebSocket('ws://dev.sochat.net:8080');

                conn.onopen = function(e) {
                    console.log('Connection established!');
                };

                conn.onmessage = function(e) {
                    appendToBox($('#box-msg'), e.data);
                };

                $('#input-submit').on('click', {'conn' : conn}, function(event) {

                    var conn = event.data.conn;
                    var msg = $('#input-msg').val();
                    conn.send(msg);
                    appendToBox($('#box-msg'), msg);
                });

                window.conn = conn;
            }

            function appendToBox(box, data)
            {
                var date = new Date();
                var time = date.toTimeString().substr(0,8);

                box.append('<div>['+time+'] '+data+'</div>');
            }
        </script>
        <style>
        .box-msg {width:500px;height:300px;border:1px solid black;}
        </style>
    </head>
    <body>
        <a id="button-connect" href="#connect">Join a chat!</a>
        <br/><br/>
        <a id="button-exit" href="#exit">Exit!</a>
        <div id="box-msg" class="box-msg">

        </div><br/>
        <input type="text" id="input-msg"/><input id="input-submit" type="submit" value="post"/>
    </body>
</html>