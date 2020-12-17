<? php 



?>


<!-- FOOTER -->
    <div id="footer">
        <p>&copy; E-Permit 2020. &nbsp;Developed by <a class="app-developer" style="" href="">Jecmas </a>&nbsp;</p>
    </div>
    <!--END FOOTER -->


    <!-- GLOBAL SCRIPTS -->
    <script src="../admin/assets/js/jquery-2.0.3.min.js"></script>
     <script src="../admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../admin/assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

    <!-- PAGE LEVEL SCRIPTS -->
    <script src="../admin/assets/plugins/flot/jquery.flot.js"></script>
    <script src="../admin/assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="../admin/assets/plugins/flot/jquery.flot.time.js"></script>
     <script  src="../admin/assets/plugins/flot/jquery.flot.stack.js"></script>
    <script src="../admin/assets/js/for_index.js"></script>
   
    <!-- END PAGE LEVEL SCRIPTS -->
    <!--    add on-page loading script effect-->
     <script>
        var preloader = document.getElementById('loader');
        function displayLoader(){
            preloader.style.display = 'none';
        }
        setTimeout(function(){
            $('.loading').fadeToggle();
        }, 1500);
    </script>
    
<!--    add module/section show effect-->
    <script>
//        $('#getObject').on('click',function(){
//        $('.spinning').show();
//        $.ajax({
////            url: url,
////            type: 'GET',
//            beforeSend: function() {
//                $('#spinner').html('<img src="../assets/images/spinner.gif" alt="reload" width="20" height="20" style="margin-top:10px;">');
//    			
//            },
//            success: function(html) {
//                $('#spinner').html('');
//            }
//        });
//    });
    </script>
    
<!--    spin loader gif before display object-->
    <script>
//        var spinner = document.getElementById('spinner');
//        function spinAndWait(){
//            spinner.style.display = 'none';
//        }
//        setTimeout(function(){
//            $('.spinning').hide();
//        }, 500);
//        });
    </script>
    
<!--    add this script to show loading when accessing new module/page-->

</body>
 <!-- END BODY -->
</html>