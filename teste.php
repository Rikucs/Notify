<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div id="mydiv">
    <input id="url" type="text" value="https://nextcloud.newcoffee.pt"/>
     <iframe id="frame" src="" width="100%" height="300">
     </iframe>
 </div>
 <button id="button">Load</button>

<script>
    $(document).ready(function(){
  $("#button").click(function () { 
      var url = $('#url').val();
      $("#frame").attr("src", url);
  });
});
</script>