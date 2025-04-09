$(document).ready(function()
{
  function LoadGames(store = ''){
    // AJAX call to CLEAN SESSION
    $.ajax({
      url: baseUrl+'ajax/live_games.php',
      method: 'GET',
      data:
      {
        list_games: store
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
          premierIdCell.textContent = '';
          if(item.Store) premierIdCell.textContent += "("+item.Store.name+") ";
          premierIdCell.textContent += item.premier_id;
          newLine.appendChild(premierIdCell);

          var base1Cell = document.createElement('td');
          base1Cell.className = "";
          var base1_img = document.createElement('div');
          base1_img.className = "base-img player_1_base";
          getCard(item.base[0]).then( dbBase => {
            base1_img.style.setProperty('background-image', 'url("'+dbBase.img+'")');
          });
          base1Cell.append(base1_img);;
          newLine.appendChild(base1Cell);

          var leader1Cell = document.createElement('td');
          leader1Cell.className = "";
          var leader1_img = document.createElement('div');
          leader1_img.className = "leader-img player_1_leader";
          getCard(item.leader[0]).then( dbLeader => {
            leader1_img.style.setProperty('background-image', 'url("'+dbLeader.img+'")');
          });
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
          leader2Cell.className = "";
          var leader2_img = document.createElement('div');
          leader2_img.className = "leader-img player_2_leader";
          getCard(item.leader[1]).then( dbLeader => {
            leader2_img.style.setProperty('background-image', 'url("'+dbLeader.img+'")');
          });
          leader2Cell.append(leader2_img);
          newLine.appendChild(leader2Cell);

          var base2Cell = document.createElement('td');
          base2Cell.className = "";
          var base2_img = document.createElement('div');
          base2_img.className = "base-img player_2_base";
          getCard(item.base[1]).then( dbBase => {
            base2_img.style.setProperty('background-image', 'url("'+dbBase.img+'")');
          });
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

    updateEpics();
  }

  function updateGamesLifes(){
    $.ajax({
      url: baseUrl + 'ajax/live_games.php', // Substitua pelo URL correto
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

  function updateEpics(){
    $.ajax({
      url: baseUrl + 'ajax/live_games.php', // Substitua pelo URL correto
      method: 'GET',
      data: {
        update_epics: '' // Indica que você quer atualizar as vidas
      },
      dataType: 'json',
      xhrFields: {
          withCredentials: true
      },
      success: function (result) {
          result.forEach(item => {
              var premierId = item.premier_id;
              var epic_img = document.createElement('img');
              epic_img.className = "epicToken-img"
              epic_img.src = "./imgs/tokens/epic_token.png";

              // PLAYER 1
              var base_epic_1 = item.base_epic[0];
              var leader_epic_1 = item.leader_epic[0];
              var player1BaseCell = $('#' + premierId + ' .player_1_base');
              var player1LeaderCell = $('#' + premierId + ' .player_1_leader');
              if(base_epic_1 && player1BaseCell.find('.epicToken-img').length === 0) player1BaseCell.append(epic_img.cloneNode(true));
              else if(!(base_epic_1)) player1BaseCell.find('.epicToken-img').remove();
              if(leader_epic_1 && player1LeaderCell.find('.epicToken-img').length === 0) player1LeaderCell.append(epic_img.cloneNode(true));
              else if(!(leader_epic_1)) player1LeaderCell.find('.epicToken-img').remove();

              //PLAYER 2
              var base_epic_2 = item.base_epic[1];
              var leader_epic_2 = item.leader_epic[1];
              var player2BaseCell = $('#' + premierId + ' .player_2_base');
              var player2LeaderCell = $('#' + premierId + ' .player_2_leader');
              if(base_epic_2 && player2BaseCell.find('.epicToken-img').length === 0) player2BaseCell.append(epic_img.cloneNode(true));
              else if(!(base_epic_2)) player2BaseCell.find('.epicToken-img').remove();
              if(leader_epic_2 && player2LeaderCell.find('.epicToken-img').length === 0) player2LeaderCell.append(epic_img.cloneNode(true));
              else if(!(leader_epic_2)) player2LeaderCell.find('.epicToken-img').remove();
          });
      },
      error: function (error, txtStatus, errorThrown) {
          console.error("Erro ao atualizar lifes:", txtStatus, errorThrown);
          console.error("Resposta do servidor:", error.responseText);
      }
    });
  }

  $('#store').on('change', function() {
    var newStore = $(this).val();
    LoadGames(newStore);
  });

  if(fileUrl=="live.php"){
    selectStores();
    LoadGames();
    setInterval(LoadGames, (30000));
    setInterval(updateGamesLifes, 5000);
    setInterval(updateEpics, 10000);
  }
  else if(fileUrl=="game.php"){
    setInterval(updateGamesLifes, 1000);
    setInterval(updateEpics, 5000);
    setInterval(LoadGames, (10000));
  }
});

function openGame(game){
  $('#list_games tbody tr').removeClass('selected'); // Remove a classe de outras linhas
  game.classList.toggle('selected'); // Adiciona a classe à linha clicada

  // Obtém o premier_id da linha clicada
  var premierId = game.id;

  // Redireciona para game.php com o premier_id
  window.open('game.php?id=' + premierId, '_blank');
}