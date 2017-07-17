@include('admin.elements.head')
<?php $url = Request::url(); $segments = Request::segments(); $segment = isset($segments[0]) ? $segments[0] : NULL; $url_ro = ''; $url_ru = ''; $url_en = ''; $locale = Config::get('app.fallback_locale'); if (!$segment) {
    if ($locale == 'ro') {
        $url_ro = $url;
        $url_ru = $url . '/ru';
        $url_en = $url . '/en';
    } else if ($locale == 'en') {
        $url_ro = $url . '/ro';
        $url_en = $url;
        $url_ru = $url . '/ru';
    } else {
        $url_ro = $url . '/ro';
        $url_en = $url . '/en';
        $url_ru = $url;
    }
} else {
    if (strpos($url, '/ro') !== false || strpos($url, '/ru') !== false || strpos($url, '/en') !== false) {
        unset($segments[0]);
        if ($locale == 'ru') {
            $url_ru = implode('/', $segments);
            array_unshift($segments, 'en');
            $url_en = implode('/', $segments);
            $segments[0] = 'ro';
            $url_ro = implode('/', $segments);
        } else if ($locale == 'en') {
            $url_en = implode('/', $segments);
            array_unshift($segments, 'ru');
            $url_ru = implode('/', $segments);
            $segments[0] = 'ro';
            $url_ro = implode('/', $segments);
        } else {
            $url_ro = implode('/', $segments);
            array_unshift($segments, 'en');
            $url_en = implode('/', $segments);
            $segments[0] = 'ru';
            $url_ru = implode('/', $segments);
        }
    } else {
        if ($locale == 'ru') {
            $url_ru = implode('/', $segments);
            array_unshift($segments, 'ro');
            $url_ro = implode('/', $segments);
            $segments[0] = 'en';
            $url_en = implode('/', $segments);
        } else if ($locale == 'en') {
            $url_en = implode('/', $segments);
            array_unshift($segments, 'ro');
            $url_ro = implode('/', $segments);
            $segments[0] = 'ru';
            $url_ru = implode('/', $segments);
        } else {
            $url_ro = implode('/', $segments);
            array_unshift($segments, 'ru');
            $url_ru = implode('/', $segments);
            $segments[0] = 'en';
            $url_en = implode('/', $segments);
        }
    }
} ?>
<style> .form-group.row {
        margin-right: 0;
    } </style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- header --> @include('admin.elements.header') <!-- sidebars --> @include('admin.elements.sidebar') <!-- content wrapper. contains page content -->
    <div class="content-wrapper">
        <section class="content"> @yield('content')
            <div id="loading_img"></div>
        </section> <!-- /.content --> </div> <!-- /.content-wrapper -->
    <div class="control-sidebar-bg"></div> @include('admin.elements.footer') </div><!-- ./wrapper --> </body> </html>
<script src="{!! asset('adminLTE/plugins/jQuery/jQuery-2.1.4.min.js')!!}"></script> <!-- Bootstrap 3.3.5 -->
<script src="{!! asset('adminLTE/bootstrap/js/bootstrap.min.js')!!}"></script> <!-- SlimScroll -->
<script src="{!! asset('adminLTE/plugins/slimScroll/jquery.slimscroll.min.js')!!}"></script> <!-- FastClick --> <!-- AdminLTE App -->
<script src="{!! asset('adminLTE/dist/js/app.min.js')!!}"></script> <!-- AdminLTE for demo purposes -->
<script src="{!! asset('adminLTE/dist/js/demo.js')!!}"></script>
<script src="{!! asset('ckeditor/ckeditor.js')!!}"></script>
<script src="{!! asset('adminLTE/chosen.jquery.js')!!}"></script>
<script src="{!! asset('adminLTE/plugins/color/js/bootstrap-colorpicker.min.js')!!}"></script>
<script src="{!! asset('adminLTE/plugins/color/js/bootstrap-colorpicker-plus.min.js')!!}"></script>
<script>
    $(function () {
        var config = {
            '.chosen-select': {
                width: "100%",
                no_results_text: 'Oops, nothing found!',
                allow_single_deselect: true
            },
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });

</script>
@yield('script')
<script>
    $( function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            var $modalElement = this.$element;
            $(document).on('focusin.modal', function (e) {
                var $parent = $(e.target.parentNode);
                if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                    // add whatever conditions you need here:
                    &&
                    !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                    $modalElement.focus()
                }
            })
        };

        $('.modal').removeAttr('tabindex');
        $('.phone').keypress(function(e){
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault();
            }
        });
    });
    var current_slug=[];
    function SlugChange(th,lang){
        current_slug[lang]=$('input[name=slug_'+lang+']').val();
        $('input[name=slug_'+lang+']').removeClass('slug_default');
        $('.btn_slug_'+lang).removeClass('slug_default');
        $(th).addClass('slug_default');
    }

    function Slug_Close(th,lang){
        $('input[name=slug_'+lang+']').val(current_slug[lang]);
        $('input[name=slug_'+lang+']').addClass('slug_default');
        $('.btn_slug_'+lang).addClass('slug_default');
        $('.btn_slug_change_'+lang).removeClass('slug_default');
    }

    function Slug_Save(th,lang){
        $('input[name=slug_'+lang+']').addClass('slug_default');
        $('.btn_slug_'+lang).addClass('slug_default');
        $('.btn_slug_change_'+lang).removeClass('slug_default');

    }
    $('.input_slug').change(function(){
        var lang=$(this).attr("data-lang");
        var text=$(this).val();
        if($('input[name=slug_'+lang+']').val().length==0) {
            $('input[name=slug_' + lang + ']').val(url_slug(text));
        }
    });
    $('.slug_input').change(function(){
        var lang=$(this).attr("data-lang");
        var text=$(this).val();
        var obj={ru:true};
        $(this).val(url_slug(text,obj));
    });
    function url_slug(s, opt) {
        s = String(s);
        opt = Object(opt);
        var defaults = {
            'delimiter': '-',
            'limit': undefined,
            'lowercase': true,
            'replacements': {},
            'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
        };

        // Merge options
        for (var k in defaults) {
            if (!opt.hasOwnProperty(k)) {
                opt[k] = defaults[k];
            }
        }
        if(opt['ru']==true){
            var char_map = {
                // Latin
                'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
                'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
                'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
                'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
                'ß': 'ss',
                'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
                'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
                'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
                'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
                'ÿ': 'y',

                // Latin symbols
                '©': '(c)',

                // Greek
                'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
                'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
                'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
                'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
                'Ϋ': 'Y',
                'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
                'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
                'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
                'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
                'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

                // Turkish
                'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
                'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g',



                // Russian
                'А': 'А', 'Б': 'Б', 'В': 'В', 'Г': 'Г', 'Д': 'Д', 'Е': 'Е', 'Ё': 'Е', 'Ж': 'Ж',
                'З': 'З', 'И': 'И', 'И': 'И', 'К': 'К', 'Л': 'Л', 'М': 'М', 'Н': 'Н', 'О': 'О',
                'П': 'П', 'Р': 'Р', 'С': 'С', 'Т': 'Т', 'У': 'У', 'Ф': 'Ф', 'Х': 'Х', 'Ц': 'Ц',
                'Ч': 'Ч', 'Ш': 'Ш', 'Щ': 'Щ', 'Ъ': '', 'Ы': 'Ы', 'Ь': '', 'Э': 'Э', 'Ю': 'Ю',
                'Я': 'Я',
                'а': 'а', 'б': 'б', 'в': 'в', 'г': 'г', 'д': 'д', 'е': 'е', 'ё': 'е', 'ж': 'ж',
                'з': 'з', 'и': 'и', 'й': 'и', 'к': 'к', 'л': 'л', 'м': 'м', 'н': 'н', 'о': 'о',
                'п': 'п', 'р': 'р', 'с': 'с', 'т': 'т', 'у': 'у', 'ф': 'ф', 'х': 'х', 'ц': 'ц',
                'ч': 'ч', 'ш': 'ш', 'щ': 'щ', 'ъ': '', 'ы': 'ы', 'ь': '', 'э': 'э', 'ю': 'ю',
                'я': 'я',
                // Ukrainian
                'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
                'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',



                // Czech
                'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U',
                'Ž': 'Z',
                'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
                'ž': 'z',

                // Polish
                'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z',
                'Ż': 'Z',
                'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
                'ż': 'z',

                // Latvian
                'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N',
                'Š': 'S', 'Ū': 'u', 'Ž': 'Z',
                'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
                'š': 's', 'ū': 'u', 'ž': 'z',

                //ROMANIAM

                'Ă':'A','Î':'I','Ș':'S','Ț':'T','Â':'A','ă':'a','î':'i','ș':'s','ț':'t','â':'a',
            };
        }else{
            var char_map = {
                // Latin
                'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
                'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
                'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
                'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
                'ß': 'ss',
                'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
                'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
                'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
                'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
                'ÿ': 'y',

                // Latin symbols
                '©': '(c)',

                // Greek
                'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
                'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
                'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
                'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
                'Ϋ': 'Y',
                'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
                'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
                'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
                'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
                'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

                // Turkish
                'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
                'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g',

                // Russian
                'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
                'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
                'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
                'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
                'Я': 'Ya',
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
                'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
                'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
                'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
                'я': 'ya',


                // Ukrainian
                'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
                'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',



                // Czech
                'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U',
                'Ž': 'Z',
                'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
                'ž': 'z',

                // Polish
                'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z',
                'Ż': 'Z',
                'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
                'ż': 'z',

                // Latvian
                'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N',
                'Š': 'S', 'Ū': 'u', 'Ž': 'Z',
                'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
                'š': 's', 'ū': 'u', 'ž': 'z',

                //ROMANIAM

                'Ă':'A','Î':'I','Ș':'S','Ț':'T','Â':'A','ă':'a','î':'i','ș':'s','ț':'t','â':'a',
            };
        }

        // Make custom replacements
        for (var k in opt.replacements) {
            s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
        }

        // Transliterate characters to ASCII
        if (opt.transliterate) {
            for (var k in char_map) {
                s = s.replace(RegExp(k, 'g'), char_map[k]);
            }
        }

        // Replace non-alphanumeric characters with our delimiter
        var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-zа-я0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
        s = s.replace(alnum, opt.delimiter);

        // Remove duplicate delimiters
        s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);

        // Truncate slug to max. characters
        s = s.substring(0, opt.limit);

        // Remove delimiter from ends
        s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');

        return opt.lowercase ? s.toLowerCase() : s;
    }
</script>
