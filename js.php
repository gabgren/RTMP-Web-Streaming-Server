<?php
include('inc.php');

$result = array();
$result['result'] = 0;
$result['method'] = @$_POST['method'];
$result['time'] = Date('Y-m-d H:i:s');

$bail = false;
function bail()
{
    global $bail;
    $bail = true;
}


try {

    if ('login' == @$_POST['method']) {

        $_SESSION['password'] = md5(@$_POST['password']);
        $result['result'] = 1;
    }

    if ('create-session' == @$_POST['method']) {

        $time = time();
        $id = @$_POST['id'];

        $session = $db_sessions->get($id);

        $session->time          = $time;
        $session->id            = $id;
        $session->name          = @$_POST['name'];
        $session->project       = @$_POST['project'];
        $session->artist        = @$_POST['artist'];
        $session->contact       = @$_POST['contact'];
        $session->type          = @$_POST['type'];
        $session->embed_code    = @$_POST['embed_code'];
        $session->service       = @$_POST['service'];
        $session->deleted       = @$_POST['deleted'];
        $session->save();

        $result['id'] = $id;
        $result['result'] = 1;
    }

    if ('get-session' == @$_POST['method']) {

        $id = @$_POST['id'];

        $session = $db_sessions->get($id);

        $result['id']           = $session->id;
        $result['name']         = $session->name;
        $result['project']      = $session->project;
        $result['artist']       = $session->artist;
        $result['contact']      = $session->contact;
        $result['type']         = $session->type;
        $result['embed_code']   = $session->embed_code;
        $result['service']      = $session->service;
        $result['deleted']      = $session->deleted;

        $result['result'] = 1;
    }

    if ('delete-session' == @$_POST['method']) {

        $id = @$_POST['id'];

        $session = $db_sessions->get($id);
        $session->deleted = 'true';
        $session->save();

        $result['result'] = 1;
    }
} catch (Exception $e) {
    $result['error'] = 'Caught Exception: ' .  $e->getMessage();
}

if (!$bail) {
    echo json_encode($result);
}
