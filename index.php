<?php

require __DIR__.'/vendor/autoload.php';

echo '<html>';
echo '<title>soChat</title>';
echo '<script>';
echo "

var conn = new WebSocket('ws://dev.sochat.net:8080');

window.onload = load(conn);

function load(conn)
{
    document.getElementById('button-connect').onClick(startChat(conn));
}

function startChat(conn)
{
    conn.onopen = function(e) {
        console.log('Connection established!');
    };

    conn.onmessage = function(e) {
        console.log(e.data);
   };
}
";
echo '</script>';
echo '<body>';
echo '<a id="button-connect" href="#connect">Join a chat!</a>';
echo '<a id="button-exit" href="#exit">Exit!</a>';
echo '</body>';
echo '</html>';