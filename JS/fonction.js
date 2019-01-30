/**
 * Created by Loulouze on 04/10/14.
 */

$(document).ready(function () {

  $("#text").keyup(function () {
    var se = $(this).val();
    se = $.trim(se);

    var longueur = se.length;
    console.log("data=" + se + " " + longueur);
    $(".red").hide();
    if (se != '') {

      $.ajax({
        type: 'GET',
        url: "../search.php",
        data: { data: se },
        dataType: "json",
        success: function (data) {

          $("#ul").html(data.notification);
          $(".red").html(data.mess).show();


        }
      });



    } else {

      $.ajax({
        type: 'GET',
        url: "../search.php",
        data: {},
        dataType: "json",
        success: function (data) {

          $("#ul").html(data.notification);

        }
      });



    }




  });

});


$(document).ready(function () {

  $("#deleguer").keyup(function () {
    var se = $(this).val();
    se = $.trim(se);

    console.log(se);
    
    if (se != '') {

      $.ajax({
        type: 'GET',
        url: "../searchNom.php",
        data: { data: se },
        success: function (data) {

          $("#autocomNom").fadeIn();
          $("#autocomNom").html(data).show();


        }
      });



    }else{

      $("#autocomNom").fadeOut();
    }




  });


  $("#formateur1").keyup(function () {
    var se = $(this).val();
    se = $.trim(se);
    
    if (se != '') {

      $.ajax({
        type: 'GET',
        url: "../searchformateur1.php",
        data: { data: se },
        success: function (data) {

          $("#autoformat1").fadeIn();
          $("#autoformat1").html(data).show();


        }
      });

    }else{

      $("#autoformat1").fadeOut();
    }
  });

  $("#formateur2").keyup(function () {
    var se = $(this).val();
    se = $.trim(se);
    
    if (se != '') {

      $.ajax({
        type: 'GET',
        url: "../searchformateur1.php",
        data: { dataf: se },
        success: function (dataf) {

          $("#autoformat2").fadeIn();
          $("#autoformat2").html(dataf).show();


        }
      });

    }else{

      $("#autoformat2").fadeOut();
    }
  });

  $("#medcin").keyup(function () {
    var se = $(this).val();
    se = $.trim(se);
    
    if (se != '') {

      $.ajax({
        type: 'GET',
        url: "../searchformateur1.php",
        data: { datam: se },
        success: function (datam) {

          $("#autocomm").fadeIn();
          $("#autocomm").html(datam).show();


        }
      });

    }else{

      $("#autocomm").fadeOut();
    }
  });


  $(document).on('click','.nomli',function(){
    $("#deleguer").val($(this).text());
    $("#autocomNom").fadeOut();
        
  });

  $(document).on('click','.nomlif1',function(){
    $("#formateur1").val($(this).text());
    $("#autoformat1").fadeOut();
        
  });

  $(document).on('click','.nomlif2',function(){
    $("#formateur2").val($(this).text());
    $("#autoformat2").fadeOut();
        
  });

  $(document).on('click','.nomlim',function(){
    $("#medcin").val($(this).text());
    $("#autocomm").fadeOut();
        
  });

  $(document).on('click','.ajoutad',function(){
    $("#autocomm").fadeOut();
    $("#autoformat2").fadeOut();
    $("#autoformat1").fadeOut();
    $("#autocomNom").fadeOut();
  });

});


$(document).ready(function () {

  $("#cli").on('click', function () {
    var p = $('#sel').html();
    $('.ajFormation').append(p);
  });

  $("#cliP").on('click', function () {
    var p = $('#sel2').html();
    $('.ajPrero').append(p);
  });

});








$(document).ready(function () {

  $("#file").on('change', function (e) {
    var filename = e.target.files[0].name;
    $("#label-span").text(filename);


  });

});


$(document).ready(function () {

  $("#file1").on('change', function (e) {
    var filename = e.target.files[0].name;
    $("#label-span1").text(filename);


  });

});







function dialogsuccess(mot, chemin) {


  var e = swal({
    text: mot,
    icon: "success"

  }).then(function () {
    window.location = chemin;
  });
  return e;


}

function dialoginfo(mot, chemin) {


  var e = swal({
    text: mot,
    icon: "info"

  }).then(function () {
    window.location = chemin;
  });
  return e;


}

function dialogerror(mot, chemin) {


  var e = swal({
    text: mot,
    icon: "error"

  }).then(function () {
    window.location = chemin;
  });
  return e;


}



function ajax() {

  $.ajax({
    type: 'GET',
    url: "../notification.php",
    dataType: "json",
    ifModified: true,
    success: function (data) {

      $('.not').html(data.notification);
      if (data.unseen_notification > 0) {
        $('.count').html(data.unseen_notification).show();
      } else {
        $('.count').html(data.unseen_notification).hide();
      }

    }
  });

  setTimeout(ajax, 10000);
};

ajax();

