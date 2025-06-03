/**
 * SETA a tela do PLAYER
 * 
 * @param {Array} playerData 
 * @param {string} playerID 
 */
async function setPlayerPremierDATA(playerData,playerID){
  var dbBase   = '';
  var dbLeader = '';
  var playerDIV   = document.getElementById(playerID);
  playerDIV.innerHTML = '';
  
  // GET BASES
  try{
    dbBase = await getCard(playerData[0]);
  }
  catch(error){
    console.error("ERROR on get a Card: ", error);
  }

  //SET BASE na tela
  playerDIV.style.setProperty('border-color','var(--aspect-'+dbBase.Aspects[0].code+')');
  playerDIV.style.setProperty('background-image','url("'+dbBase.img+'")');

  //SET LEADER na tela
  var count = document.createElement('div');
  count.className = "count w10";
  playerDIV.append(count);
  var leader_data = document.createElement('div');
  leader_data.className = "leader_data";
  var leftContent = document.createElement('div');
  leftContent.className = 'left';

  //GET LEADERS
  if(playerData[1] != ''){
      dbLeader = await getCard(playerData[1]);
      var leader_img = document.createElement('div');
      leader_img.className = "leader-img "+playerID+" leader";
      leader_img.style.setProperty('background-image', 'url("'+dbLeader.img+'")');
      leader_img.setAttribute('onclick','EpicActionToggle(this)');
      leftContent.append(leader_img);

      // ASPECTS
      var aspects = document.createElement('div');
      aspects.className = 'aspects';
      var aspect_base = document.createElement('div');
      aspect_base.className = "aspects-img";
      
      if(!dbBase.Aspects[0].img) aspect_base.style.setProperty('background-image','none');
      else aspect_base.style.setProperty('background-image','url("'+dbBase.Aspects[0].img+'")');

      aspects.append(aspect_base);

      for(var aspectDB of dbLeader.Aspects){
          var aspect_leader = document.createElement('div');
          aspect_leader.className = "aspects-img";

          if(!aspectDB.img) aspect_leader.style.setProperty('background-image','none');
          else aspect_leader.style.setProperty('background-image','url("'+aspectDB.img+'")');

          aspects.append(aspect_leader);
      };
      leftContent.append(aspects);
      leader_data.append(leftContent);
  }

  // VERIFICA se a BASE tem EPIC ACTION e ADD o TOKEN
  if(dbBase.epic) leader_data.append(addEpicToken(playerID));
  playerDIV.append(leader_data);

  addCounter(playerID);
}

/**
* Exibe menu para seleção de Bases e Líderes
*/
function resetScore(){
  if(confirm('Reset this game and start again?')){
    //PLAYER 1
    var player1DIV = document.getElementById('player_1');
    var epic_token_1 = player1DIV.querySelector('.epic_token');
    var count_now_1 = document.getElementById('count-now_player_1');
    var leader1 = player1DIV.querySelector(".leader-img.player_1.leader");
    var epicLeader1 = player1DIV.querySelector('.epicToken-img');
    if (epic_token_1){
      var btnEpic_1 = epic_token_1.querySelector('.btn');
      btnEpic_1.style = "filter: grayscale(100%);";
      if(leader1) updateEpicAction(btnEpic_1,'false');
    }
    count_now_1.innerHTML = 0;
    if(leader1){
      updateEpicAction(leader1,'false');
      leader1.classList.remove('epicUsed');
      if(epicLeader1) epicLeader1.remove();
    }

    //PLAYER 2
    var player2DIV = document.getElementById('player_2');
    var epic_token_2 = player2DIV.querySelector('.epic_token');
    var count_now_2 = document.getElementById('count-now_player_2');
    var leader2 = player2DIV.querySelector(".leader-img.player_2.leader");
    var epicLeader2 = player2DIV.querySelector('.epicToken-img');
    if (epic_token_2){
      var btnEpic_2 = epic_token_2.querySelector('.btn');
      btnEpic_2.style = "filter: grayscale(100%);";
      if(leader2) updateEpicAction(btnEpic_2,'false');
    }
    count_now_2.innerHTML = 0;
    if(leader2){
      updateEpicAction(leader2,'false');
      leader2.classList.remove('epicUsed');
      if(epicLeader2) epicLeader2.remove();
    }
  }
}

/**
* Exibe menu para seleção de Bases e Líderes
*/
async function selectBasesLeaders(){
  var playerNames = new Array();
  var bases = new Array();
  var leaders = new Array();
  
  for(let i=1;i<=2;i++){
      var thisPlayerName = document.createElement('input');
      thisPlayerName.id = 'player_name_p'+i;
      thisPlayerName.className = 'input_name';
      thisPlayerName.placeholder = 'Type your name';

      playerNames[i] = thisPlayerName;

      var thisBaseSelect = document.createElement('select');
      thisBaseSelect.id = 'base_p'+i;
      thisBaseSelect.className = 'option_selected';
      thisBaseSelect.innerHTML = '<option value="">Select a Base for Player '+i+'</option>';

      bases[i] = thisBaseSelect;

      var thisLeaderSelect = document.createElement('select');
      thisLeaderSelect.id = 'leader_p'+i;
      thisLeaderSelect.className = 'option_selected';
      thisLeaderSelect.innerHTML = '<option value="">Select the Leader for Player '+i+'</option>';
      leaders[i] = thisLeaderSelect;
  }

  // BASES and LEADERS Options
  bases = await loadBases(bases);
  leaders = await loadLeaders(leaders);
  
  for(let i=0;i<bases.length;i++){
      var thisPlayer = document.getElementById('player_'+(i+1));
      thisPlayer.innerHTML = ''; // LIMPA CONTADORES

      var player = document.createElement('div');
      player.className = 'select_base_leader';
      player.append(bases[i]);
      player.append(leaders[i]);
      player.append(playerNames[i+1]);

      var sendButton = document.createElement('button');
      sendButton.type = 'submit';
      sendButton.className = 'player_'+(i+1);
      sendButton.textContent = 'SEND';
      sendButton.setAttribute('onclick','sendPlayerSelection(this)');

      var blankButton = document.createElement('button');
      blankButton.type = 'submit';
      blankButton.className = 'player_'+(i+1);
      blankButton.textContent = 'QUICK START';
      blankButton.setAttribute('onclick','blankPlayerSelection(this)');

      player.append(sendButton);
      player.append(blankButton);

      thisPlayer.append(player);
  }

  // AJAX call to CLEAN SESSION
  $.ajax({
    url: baseUrl+'ajax/premier.php',
    method: 'GET',
    data:
    {
      session: ''
    },
    dataType: 'text',
    xhrFields: {
        withCredentials: true
    },
    error: function (error,txtStatus,errorThrown)
    {
      console.error("Error:", txtStatus, errorThrown);
      console.error("Resposta do servidor:", error.responseText);
    }
  });
}

/**
* REMOVE as informações de PLAYER e mostra o CONTADOR de vida
*/
function blankPlayerSelection(button){
  if(confirm("Start a quickly game?")){
    for(let id = 1; id<= 2; id++){
      var playerID = 'player_'+id;
      var playerDIV = document.getElementById(playerID);
      var formSelect = playerDIV.querySelector('.select_base_leader');
      playerDIV.removeChild(formSelect);

      //SET CLEAN TABLE
      var count = document.createElement('div');
      count.className = "count w10";
      playerDIV.append(count);

      var leader_data = document.createElement('div');
      leader_data.className = "leader_data";
      leader_data.append(addEpicToken(playerID));
      playerDIV.append(leader_data);

      addCounter(playerID);
    }
  }
}

function sendPlayerSelection(button){
  var playerID = button.classList;
  var playerDIV = document.getElementById(playerID[0]);
  var selectedInfo = playerDIV.getElementsByTagName('select');
  var selectedPlayer = playerDIV.getElementsByClassName('input_name');
  
  if(selectedInfo[0].value != ''){
    // AJAX call SAVE DATA
    $.ajax({
      url: baseUrl+'ajax/app.php',
      method: 'GET',
      data:
      {
        player: playerID[0],
        base : selectedInfo[0].value,
        leader: selectedInfo[1].value,
        playerName : selectedPlayer[0].value,
        store: getUrlParameter('store')
      },
      dataType: 'text',
      xhrFields: {
          withCredentials: true
      },
      success: function (result)
      {
        setPlayerPremierDATA([selectedInfo[0].value,selectedInfo[1].value], playerID[0]);
      },
      error: function (error,txtStatus,errorThrown)
      {
        console.error("Error:", txtStatus, errorThrown);
        console.error("Resposta do servidor:", error.responseText);
        
        selectBasesLeaders();
      }
    });
  }
}

/**
 * SHOW Hitoric off base damages
 */
function showHistoric(){
  //GET Historic
    $.ajax({
      url: baseUrl+'ajax/app.php',
      method: 'GET',
      data:
      {
        player: 'player_1',
        historic : ''
      },
      dataType: 'text',
      xhrFields: {
          withCredentials: true
      },
      success: function (result)
      {
        Swal.fire({
          title: "<strong>Game History:</strong>",
          html: result,
          showCloseButton: true,
          showConfirmButton: false,
          heightAuto: false,
          customClass:{
            heightAuto: false
          }
        });
      },
      error: function (error,txtStatus,errorThrown)
      {
        console.error("Error:", txtStatus, errorThrown);
        console.error("Resposta do servidor:", error.responseText);
        
        selectBasesLeaders();
      }
    });
}

selectBasesLeaders();