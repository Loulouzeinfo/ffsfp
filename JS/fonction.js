/**
 * Created by Loulouze on 04/10/14.
 */

$(document).ready(function() {

    $("#text").keyup(function(){
   var se = $(this).val();
    se= $.trim(se);
   
   var longueur = se.length;
   console.log("data="+se+" "+longueur);
   $(".red").hide();
if(se !=''){
        
  $.ajax({
   type: 'GET',
   url:"../search.php",
   data:{data:se},
   dataType:"json",
   success:function(data)
   {
    
     $("#ul").html(data.notification);
      $(".red").html(data.mess).show();
     
   
   }
  });



}else{

  $.ajax({
   type: 'GET',
   url:"../search.php",
   data:{},
   dataType:"json",
   success:function(data)
   {
    
     $("#ul").html(data.notification);
   
   }
  });



}
  

    

});




    });





function dialogsuccess(mot,chemin){


 var e= swal({
               text: mot,
               icon: "success"

             }).then(function() {
                window.location = chemin;
              });
 return e;


}

function dialoginfo(mot,chemin){


 var e= swal({
               text: mot,
               icon: "info"

             }).then(function() {
                window.location = chemin;
              });
 return e;


}

function dialogerror(mot,chemin){


 var e= swal({
               text: mot,
               icon: "error"

             }).then(function() {
                window.location = chemin;
              });
 return e;


}


   
function ajax()
 {

  $.ajax({
  type: 'GET',
   url:"../notification.php",
   dataType:"json",
   ifModified:true,
   success:function(data)
   {

     $('.not').html(data.notification);
    if(data.unseen_notification > 0)
    {
         $('.count').html(data.unseen_notification).show();
    }else{
           $('.count').html(data.unseen_notification).hide();
    }
   
   }
  });

  setTimeout(ajax, 10000);
 };

ajax();

