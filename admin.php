<?php
include('inc.php');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/style.css">
    <title>SHED | Live Session</title>
</head>

<body>

    <div class="container mt-5">

        <?php
        if (@$_SESSION['password'] != md5($config['password'])) {
        ?>
            <div class="row mt-5">
                <div class="col">
                    <form id="loginform">
                        <input type="password" id="password" name="password" placeholder="password">
                        <input type="submit" value="OK" id="login">
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>


            <div class="row">
                <div class="col">
                    <h1>Sessions</h1>
                    <hr>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col">
                    <div class="collapse" id="collapse">
                        <form id="new-session-form">
                            <input type="hidden" name="modify" id="modify" value="0">
                            <input type="hidden" name="deleted" id="deleted" value="false">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" name="id" id="id" value="<?php echo md5(time() . uniqid()); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nom public">
                            </div>
                            <div class="form-group">
                                <label for="project">Nom de projet</label>
                                <input type="text" class="form-control" id="project" name="project" placeholder="projet_1234">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" class="form-control" id="type" name="type" placeholder="Colo, Online, ...">
                            </div>
                            <div class="form-group">
                                <label for="artist">Nom de l'artiste qui pilote la session</label>
                                <input type="text" class="form-control" id="artist" name="artist" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <textarea class="form-control" id="contact" name="contact" rows="6">Lionel Courtiaud<?php echo PHP_EOL ?>lionel@shedmtl.com<?php echo PHP_EOL ?>514 571-7403</textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="embed-service" id="embed-service-rtmp" value="youtube">
                                    <label class="form-check-label" for="embed-service-rtmp">SHED RTMP Server</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="embed-service" id="embed-service-youtube" value="youtube">
                                    <label class="form-check-label" for="embed-service-youtube">YouTube</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="embed-service" id="embed-service-vimeo" value="youtube">
                                    <label class="form-check-label" for="embed-service-vimeo">Vimeo</label>
                                </div>
                            </div>
                            <div class="alert alert-primary" role="alert" id="rtmp-helper">
                                Stream URL: rtmp://<?php echo @$_SERVER['SERVER_NAME']?>/session/<br>
                                Stream Name/Key: <span id="rtmp-id"></span><br><br>
                                <a href="/assets/rtmp_liveu.jpg" target="_blank"><i data-feather="help-circle" style="cursor:pointer"></i> Comment configurer le LiveU Solo pour diffuser cette session?</a>
                            </div>
                            <div class="form-group" id="service-id">
                                <label for="artist">ID du vidéo</label>
                                <input type="text" class="form-control" id="embed-code" name="embed-code" placeholder="">
                            </div>
                        </form>
                    </div>
                    <button id="btn-create-session" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">
                        Créer une session
                    </button>
                    <button id="delete" class="btn btn-danger hide" type="button">
                        Supprimer
                    </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Projet</th>
                                <th scope="col">Type</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Lien</th>
                            </tr>
                            <?php
                            foreach ($db_sessions->where('deleted', '!=', 'true')->results() as $session) { ?>
                                <tr <?php if (@$_GET['added'] == $session['id']) {
                                        echo 'class="bg-primary text-white"';
                                    } ?>>
                                    <td><?php echo @$session['name'] ?></td>
                                    <td><?php echo @$session['project'] ?></td>
                                    <td><?php echo @$session['artist'] ?></td>
                                    <td><a href="#" class="modify" rel="<?php echo $session['id'] ?>">Modifier</a></td>
                                    <td><a href="/fr/<?php echo $session['id'] ?>">Ouvrir</a></td>
                                </tr>
                            <?php
                            } ?>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        <?php
        } ?>


    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        function gg_parseJSON(data) {
            var result = Array();
            if (data) {
                try {
                    result = $.parseJSON(data);
                } catch (err) {
                    result = {
                        "result": 0,
                        "error": "cannot parse data: " + err.message,
                        "data": data
                    }
                }
            } else {
                result = {
                    "result": 0,
                    "error": "no data received"
                }
            }
            return result;
        }

        feather.replace();

        function isFormValid() {
            var valid = true;
            if ($('#name').val().trim() == '') {
                valid = false;
            }
            if ($('#project').val().trim() == '') {
                valid = false;
            }
            return valid;
        }

        $(document).ready(function() {
            $('#embed-service-rtmp').trigger('click');
            $('#new-session-form input').on('change', function() {
                if (isFormValid()) {
                    $('#btn-create-session').removeClass('btn-danger').addClass('btn-success');
                } else {
                    $('#btn-create-session').removeClass('btn-success').addClass('btn-danger');
                }
            });
        });

        $('input[type="radio"]').on('change', function() {
            if ($(this).attr('id') == 'embed-service-rtmp') {
                $('#rtmp-helper').show();
                $('#service-id').hide();
                $('#rtmp-id').text($('#id').val());
            } else {
                $('#service-id').show();
                $('#rtmp-helper').hide();
            }
        });


        $('#loginform').on('submit', function(e) {
            e.preventDefault();
            $.post('js.php', {
                method: 'login',
                password: $('#password').val()
            }, function(data) {
                var json = gg_parseJSON(data);
                if (json['result'] == 1) {
                    document.location.reload();
                } else {
                    alert(data);
                }
            });
        });

        $('#delete').click(function() {
            if (confirm('Vraiment?')) {
                $.post('js.php', {
                    method: 'delete-session',
                    id: $('#id').val()
                }, function(data) {
                    var json = gg_parseJSON(data);
                    if (json['result'] == 1) {
                        document.location.reload();
                    } else {
                        alert(data);
                    }
                });
            }
        });

        $('.modify').click(function() {
            var $this = $(this);
            var rel = $this.attr('rel');
            $('tr').removeClass('bg-warning');
            $this.closest('tr').addClass('bg-warning');

            $.post('js.php', {
                method: 'get-session',
                id: rel
            }, function(data) {
                var json = gg_parseJSON(data);
                if (json['result'] == 1) {
                    $('#id').val(json['id']);
                    $('#rtmp-id').text($('#id').val());
                    $('#modify').val(1);
                    $('#deleted').val(json['deleted']);
                    $('#name').val(json['name']);
                    $('#contact').val(json['contact']);
                    $('#embed_code').val(json['embed_code']);
                    $('#artist').val(json['artist']);
                    $('#type').val(json['type']);
                    $('#project').val(json['project']);
                    if (json['service'] == 'rtmp') {
                        $('#embed-service-rtmp').trigger('click');
                    }
                    if (json['service'] == 'youtube') {
                        $('#embed-service-youtube').trigger('click');
                    }
                    if (json['service'] == 'vimeo') {
                        $('#embed-service-vimeo').trigger('click');
                    }

                    $('#btn-create-session').trigger('click');
                } else {
                    alert(data);
                }
            });
        });

        $('#btn-create-session').click(function() {
            var $this = $(this);
            if ($('#collapse').hasClass('show')) {
                if ($this.hasClass('btn-danger')) {
                    alert('Nom de session et nom de projet requis');
                    $this.removeClass('btn-danger');
                } else {
                    $this.removeClass('btn-success');
                    var $width = $this.width();
                    $this.css({
                        width: $width + 'px'
                    }).text('...');

                    var service = '';
                    var embed_code = '';
                    if ($('#embed-service-rtmp').prop('checked')) {
                        service = 'rtmp';
                    }
                    if ($('#embed-service-youtube').prop('checked')) {
                        service = 'youtube';
                        embed_code = $('#embed-code').val();
                    }
                    if ($('#embed-service-vimeo').prop('checked')) {
                        service = 'vimeo';
                        embed_code = $('#embed-code').val();
                    }
                    $.post('js.php', {
                        method: 'create-session',
                        name: $('#name').val(),
                        project: $('#project').val(),
                        type: $('#type').val(),
                        artist: $('#artist').val(),
                        id: $('#id').val(),
                        service: service,
                        embed_code: embed_code,
                        contact: $('#contact').val(),
                        deleted: $('#deleted').val()
                    }, function(data) {
                        var json = gg_parseJSON(data);
                        if (json['result'] == 1) {
                            $('.container').fadeOut(function() {
                                document.location = '?added=' + json['id'];
                            });
                        } else {
                            alert(data);
                        }
                    });
                }
            } else {
                if ($('#modify').val() == 1) {
                    $this.text('Modifier');
                    $('#delete').show();
                } else {
                    $this.text('Créer');
                    $('#new-session-form')[0].reset();
                    $('#delete').hide();
                }
                if (isFormValid()) {
                    $this.addClass('btn-success');
                } else {
                    $this.addClass('btn-danger');
                }
            }
        });
    </script>
</body>

</html>