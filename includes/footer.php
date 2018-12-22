
   </div><br></br>
   <footer class="text-center" id="footer">&copy; copyright 2018 DotSam Bouqtiue</footer>

<script>
    function detailsmodal(id) {
       var data = {"id" : id};
       jQuery.ajax({
           url : <?=BASEURL;?>+ 'includes/detailsmodal.php',
           method: "post",
           data: data,
           success: function(data){
               jQuery('body').append(data);
               jQuery('#details-modal').modal('toggle');
           },
           error: function(){
               alert('something went wrong');
           }
       });
    }
</script>
    
</body>
</html>