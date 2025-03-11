/**
 * SETA a tela do PLAYER
 * 
 * @param {Array} playerData 
 * @param {string} playerID 
 */
function setPlayerPremierDATA(playerData,playerID){
    var dbBase = '';
    var dbLeader = '';
    var playerDIV = document.getElementById(playerID);
    
    // GET BASES
    dbBase = SearchBaseInfo(playerData[0]);

    //SET BASE na tela
    playerDIV.style.setProperty('border-color','var(--aspect-'+dbBase.aspect.code+')');
    playerDIV.style.setProperty('background-image','url("https://swudb.com/images/cards/'+dbBase.collection.code+'/'+dbBase.number+'.png")');

    //SET LEADER na tela
    var leader_data = playerDIV.getElementsByClassName("leader_data");
    var leftContent = document.createElement('div');
    leftContent.className = 'left';

    //GET LEADERS
    if(playerData[1] != ''){
        dbLeader = SearchLeaderInfo(playerData[1]);
        var leader_img = document.createElement('div');
        leader_img.className = "leader-img";
        leader_img.style.setProperty('background-image', 'url("https://swudb.com/images/cards/'+dbLeader.collection.code+'/'+dbLeader.number+'.png")');
        leader_img.setAttribute('onclick','EpicActionToggle(this)');
        leftContent.append(leader_img);
   
        // ASPECTS
        var aspects = document.createElement('div');
        aspects.className = 'aspects';
        var aspect_base = document.createElement('div');
        aspect_base.className = "aspects-img";
        if(dbBase.aspect.code == 'n') aspect_base.style.setProperty('background-image','none');
        else aspect_base.style.setProperty('background-image','url("./imgs/aspects/'+dbBase.aspect.name+'.png")');
        aspects.append(aspect_base);
        dbLeader.aspect.forEach(e => {
            var aspect_leader = document.createElement('div');
            aspect_leader.className = "aspects-img";
            aspect_leader.style.setProperty('background-image','url("./imgs/aspects/'+e.name+'.png")');
            aspects.append(aspect_leader);
        });
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
}

/**
 * REMOVE as informações de PLAYER e mostra o CONTADOR de vida
 */
function blankPlayerSelection(button){
    var playerID = button.classList;
    var playerDIV = document.getElementById(playerID[0]);
    var count = playerDIV.querySelector('.count');
    var formSelect = count.querySelector('.select_base_leader');
    count.removeChild(formSelect);
    
    var leader_data = playerDIV.getElementsByClassName("leader_data");
    leader_data[0].append(addEpicToken(playerID));

    addCounter(playerID[0]);
}

/**
 * SET Infos para o player selecionado e mostra o CONTADOR de vida
 */
function sendPlayerSelection(button){
    var playerID = button.classList;
    var playerDIV = document.getElementById(playerID[0]);
    var selectedInfo = playerDIV.getElementsByTagName('select');

    if(selectedInfo[0].value != ''){
        setPlayerPremierDATA([selectedInfo[0].value,selectedInfo[1].value], playerID[0]);
    }
}

selectBasesLeaders();