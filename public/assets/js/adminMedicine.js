
$(document).ready(function(){
  // do something

  // search
  $('#searchMedicine').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $("#tableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

var newGenericSelectCounter = 0;
// add new generic name

$('#addGenericNames').click(function(){
  newGenericSelectCounter += 1;
  var containerNod = $("#genericNamesContainer"); // get element
  var clone = $("#defGenericName").clone(); // clone the element

  clone.attr("id", "genericName" + newGenericSelectCounter); // set a new id for the clone element
  clone.removeClass("d-none"); // remove d-none class

  var newDiv = $("<div></div>"); // create div element
  newDiv.addClass("newGenericSelectContainer d-flex flex-row col-sm-12 mb-3"); // add class

  newDiv.append(clone); // append the clone element to the newly created div

  containerNod.append(newDiv); // then append it in the container
});

var newClassSelectCounter = 0;
// adding new classification follows the same concept for adding generic name

$('#addClassification').click(function(){
  newClassSelectCounter += 1;
  var containerNod = $("#medicineClassificationContainer");
  var clone = $("#defClassification").clone();

  clone.attr("id", "classification" + newClassSelectCounter); // set new id
  clone.removeClass("d-none");

  var newDiv = $("<div></div>");
  newDiv.addClass("newClassificationSelectContainer d-flex flex-row col-sm-12 mb-3");

  newDiv.append(clone);

  containerNod.append(newDiv);
});

$('#updateMedicine').submit(function(e){
  e.preventDefault(); // to prevent windows from reloading
  var formData = $(this).serialize(); // get data in the form

  var baseUrl = window.location.origin;

  var apiPath = "/admin/medicine/update";

  var url = baseUrl + apiPath;

  // send ajax request
  $.ajax({
    type: 'post', // set request method
    url: url,
    data: formData,
    success: function(data){
      // if success reload
      window.location.reload();
    },
    error: function(xhr, textStatus, errorMessage){
      // otherwise dispay error status
      console.log(xhr.status);
    }
  });

});
