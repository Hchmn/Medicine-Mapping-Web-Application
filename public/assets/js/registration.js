function initMap() {
  var marker;
  let markers = [];
  const myLatlng = { lat: 8.2280, lng:124.2452 };

  const map = new google.maps.Map(
    document.getElementById("map"),
    {
      zoom: 15,
      center: myLatlng,
      mapId: '6f2d6f51360215ea',
      disableDefaultUI: true,
    }
  );

  //automatic fill the value of input type field for lat and long
  google.maps.event.addListener(map,'click',function(event) {
      // input
      document.getElementById('pharmacyLatitude').value = event.latLng.lat();
      document.getElementById('pharmacyLongitude').value = event.latLng.lng();
      // p
      document.getElementById('pharmacyLatitudeText').innerHTML = event.latLng.lat();
      document.getElementById('pharmacyLongitudeText').innerHTML = event.latLng.lng();
      placeMarker(event.latLng);
  });

  function placeMarker(location) {

    if(markers.length == 0){
      marker = new google.maps.Marker({
        position: location,
        map: map
      });
        markers.push(marker);
      }
    else {
      changeMarkerPosition(location);
    }
  }

  function changeMarkerPosition(location) {
    var latlng = location;
    marker.setPosition(latlng);
  }
}

var pharmacyInfoFormData;

$("#pharmaInfo").submit(function(e){
  e.preventDefault();
  var lat = $("input[name=pharmacyLatitude]").val();
  var lng = $("input[name=pharmacyLongitude]").val();
  var email = $("input[name=pharmacyEmail]").val();
  var mobileNumber = $("input[name=pharmacyMobileNumber]").val();
  var telephone = $("input[name=pharmacyTelephone]").val();
  if(lat || lng){
    if(email || mobileNumber || telephone){
      var formData = new FormData(document.getElementById("pharmaInfo"));
      pharmacyInfoFormData = formData;
      $(this).removeClass("d-lg-flex");
      $(this).addClass("d-none");
      $("#yourInfo").removeClass("d-none");
      $("#yourInfo").addClass("d-lg-flex");
    }else{
      $("#contactInfo").removeClass("text-info");
      $("#contactInfo").addClass("text-danger fw-bold fs-5");
    }
  }else{
    if(!email && !mobileNumber && !telephone){
      $("#contactInfo").removeClass("text-info");
      $("#contactInfo").addClass("text-danger fw-bold fs-5");
    }
    $("#gmapInfo").removeClass("text-info");
    $("#gmapInfo").addClass("text-danger fw-bold fs-5");
    $("#map").addClass("border border-5 border-danger");
  }

});

$("#backBtn").on('click', function(e){
  $("#pharmaInfo").removeClass("d-none");
  $("#pharmaInfo").addClass("d-lg-flex");
  $("#yourInfo").removeClass("d-lg-flex");
  $("#yourInfo").addClass("d-none");
});

$("#yourInfo").submit(function(e){
  e.preventDefault();

  var pharmacistFormData = $(this).serializeArray();

  // link the two form data
  for (var i = 0; i < pharmacistFormData.length; i++) {
    pharmacyInfoFormData.append(pharmacistFormData[i].name, pharmacistFormData[i].value);
  }

  let combineFormData = pharmacyInfoFormData;

  let baseUrl = window.location.origin;
  let apiPath = "/register/submit";
  let url = baseUrl + apiPath;

  $.ajax({
    type: 'post',
    url: url,
    data: combineFormData,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
      // do something
      // console.log(data);
      // alert message
      let message = "Thank you for your submission.\n\n"+
                    "Our team will review the submitted information and documents."+
                    " Then we will send a confirmation email to you.";

      alert(message);
      window.location.replace(baseUrl);
    },
    error: function(xhr, textStatus, errorMessage){
      // do something
      console.log(xhr.status);
    }
  });

});

$(document).ready(function(){
  var lanao_del_norte_cities = {};
  // lanao_del_norte_cities['LANAO DEL NORTE'] = ['BACOLOD', 'BALOI', 'BAROY', 'ILIGAN CITY', 'KAPATAGAN', 'KAUSWAGAN', 'KOLAMBUGAN', 'LALA', 'LINAMON', 'MAGSAYSAY','MAIGO',
  //                         'MATUNGAO', 'MUNAI', 'NUNUNGAN', 'PANTAO RAGAT', 'PANTAR', 'POONA PIAGAPO', 'SALVADOR', 'SAPAD', 'SULTAN NAGA DIMAPORO (KAROMATAN)', 'TAGOLOAN'
  //                         ,'TANGCAL', 'TUBOD'];
  barangay_in_cities = {};
  barangay_in_cities['Iligan City'] = ['Abuno', 'Acmac', 'Bagong Silang', 'Bonbonon', 'Bunawan', 'Buru-un', 'Dalipuga', 'Del Carmen', 'Digkilaan', 'Ditucalan', 'Dulag', 'Hinaplanon'
      , 'Hindang', 'Kabacsanan', 'Kalilangan', 'Kiwalan', 'Lanipao', 'Luinab', 'Mahayahay', 'Mainit', 'Mandulog', 'Maria Cristina', 'Palao', 'Panoroganan', 'Poblacio', 'Puga-an'
      , 'Rogongon', 'San Miguel', 'San Roque', 'Santa Elena', 'Santa Filomena', 'Santiago', 'Santo Rosario', 'Saray', 'Suarez', 'Tambacan', 'Tibanga', 'Tipanoy', 'Tomas L. Cabili',
      'Tominobo Upper', 'Tominobo Lower', 'Tubod', 'Ubaldo Laya', 'Upper Hinaplanon', 'Villa Verde'];

  var barangayNodeList = document.getElementsByClassName('barangay');
  // clear select options
  for(var i = 0; i < barangayNodeList.length; i++){
    while (barangayNodeList[i].options.length){
      barangayNodeList[i].remove(0);
    }
  }

  var barangays = barangay_in_cities['Iligan City'];

  // append barangay data
  if(barangays){
    for (var j = 0; j < barangayNodeList.length; j++){
      for(var i = 0; i < barangays.length; i++){
        var barangay = new Option(barangays[i]);
        barangayNodeList[j].options.add(barangay);
      }
    }
  }

});
