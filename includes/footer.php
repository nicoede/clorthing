<div class="footer">
  <hr class="style-two">
  <p class="col-text" style="margin-left:20px;">&copy; Edenilson Jonatas dos Passos 2017</p>
</div>

</body>
</html>

<script>
    function detailsmodal(id){
        var data = {"id" : id};
        jQuery.ajax({
            url : '/includes/details_modal.php',
            method : "post",
            data : data,
            success : function(data){
                jQuery('body').append(data);
                jQuery('#details-modal').modal('toggle');
            },
            error : function(){
                // alert("Something went wrong!");
            }
        });
    }
    
    
    jQuery(window).scroll(function(){
        var vscroll = jQuery(this).scrollTop();
        jQuery('#logotext').css({
        "transform" : "translate(0px, "+vscroll/2+"px)"
        });
        
        var vscroll = jQuery(this).scrollTop();
        jQuery('#back-flower').css({
        "transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
        });
        
        var vscroll = jQuery(this).scrollTop();
        jQuery('#fore-flower').css({
        "transform" : "translate(0px, -"+vscroll/2+"px)"
        });
    });
</script>