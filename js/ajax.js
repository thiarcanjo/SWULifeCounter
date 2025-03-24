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
  
  // GET BASES
  try{
    dbBase = await getCard(playerID, playerData[0]);
  }
  catch(error){
    console.error("ERROR on get a Card: ", error);
  }

  //SET BASE na tela
  playerDIV.style.setProperty('border-color','var(--aspect-'+dbBase.Aspects[0].code+')');
  playerDIV.style.setProperty('background-image','url("'+dbBase.img+'")');

  //SET LEADER na tela
  var leader_data = playerDIV.getElementsByClassName("leader_data");
  var leftContent = document.createElement('div');
  leftContent.className = 'left';

  //GET LEADERS
  if(playerData[1] != ''){
      dbLeader = await getCard(playerID, playerData[1]);
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
      leader_data[0].append(leftContent);
  }

  // VERIFICA se a BASE tem EPIC ACTION e ADD o TOKEN
  if(dbBase.epic) leader_data[0].append(addEpicToken(playerID));

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
      updateEpicAction(btnEpic_1,'false');
    }
    count_now_1.innerHTML = 0;
    updateEpicAction(leader1,'false');
    if(epicLeader1) epicLeader1.remove();
    leader1.classList.remove('epicUsed');

    //PLAYER 2
    var player2DIV = document.getElementById('player_2');
    var epic_token_2 = player2DIV.querySelector('.epic_token');
    var count_now_2 = document.getElementById('count-now_player_2');
    var leader2 = player2DIV.querySelector(".leader-img.player_2.leader");
    var epicLeader2 = player2DIV.querySelector('.epicToken-img');
    if (epic_token_2){
      var btnEpic_2 = epic_token_2.querySelector('.btn');
      btnEpic_2.style = "filter: grayscale(100%);";
      updateEpicAction(btnEpic_2,'false');
    }
    count_now_2.innerHTML = 0;
    updateEpicAction(leader2,'false');
    if(epicLeader2) epicLeader2.remove();
    leader2.classList.remove('epicUsed');
  }
}

/**
* Exibe menu para seleção de Bases e Líderes
*/
function selectBasesLeaders(){
  var bases = Array();
  var leaders = Array();
  for(let i=1;i<=2;i++){
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
  bases = loadBases(bases);
  leaders = loadLeaders(leaders);
  
  for(let i=0;i<bases.length;i++){
      var thisPlayer = document.getElementById('player_'+(i+1));
      var thisCount = thisPlayer.getElementsByClassName('count');
      thisCount[0].innerHTML = ''; // LIMPA CONTADORES

      var player = document.createElement('div');
      player.className = 'select_base_leader';
      player.append(bases[i]);
      player.append(leaders[i]);

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

      thisCount[0].append(player);
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
      var count = playerDIV.querySelector('.count');
      var formSelect = count.querySelector('.select_base_leader');
      count.removeChild(formSelect);
      
      var leader_data = playerDIV.getElementsByClassName("leader_data");
      leader_data[0].append(addEpicToken(playerID));

      addCounter(playerID);
    }
  }
}

function sendPlayerSelection(button){
  var playerID = button.classList;
  var playerDIV = document.getElementById(playerID[0]);
  var selectedInfo = playerDIV.getElementsByTagName('select');
  
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

selectBasesLeaders();