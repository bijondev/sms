
    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <p>Powered By 
          <a href="http://e-edubd.info" target="_blank">e-edu.info</a>
      </div>
    </footer>
<script type="text/javascript">
  /*****************************Add Balance***********************************/
  $('[data-toggle="send-singel-sms"]').click(function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    if (url.indexOf('#') == 0) {
        $(url).modal('open');
    } else {
        $.get(url, function(data) {
            $('<div class="modal hide fade">' + data + '</div>').modal();
        }).success(function() { $('input:text:visible:first').focus(); });
    }
}); 
</script>
  </body>
</html>
