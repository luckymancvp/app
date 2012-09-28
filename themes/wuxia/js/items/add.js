/**
 * Created with JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    // Tabs
    $('.demoTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $("[href=#multi]").click();

    // Init
    $("#Items_word").focus();

    $("#Items_word").change(function(){
        switch ($("#predefined").val()){
            case "0" : // None
                break;
            case "1" : // Bing
                $.ajax({
                    url:translateUrl,
                    beforeSend : function(){$("#predefining").show()},
                    data:{
                        text : $("#Items_word").val(),
                        from : $("#from").val(),
                        to   : $("#to").val()
                    }
                }).done(function (res) {
                        $("#Items_meaning").val(res);
                        $("#predefining").hide();
                    });
                break;
            case "2" :
                break;
            case "3" :
                break;
        }
    });

    /**
     * Swap translate language
     */
    window.swapLanguage = function(){
        from = $("#from").val();
        $("#from").val($("#to").val());
        $("#to").val(from);
    };

    /**
     * Combine ctrl key
     * @param key
     * @param callback
     * @param args
     */
    $.ctrl = function(key, callback, args) {
        $(document).keydown(function(e) {
            if(!args) args=[]; // IE barks when args is null
            if(e.keyCode == key.charCodeAt(0) && e.ctrlKey) {
                callback.apply(this, args);
                return false;
            }
        });
    };
    // Save
    $.ctrl("S",function(){
        $("#save-item").click();
    });

});