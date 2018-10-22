/**
 * Created by Loulouze on 04/10/14.
 */
$(document).ready(function(){

$("#inputZip").keyup(function(){
   var se = $(this).val();
    se= $.trim(se);
    var data= "motcle="+se;  
    
if(se !="" && se.length>2)
{

    console.log(data);
    $.ajax({
        type: "GET",
        url: "/ffsfp/search.php",
        data: data,
        success: function(server_response){
          
        
           $("#p").html(server_response).show();
           

        }
});
}else{

     $("#p").hide();        
    }

});
});