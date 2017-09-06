
if(document.getElementById('firstCatPage')) {
    $('.sub-title').on('click',function(e){
        var el=e.currentTarget;
        if($(el).closest('li').hasClass('opened')){
            $(el).closest('li').removeClass('opened')
            $(el).closest('li').find('ul').slideUp();
        }else{
            $('.subcategories-list>li.opened>ul').slideUp();
            $('.subcategories-list>li.opened').removeClass('opened');
            if($(el).closest('li').hasClass('opened')){
                $(el).closest('li').removeClass('opened')
                $(el).closest('li').find('ul').slideUp();
            }else{
                $(el).closest('li').addClass('opened')
                $(el).closest('li').find('ul').slideDown();
            }
        }

    });
   $(document).ready(function(){
       $( ".subCateg-list>li" ).each(function( index ) {
           if($(this).find('ul')){
             if($(this).find("ul>li").length >4){
                 $(this).addClass('big');
                 $(this).find('.more-info').html('+'+($(this).find("ul>li").length - 4 )+ ' категории');
             }
           }
       });
   })


    }
