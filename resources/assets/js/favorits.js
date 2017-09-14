$(document).on('click','.deleteProd',function(e){
    var el = e.currentTarget;
    $(el).closest('.product').velocity({
        opacity:0,
    } , function(el){
        $(el).closest('.product').remove();
    });