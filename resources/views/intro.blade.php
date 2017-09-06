<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2:400,700|Exo:400,700" rel="stylesheet">
    {{--<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>
<body>
<div class="content">
    <main>
        <div class="introPage">
            <div class="logo"><img src="../../img/intro-logo.png" alt="logo"></div>
            <div class="title-page">Rețea magazine</div>
            <div class="shops-container">
                <a href="#" class="shop">
                    <div class="img" style="background-image:url(http://www.wallpapermania.eu/images/lthumbs/2013-04/4746_Nature-back-to-life-spring-is-here.jpg)"></div>
                    <div class="info">
                        <div class="title">Baza Angro Chișinau</div>
                        <div class="location">ул. Узинелор 10/2</div>
                    </div>
                </a>
                <a href="#" class="shop">
                    <div class="img" style="background-image:url(http://www.wallpapermania.eu/images/lthumbs/2013-04/4746_Nature-back-to-life-spring-is-here.jpg)"></div>
                    <div class="info">
                        <div class="title">Centru comerciaL  Cimișlia</div>
                        <div class="location">ул. Суверанитэций 3А</div>
                    </div>
                </a>
                <a href="#" class="shop">
                    <div class="img" style="background-image:url(http://www.wallpapermania.eu/images/lthumbs/2013-04/4746_Nature-back-to-life-spring-is-here.jpg)"></div>
                    <div class="info">
                        <div class="title">Centru comerciaL Mihailovca</div>
                        <div class="location">ул. Штефан Водэ</div>
                    </div>
                </a>
                <a href="#" class="shop">
                    <div class="img" style="background-image:url(http://www.wallpapermania.eu/images/lthumbs/2013-04/4746_Nature-back-to-life-spring-is-here.jpg)"></div>
                    <div class="info">
                        <div class="title">Centru comercial  Falești</div>
                        <div class="location">г. Фэлешть, ул. Гагарин 1</div>
                    </div>
                </a>
            </div>
        </div>
    </main>
</div>
<!-- ========= scripts ========= -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'language' => '',
        'cartNumber'=>'1',
        'cartData'=>'20434',
    ]); ?>
</script>


<!-- ========= /scripts ========= -->
</body>
</html>


