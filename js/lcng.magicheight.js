(function($) { 

  $(document).ready(function() {
   
    function magicHeight() {

        var windowHeight = $(window).height();
        var mainHeight = $("#content-column").outerHeight();
        var offset = $("#header").outerHeight() + $("#foot-wrapper").outerHeight()+77;
        
           if (windowHeight > mainHeight){     
            $("#sidebar-magicheight").height(windowHeight - offset);

          } else if (windowHeight < mainHeight){
            $("#sidebar-magicheight").height(mainHeight);
          }
    }

    $(window).load(function() {
      magicHeight();
    });

    $(window).resize(function() {
      magicHeight();
    });
      
  });

})(jQuery);
