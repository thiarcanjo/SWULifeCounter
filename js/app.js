function selectStores(){
  var stores = Array();

  // AJAX call stores
  $.ajax({
    url: baseUrl+'ajax/live_games.php',
    method: 'GET',
    data:
    {
      store: ''
    },
    dataType: 'json',
    xhrFields: {
        withCredentials: true
    },
    success: function(result){
      var storeSelect = document.getElementById('store');
      storeSelect.innerHTML = '<option value="">SELECT A STORE IF YOU WISH</option>';
      result.forEach(store => {
        var option = document.createElement('option');
        option.value = store.code
        option.text = `${store.name} (${store.city})`;

        storeSelect.add(option);
      });
    },
    error: function (error,txtStatus,errorThrown)
    {
      console.error("Error:", txtStatus, errorThrown);
      console.error("Resposta do servidor:", error.responseText);
    }
  });
}

selectStores();