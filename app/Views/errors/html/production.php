<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title>Whoops!</title>

    <style type="text/css">
        body {
            text-align: center;
        }

        #time {
            color: #0048e3;
            font-size: 25px;
            font-weight: bold;
        }

        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>

</head>
<body onload="start_timer();">

<div class="container text-center">

    <h1 class="headline">Whoops!</h1>
    <img src="https://cdn.dribbble.com/users/6117646/screenshots/14461914/media/623783422c006f714b3fb34f4fc1ebc3.gif"
         alt="mohon antri" height="250px">
    <p>Mohon maaf terjadi kesalahan, silahkan kontak administrator anda</p>
    <div class="box">
      <span id="time">
        00:01:00
      </span>
    </div>
    <h4><?= esc($title), esc($exception->getCode() ? ' #' . $exception->getCode() : '') ?></h4>
    <p>
        <?= nl2br(esc($exception->getMessage())) ?>
    </p>
</div>
<script type="text/javascript">
    function start_timer() {
        let timer = document.getElementById("time").innerHTML;
        let arr = timer.split(":");
        let hour = arr[0];
        let min = arr[1];
        let sec = arr[2];
        if (sec == 0) {
            if (min == 0) {
                if (hour == 0) {
                    window.location.reload();
                    return;
                }
                hour--;
                min = 60;
                if (hour < 10) hour = "0" + hour;
            }
            min--;
            if (min < 10) min = "0" + min;
            sec = 59;
        } else sec--;
        if (sec < 10) sec == "0" + sec;

        document.getElementById("time").innerHTML = hour + ":" + min + ":" + sec;
        setTimeout(start_timer, 1000);
    }
</script>
</body>

</html>
