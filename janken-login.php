<?php
/*
Plugin Name: Janken Login
Author: Takayuki Miyauchi
Plugin URI: http://wpist.me/
Description: Allow to display login screen to JANKEN winner only.
Version: 1.3.1
Author URI: http://wpist.me/
Domain Path: /languages
Text Domain: janken-login
*/

$janken = new Janken_Login();

class Janken_Login {

function __construct()
{
    add_action('plugins_loaded', array($this, 'plugins_loaded'));
}

function plugins_loaded()
{
    add_action('login_enqueue_scripts', array($this, 'login_enqueue_scripts'));
    add_action('login_head', array($this, 'login_head'));
    add_action('login_init', array($this, 'login_init'));
    add_action('login_form', array($this, 'login_form'));
}

function login_enqueue_scripts()
{
    wp_enqueue_script(
        'leapjs',
        '//js.leapmotion.com/0.2.0-beta6/leap.min.js',
        array(),
        '0.2.0',
        true
    );
    wp_enqueue_script(
        'janken-js',
        plugins_url('/js/janken-login.js', __FILE__),
        array('jquery', 'leapjs'),
        '0.1.0',
        true
    );
}

function login_form()
{
    if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'janken')) {
        echo '<input type="hidden" name="nonce" value="'.esc_attr($_REQUEST['nonce']).'">';
    }
}

function login_init()
{
    if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'janken')) {
        return;
    }

    login_header();
}

function login_head()
{
    if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'janken')) {
        return;
    }
?>
<style type="text/css">
#janken
{
    width: 644px;
    margin: 30px auto;
}
.janken
{
    width: 300px;
    height: 300px;
    float: left;
    margin: 10px;
    border: 1px solid #dedede;
    border-radius: 5px;
    text-align: center;
}
.janken img
{
    margin: 40px 0;
}
.count
{
    font-size: 100px;
    line-height: 300px;
    text-align: center;
}
</style>
<script type="text/javascript">
var img = {
    goo: '<?php echo plugins_url('', __FILE__); ?>/img/goo.png',
    choki: '<?php echo plugins_url('', __FILE__); ?>/img/choki.png',
    par: '<?php echo plugins_url('', __FILE__); ?>/img/par.png'
};
var nonce = '<?php echo wp_create_nonce('janken'); ?>';
</script>
</head>
<body>
<h1 style="text-align:center; margin: 40px 0;">You must win the JANKEN before login.</h1>
<div id="janken">
    <div id="janken-cpu" class="janken"></div>
    <div id="janken-you" class="janken"></div>
</div>
<br clear="all" />
<h2 id="result" style="text-align:center; margin: 40px 0;color:#ff0000;"></h2>
<div style="display:none;">
<?php
    login_footer();
    exit;
}

}

