
$(function () {
    var url = window.location.href;
    $("#menu a").each(function () {
        if (url == (this.href)) {
            $(this).closest(".menuHeader").children("a").addClass("active_menu");
            $(this).closest("li").addClass("active_menu");
            $(this).toggleClass('active');
            $(this).closest("li a").css({"color": "#16181b", "background-color": "#f8f9fa"});
           
        }
    });
});
