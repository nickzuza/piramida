<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    @yield('meta')
</head>
<body>
<div class="content">

    <main>
        @yield('content')
    </main>
</div>
<footer class="footer">

</footer>
<!-- ========= scripts ========= -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'language' => '',
        'cartNumber'=>'1',
        'cartData'=>'20434',
    ]); ?>
</script>

<script src="{{asset('js/app.js')}}"></script>
@yield('script')
<!-- ========= /scripts ========= -->
</body>
</html>


