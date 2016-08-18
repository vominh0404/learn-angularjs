
<?php
require(dirname(__FILE__).'/vendor/autoload.php');
define('SMTP_HOST', 'smtp.zoho.com');
define('SMTP_USERNAME', 'no-reply@crowdhubgroup.com');
define('SMTP_PASSWORD', 'n0r3ly@456');
define('EMAIL_FROM_EMAIL', 'no-reply@crowdhubgroup.com');
define('EMAIL_FROM_NAME', 'Hexsee');
global $_RECIPIENTS, $_BCC;
$_RECIPIENTS = array(
        'trong@gkxim.com' => 'Trong'
    );
$_BCC = array(
        'trong@gkxim.com' => 'Trong'
    );

$isSubmitted = false;

if(isset($_GET['thanks'])){
    $isSubmitted = true;
}

if(!empty($_POST)){
    $current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $notification_content = file_get_contents(dirname(__FILE__).'/email-templates/notification.html');
    $entry = array();
    foreach($_POST as $key => $value){
        $notification_content = str_replace('{{{'.$key.'}}}', $value, $notification_content);
        $entry[] = $value;
    }
    $notification_content = str_replace('{{{times}}}', date('Y-m-d H:i:s'), $notification_content);
    // Append 
    date_default_timezone_set('Asia/Singapore');
    $entry[] = date('Y-m-d H:i:s');
    // Append to CSV
    $file = new SplFileObject('form-entries.json', 'a');
    $file->fputcsv($entry);

    // Send notification email
    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                         // Enable verbose debug output

    $mail->isSMTP();                                // Set mailer to use SMTP
    $mail->Host = SMTP_HOST;                        // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                         // Enable SMTP authentication
    $mail->Username = SMTP_USERNAME;                // SMTP username
    $mail->Password = SMTP_PASSWORD;                // SMTP password
    $mail->SMTPSecure = 'ssl';                      // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                              // TCP port to connect to
    $mail->Mailer = "smtp";

    $mail->setFrom(EMAIL_FROM_EMAIL, EMAIL_FROM_NAME);
    foreach($_RECIPIENTS as $email => $name){
        $mail->addAddress($email, $name); 
    }
    foreach($_BCC as $email => $name){
        $mail->addBCC($email, $name);    
    }

    $mail->isHTML(true);                            // Set email format to HTML

    $mail->Subject = 'Hexsee web site interest';
    $mail->Body    = $notification_content;

    if($mail->send()) {
        header('Location: '. $current_link. '?thanks');
    }
}
?>
<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> -->

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Hexsee CI Page</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <header>
        <div class="container">
            <div class="col-sm-12">
                <div class="logo">
                    <h1><a href="" title=""><img src="img/logo.png" alt="logo hexsee"></a></h1>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="col-sm-12">
                <div class="content row">
                    <div class="col-sm-7">
                        <h2>Pin messages to any web page</h2></div>
                    <div class="col-sm-5">
                        <p>Be the first to get hexsee</p>
                        <div class="form-notify">
                            <form id="form-entry-event" method="POST">
                                <input id="notify" type="text" name="email" placeholder="enter your email address" />
                                <button type="submit" title="Go" class="button">Notify Me</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="sevice">
                <li>
                    <div class="col-sm-7 text-center"><img src="img/pin.png" alt=""></div>
                    <div class="col-sm-5 item">
                        <label>1</label>
                        <p>Chat about hexsee pins right in the browser.</p>
                    </div>
                </li>
                <li>
                    <div class="col-sm-7 text-center"><img src="img/3D-button.png" alt=""></div>
                    <div class="col-sm-5 item">
                        <label>2</label>
                        <p>Easier than any other social network. Just drag the hexsee share button to start a pin then press Send!</p>
                    </div>
                </li>
                <li>
                    <div class="col-sm-7 text-center"><img src="img/message.png" alt=""></div>
                    <div class="col-sm-5 item">
                        <label>3</label>
                        <p>hexsee pins automatically include a web snippet of where the pin is.</p>
                    </div>
                </li>
                <li>
                    <div class="col-sm-7 text-center"><img src="img/main-bar.png" alt=""></div>
                    <div class="col-sm-5 item">
                        <label>4</label>
                        <p>With hexsee Channels, publish pins and pictures to your friends, keep to yourself or go public! hexsee delivers pin notifications with one touch jump to the pin location or quick reply.</p>
                    </div>
                </li>
                <li>
                    <div class="col-sm-7 text-center"><img src="img/pin-doodle.png" alt=""></div>
                    <div class="col-sm-5 item">
                        <label>5</label>
                        <p>Pin doodles to the live web and so much more…”</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="col-sm-5">
                <div class="logo">
                    <h2><a href="" title=""><img src="img/logo-footer.png" alt=""></a></h2>
                </div>
            </div>
            <div class="col-sm-7">
                <h3>Be the first to get hexsee</h3>
                <div class="form-notify">
                    <form id="form-entry-event-f" method="POST">
                        <input id="notify" type="text" name="email" placeholder="enter your email address" />
                        <button type="submit" title="Go" class="button">Notify Me</button>
                    </form>
                </div>
                <p><strong>Privacy Policy.</strong> We will not share your email address with any third party. Separate Terms of Use apply to the hexsee service and these will be provided st sign-up.</p>
                <p>Got a question? email us: <a href="mailto:info@groupsurfing.com" title="">info@groupsurfing.com</a></p>
                <ul class="social">
                    <li><a href="" title=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="" title=""><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a href="" title=""><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    <li><a href="" title=""><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</html>