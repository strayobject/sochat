$(function() {
    onRoomLoad();
});

function onRoomLoad()
{
    var connect = $('#button-connect');
    var exit    = $('.button-exit');

    startChat();
    exit.on('click', exitChat);
    window.addEventListener("beforeunload", function (event) {
      exitChat();
    });
}

function startChat()
{
    var conn = new WebSocket('ws://dev.sochat.net:8080');

    conn.onopen = function(e) {
        //console.log('Connection established!');
        sendMessage(conn, 'COM: ' + getUserAlias() + ' has joined the conversation.', $('#box-msg'));
        updateUserList();
    };

    conn.onmessage = function(e) {
        appendToBox($('#box-msg'), e.data);
    };

    $('#input-submit').on('click', {'conn' : conn}, function(event) {
        sendMessage(event.data.conn, $('#input-msg'), $('#box-msg'));
    });

    $('#input-msg').on('keypress', {'conn' : conn}, function(event) {
        if (event.which == 13) {
            sendMessage(event.data.conn, $('#input-msg'), $('#box-msg'));
        }
    });

    window.conn = conn;
}

function exitChat()
{
    sendMessage(window.conn, 'COM: ' + getUserAlias() + ' has left the conversation.', $('#box-msg'));
    window.conn.close()
    //console.log('Connection closed!');
    window.location = '/';
}

function sendMessage(conn, input, box)
{
    if (typeof input === 'string') {
        var msg = input;

    } else {
        // this is a hack
        var msg = getUserAlias() + ': ' + input.val();
        input.prop('value', '');
    }

    conn.send(msg);
    appendToBox(box, msg);
}

function appendToBox(box, data)
{
    var date = new Date();
    var time = date.toTimeString().substr(0,8);

    box.append('<div>['+time+'] '+data+'</div>');
}

function getUserAlias()
{
    var uname = $('#uname').val();

    if (uname === '') {
        uname = 'Guest';
    }

    return uname;
}

function updateUserList()
{
    setInterval(function() {
        $.get('/ajax/userlist', function( data ) {
          $('#userList').html( data );
        });
    }, 3000);
}