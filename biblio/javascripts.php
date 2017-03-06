<?php
echo "<script language=javascript>
    var screenwidth = screen.width;
    var screenheight = screen.height;
function afficher(url){

  var height = screenheight*0.3 + \"px\"; 
  var width = screenwidth*0.7 + \"px\";
  var top=screenheight*0.25 + \"px\";
  var left=screenheight*0.25 + \"px\";   
  //alert(width);alert(height);
  var navigatorName = \"Microsoft Internet Explorer\";
  if( navigator.appName == navigatorName ){
       window.showModalDialog (url, window, \"dialogWidth=\"+width+\";dialogHeight=\"+height+\"; status = 0\");
  }
  else
       window.open(url,'newWin','modal=yes,width='+width+',height='+height+',top='+top+',left='+left+',resizable=yes,scrollbars=yes,status=no');
}
</script>
";
?>
