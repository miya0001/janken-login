(function($){
var timer = setInterval(wait, 1000);
var sleep = 3;
var you = 'goo';
var start = false;
$('#janken-you').html($('<img />', {src: img[you]}));
Leap.loop({enableGestures: true}, function(obj) {
    var hands = obj.hands.length;
    var fingers = obj.pointables.length;

    if (hands && start === false) {
        if (fingers === 5) {
            you = 'par';
        } else if (fingers === 2) {
            you = 'choki';
        } else {
            you = 'goo';
        }
        $('#janken-you').html($('<img />', {src: img[you]}));
    }
});

function wait(){
    if (sleep === 0) {
        start_game();
        clearInterval(timer);
        return;
    }
    $('#janken-cpu').html('<div class="count">'+sleep+'</div>');
    sleep = sleep - 1;
}

function start_game(){
    start = true;
    var rnd = Math.floor(Math.random()*3);
    var j = ['goo', 'choki', 'par'];
    var cpu = j[rnd];
    $('#janken-cpu').html($('<img />', {src: img[cpu]}));

    if (cpu === 'goo' && you === 'par') {
        $('#result').text('You Win! Please wait!');
        setTimeout(function(){location.href='/wp-login.php?nonce='+nonce}, 2000);
    } else if (cpu === 'choki' && you === 'goo') {
        $('#result').text('You Win! Please wait!');
        setTimeout(function(){location.href='/wp-login.php?nonce='+nonce}, 2000);
    } else if (cpu === 'par' && you === 'choki') {
        $('#result').text('You Win! Please wait!');
        setTimeout(function(){location.href='/wp-login.php?nonce='+nonce}, 2000);
    } else {
        $('#result').text('You lose!');
        setTimeout(function(){location.reload()}, 2000);
    }
}

})(jQuery);
