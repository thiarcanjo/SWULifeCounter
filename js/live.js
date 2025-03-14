var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";// + getUrl.pathname.split('/')[1];
var fileUrl = getUrl.pathname.split('/')[1];
var moduleName = getUrl.pathname.split('/')[3];
var moduleOption = getUrl.pathname.split('/')[4];

//AO CARREGAR A página
$(document).ready(function()
{
  function LoadGames(){
    // AJAX call to CLEAN SESSION
    $.ajax({
      url: baseUrl+'ajax.php',
      method: 'GET',
      data:
      {
        list_games: ''
      },
      dataType: 'json',
      xhrFields: {
        withCredentials: true
      },
      success: function (result){
        $('#list_games table tbody').empty();
        result.forEach(item => {
          var newLine = document.createElement('tr');
          newLine.setAttribute('class','premier_game');
          newLine.setAttribute('id',item.premier_id);
          newLine.setAttribute('onclick','openGame(this)');

          var premierIdCell = document.createElement('td');
          premierIdCell.textContent = item.premier_id;
          newLine.appendChild(premierIdCell);

          var base1Cell = document.createElement('td');
          var base1 = item.base[0].match(/([A-Z]+)(\d+)/);
          var base1_img = document.createElement('div');
          base1_img.className = "base-img";
          base1_img.style.setProperty('background-image', 'url("https://swudb.com/images/cards/'+base1[1]+'/'+base1[2]+'.png")');
          base1Cell.append(base1_img);;
          newLine.appendChild(base1Cell);

          var leader1Cell = document.createElement('td');
          var leader1 = item.leader[0].match(/([A-Z]+)(\d+)/);
          var leader1_img = document.createElement('div');
          leader1_img.className = "leader-img";
          leader1_img.style.setProperty('background-image', 'url("https://swudb.com/images/cards/'+leader1[1]+'/'+leader1[2]+'.png")');
          leader1Cell.append(leader1_img);
          newLine.appendChild(leader1Cell);

          var life1Cell = document.createElement('td');
          life1Cell.setAttribute('class','player_1_life');
          life1Cell.textContent = item.life[0];
          newLine.appendChild(life1Cell);

          var xCell = document.createElement('td');
          xCell.textContent = 'x';
          newLine.appendChild(xCell);

          var life2Cell = document.createElement('td');
          life2Cell.setAttribute('class','player_2_life');
          life2Cell.textContent = item.life[1];
          newLine.appendChild(life2Cell);

          var leader2Cell = document.createElement('td');
          var leader2 = item.leader[1].match(/([A-Z]+)(\d+)/);
          var leader2_img = document.createElement('div');
          leader2_img.className = "leader-img";
          leader2_img.style.setProperty('background-image', 'url("https://swudb.com/images/cards/'+leader2[1]+'/'+leader2[2]+'.png")');
          leader2Cell.append(leader2_img);
          newLine.appendChild(leader2Cell);

          var base2Cell = document.createElement('td');
          var base2 = item.base[0].match(/([A-Z]+)(\d+)/);
          var base2_img = document.createElement('div');
          base2_img.className = "base-img";
          base2_img.style.setProperty('background-image', 'url("https://swudb.com/images/cards/'+base2[1]+'/'+base2[2]+'.png")');
          base2Cell.append(base2_img);;
          newLine.appendChild(base2Cell);

          $('#list_games table tbody').append(newLine);
        });
      },
      error: function (error,txtStatus,errorThrown){
        console.error("Error:", txtStatus, errorThrown);
        console.error("Resposta do servidor:", error.responseText);
      }
    });
  }

  function updateGamesLifes(){
    $.ajax({
      url: baseUrl + 'ajax.php', // Substitua pelo URL correto
      method: 'GET',
      data: {
          update_lifes: '' // Indica que você quer atualizar as vidas
      },
      dataType: 'json',
      xhrFields: {
          withCredentials: true
      },
      success: function (result) {
          result.forEach(item => {
              var premierId = item.premier_id;
              var life1 = item.life[0];
              var life2 = item.life[1];

              var player1LifeCell = $('#' + premierId + ' .player_1_life');
              var player2LifeCell = $('#' + premierId + ' .player_2_life');

              // Obtém os valores anteriores
              var previousLife1 = player1LifeCell.text();
              var previousLife2 = player2LifeCell.text();

              // Atualiza os textos
              player1LifeCell.text(life1);
              player2LifeCell.text(life2);

              // Verifica se os valores são diferentes
              if (life1.toString().trim() !== previousLife1) {
                  player1LifeCell.addClass('life-updated');
                  setTimeout(function() {
                      player1LifeCell.removeClass('life-updated');
                  }, 3000);
              }

              if (life2.toString().trim() !== previousLife2) {
                  player2LifeCell.addClass('life-updated');
                  setTimeout(function() {
                      player2LifeCell.removeClass('life-updated');
                  }, 1500);
              }
              
          });
      },
      error: function (error, txtStatus, errorThrown) {
          console.error("Erro ao atualizar lifes:", txtStatus, errorThrown);
          console.error("Resposta do servidor:", error.responseText);
      }
    });
  }

  if(fileUrl=="live.php"){
    LoadGames();
    setInterval(LoadGames, (30000));
    setInterval(updateGamesLifes, 5000);
  }
  else if(fileUrl=="game.php") setInterval(updateGamesLifes, 1000);
});


function openGame(game){
  $('#list_games tbody tr').removeClass('selected'); // Remove a classe de outras linhas
  game.classList.toggle('selected'); // Adiciona a classe à linha clicada

  // Obtém o premier_id da linha clicada
  var premierId = game.id;

  // Redireciona para game.php com o premier_id
  window.open('game.php?id=' + premierId, '_blank');
}