<?php
/** @noinspection PhpUndefinedVariableInspection */
require_once './core/init.php';
$ctfu = new CTFU();
?>
<html>
<head>
    <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">-->
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/bootstrap.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body class="text-center">

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="masthead" style="margin-bottom:150px; padding-top: 25px;">
        <div class="inner">
            <h3 class="">Clean That F#cking URL</h3>
        </div>
    </header>

    <main role="main" class="inner cover">
        <p>
        <div id="results" style="display:none">
            <div class="alert alert-success">
                <strong>Filtered URL: </strong> <div id="filtered"></div>
            </div>
        <p><button type="button" class="btn btn-info" id="copy" onclick="copyDivToClipboard()">Copy</button></p>
            <div class="alert alert-danger">
                <strong> Bad URL:</strong> <div id="bad"></div>
            </div>
        </div>
        <div id="form">
            <form id="ctfu" method="post">
                <h1 class="cover-heading"><label for="url"><div id="eu">Enter URL</div></label></h1>
                <div class="input-group">
                    <input type="text" name="url" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="submit" style="border-radius: 0px;" type="button">Go!</button>
                    </span>
                    <div class="invalid-feedback">Oops, nothing that I can do..</div>
                </div>
            </form>
        </div>
        </main>
        <p class="lead"></p>
        <div id="info">
                    <p class="lead">

                        <div class="card border-danger mb-3">
                            <div class="card-header">What is CTFU</div>
                            <div class="card-body">
                                <h4 class="card-title">Just a simple service.</h4>
                    <p class="card-text">CTFU is a small application that removes all unnecessary URL parameters, mainly used for tracking purposes.</p>
            </div>
    </div>
</div>
<p class="text-danger">Current blocked parameters:<br/> <i><?= $ctfu->getParameters(); ?></i></p>
</p>
<footer class="mastfoot mt-auto">
    <div class="inner">

        <p>Made with <3</p>

    </div>

</footer>
</div>
<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ctfu').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'process.php',
                data: $(this).serialize(),
                success: function(response)
                {
                    var json = JSON.parse(response);
                    if(json.success){
                        $('input').removeClass('is-invalid');
                        $('#info').fadeOut(500);
                        $('#filtered').text(json.filtered);
                        $('#bad').text(json.url);
                        $('#results').fadeIn(500);
                        $('#eu').text('Try a new URL');
                    }else{
                        $('input').addClass('is-invalid');
                        $('#form').effect("shake", { times:3 }, 300);
                    }
                }
            });
        });
    });
    function copyDivToClipboard() {
        $("button#copy").fadeOut(250,function() {
            $(this).text("Copied!")
        }).fadeIn(250);
        var range = document.createRange();
        range.selectNode(document.getElementById("filtered"));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges();// to deselect
    }
</script>
</body>
</html>
