<?php
include('inc.php');

$session = false;
if (@$_GET['session'] != '') {
    if (file_exists('db/sessions/' . $_GET['session'] . '.json')) {
        $session = $db_sessions->get($_GET['session']);
    }
}
if (!$session) {
    exit();
}

$fr = true;
$en = false;
if (@$_GET['lang'] == 'en') {
    $fr = false;
    $en = true;
}
$lang = $fr ? 'fr' : 'en';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/video-js.min.css">
    <link rel="stylesheet" href="/assets/style.css">
    <title>SHED | Live Session</title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160065452-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-160065452-3');
    </script>

</head>

<body>

    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel"><?php echo $fr ? 'Partager' : 'Share' ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <?php if ($fr) { ?>
                            Envoyez ce lien:
                        <?php } else { ?>
                            Share this link:
                        <?php } ?>
                    </p>
                    <input class="share-link" type="text" style="width:100%" value="http://<?php echo @$SERVER['SERVER_NAME']?>/<?php echo $lang ?>/<?php echo $session->id ?>"><br>
                    <button class="btn btn-primary mt-2" id="btn-copy-link" data-toggle="popover" data-content="<?php echo $fr ? 'Lien copié!' : 'Link copied to the clipboard' ?>"><?php echo $fr ? 'Copier' : 'Copy' ?></button>

                    <br><br><br>

                    <p class="lead">
                        <?php if ($fr) { ?>
                            Adresse RTMP:
                        <?php } else { ?>
                            RTMP Address:
                        <?php } ?>
                    </p>
                    <input class="rtmp-link" type="text" style="width:100%" value="rtmp://<?php echo @$SERVER['SERVER_NAME']?>/session/<?php echo $session->id ?>"><br>
                    <button class="btn btn-primary mt-2" id="btn-copy-rtmp" data-toggle="popover" data-content="<?php echo $fr ? 'Lien copié!' : 'Link copied to the clipboard' ?>"><?php echo $fr ? 'Copier' : 'Copy' ?></button>
                    <a href="/assets/rtmp_vlc.pdf" style="vertical-align: sub;" target="_blank"><i data-feather="help-circle"></i> Comment lire un lien RTMP?</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $fr ? 'Fermer' : 'Close' ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col">
                <img src="/assets/logo.png" width="100">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="embed-responsive embed-responsive-16by9">
                    <?php
                    switch ($session->service) {

                        case 'rtmp': ?>
                            <video id="rtmp-video" width="960" height="540" class="embed-responsive-item video-js vjs-default-skin" controls autoplay muted allowfullscreen>
                                <source src="http://<?php echo @$SERVER['SERVER_NAME']?>:8888/session/<?php echo $session->id ?>.m3u8" type="application/x-mpegURL">
                            </video>
                        <?php break;

                        case 'youtube': ?>
                            <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $session->embed_code ?>?controls=1&autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php break;

                        case 'vimeo': ?>
                            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?php echo $session->embed_code ?>?autoplay=1&muted=1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>

                    <?php break;
                    }
                    ?>
                </div>
            </div>
        </div>

        <hr>
        <div class="row mt-4">
            <div class="col">

                <h1><?php echo $session->name ?></h1>
            </div>
            <div class="col text-right">
                <i data-feather="share-2" style="cursor:pointer" data-toggle="modal" data-target="#shareModal"></i>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <?php if ($session->type != '') { ?><b><?php echo $session->type ?></b><br><?php } ?>
                        <?php if ($session->artist != '') { ?><b><?php echo $fr ? 'Artiste' : 'Artist' ?>: </b> <?php echo $session->artist ?><?php } ?>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
            <div class="col text-right">
                <b>Contact:</b><br>
                <?php echo str_replace(PHP_EOL, '<br>', $session->contact); ?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();

        $(document).ready(function() {
            $('#shareModal .share-link').focus(function() {
                $('#shareModal .share-link').select();
                $('#shareModal .share-link')[0].setSelectionRange(0, 99999);
                document.execCommand("copy");
            });

            $('#btn-copy-link').click(function() {
                $('#shareModal .share-link').select();
                $('#shareModal .share-link')[0].setSelectionRange(0, 99999);
                document.execCommand("copy");
            }).popover({
                placement: 'top'
            });

            $('#btn-copy-rtmp').click(function() {
                $('#shareModal .rtmp-link').select();
                $('#shareModal .rtmp-link')[0].setSelectionRange(0, 99999);
                document.execCommand("copy");
            }).popover({
                placement: 'top'
            });
        });
    </script>
    <?php if ($session->service == 'rtmp') { ?>
        <script src="/assets/video.min.js"></script>
        <script src="/assets/videojs-contrib-hls.min.js"></script>
        <script>
            var player = videojs('rtmp-video');
            player.play();
        </script>

    <?php } ?>
</body>

</html>