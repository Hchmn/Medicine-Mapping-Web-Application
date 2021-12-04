$(document).ready(function(){
  // search
  $('#searchMedicine').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $("#tableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

var newGenericSelectCounter = 0;
var newClassSelectCounter = 0;


$('#addGenericNames').click(function(){
  newGenericSelectCounter += 1;
  var containerNod = $("#genericNamesContainer");
  var clone = $("#defGenericName").clone();

  clone.attr("id", "genericName"+newGenericSelectCounter); // set new id
  clone.removeClass("d-none");

  var newDiv = $("<div></div>");
  newDiv.addClass("newGenericSelectContainer d-flex flex-row col-sm-12 mb-3");

  newDiv.append(clone);

  containerNod.append(newDiv);
});



$('#addClassification').click(function(){
  newClassSelectCounter += 1;
  var containerNod = $("#medicineClassificationContainer");
  var clone = $("#defClassification").clone();

  clone.attr("id", "classification"+newClassSelectCounter); // set new id
  clone.removeClass("d-none");

  var newDiv = $("<div></div>");
  newDiv.addClass("newClassificationSelectContainer d-flex flex-row col-sm-12 mb-3");

  newDiv.append(clone);

  containerNod.append(newDiv);
});

$('#addMedicineForm').submit(function(e){
  e.preventDefault();
  var formData = $(this).serialize();
  var baseUrl = window.location.origin;
  var apiPath = "/admin/medicine/add";
  var url = baseUrl+apiPath;

  $.ajax({
    type: 'post',
    url: url,
    data: formData,
    success: function(data){
      // do something
      window.location.reload();
    },
    error: function(xhr, textStatus, errorMessage){
      // do something
      console.log(xhr.status);
    }
  });
});

// remove 
$('.modalClose').click(function(){
  // reset counter
  newGenericSelectCounter = 0;
  newClassSelectCounter = 0;

  var genericContainerNod = $("#genericNamesContainer");
  genericContainerNod.children().remove();// empty the container

  // add one select element
  var clone = $("#defGenericName").clone();

  clone.attr("id", "genericName"+newGenericSelectCounter); // set new id
  clone.removeClass("d-none");

  var newDiv = $("<div></div>");
  newDiv.addClass("newGenericSelectContainer d-flex flex-row col-sm-12 mb-3");

  newDiv.append(clone);

  genericContainerNod.append(newDiv);

  var classContainerNod = $("#medicineClassificationContainer");
  classContainerNod.children().remove(); // remove all children
  var clone = $("#defClassification").clone();

  clone.attr("id", "classification" + newClassSelectCounter); // set new id
  clone.removeClass("d-none");

  var newDiv = $("<div></div>");
  newDiv.addClass("newClassificationSelectContainer d-flex flex-row col-sm-12 mb-3");

  newDiv.append(clone);

  classContainerNod.append(newDiv);
});
