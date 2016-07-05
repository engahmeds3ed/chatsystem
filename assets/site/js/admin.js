$(document).ready(function(){
    
    function ads_type(ads_type_select){
        $('.ads_type_div').hide();
        $('#ads_type_'+ads_type_select.val()).show();
    }
    
    if($('#ads_type').length > 0){
        
        var ads_type_select = $('#ads_type');
        ads_type(ads_type_select);
        
        $('#ads_type').click(function(){
            var ads_type_select = $(this);
            ads_type(ads_type_select);
        });
    }
    
    if($('.calender').length){
        $(".calender").datetimepicker();
    }
    
    $('.delete').click(function(){
        return confirm('هل أنت متأكد ?');
    });
    
});