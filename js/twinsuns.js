const ts_buttons = document.getElementById('ts_buttons'); // MENU DE TOKENS

/**
 * GET Token para o PLAYER
 * 
 * @param {string} btn 
 */
function getToken(btn){
    var btnClicked = tokenGetted(btn);

    clearTokens(btn); // remove o token clicado de outro player

    // Verifica qual PLAYER já pegou TOKEN e remove do menu
    var inputOptions = {};
    for(p=1;p<=4;p++){
        var playerDiv = document.getElementById('token_player_'+p);
        var divImg = playerDiv.getElementsByTagName('img');

        if(divImg.length == 0) inputOptions['player_'+p] = ' '+p+' ';
    }

    Swal.fire({
        title: 'Which PLAYER wants: '+btnClicked[0]+'('+btnClicked[1]+')?',
        input: 'radio',
        inputOptions,
        inputValidator: (value) => {
            if (!value) {
              return "Choose one PLAYER!";
            }
        },
        showCancelButton: true,
        willOpen: () => {
            //var swal_radio = document.getElementsByClassName('swal2-radio');
            var labels = document.querySelectorAll('.swal2-radio label');
            labels.forEach(e => {
                var id = e.getElementsByTagName('span');
                id = id[0].innerHTML;
                e.style.setProperty('background-color','var(--player-'+id+')');
            });
        }
    }).then((result) => {
        if (result.value){
            btn.style.display = 'none';
            // result.value
            var playerTurn = document.getElementById('token_'+result.value);
            playerTurn.innerHTML = '';
            playerTurn.append(btnClicked[2]);
            playerTurn.style.setProperty('background-color','#666');

            if(btnClicked[0]=='BLAST'){
                for(p=1;p<=4;p++){
                    if(result.value != 'player_'+p){
                        var count_now = document.getElementById('count-now_'+'player_'+p);
                        count_value = parseInt(count_now.innerHTML) + 1 ;
                        count_now.innerHTML = count_value;
                    }
                }
            }
        }
    });
}

/**
 * GET Token para o PLAYER
 * 
 * @param {string} btn 
 */
function clearTokens(btn = ""){
    if(btn!=""){
        var btnClicked = tokenGetted(btn);
    
        for(let p=1;p<=4;p++){
            var playerTurn = document.getElementById('token_player_'+p);
            
            if(playerTurn){
                playerTurn.style.setProperty('background-color','transparent');
                const imagens = playerTurn.getElementsByTagName('img');

                // Percorre as imagens e verifica o atributo src
                for (let i = 0; i < imagens.length; i++) {
                    if (imagens[i].src === btnClicked[2].src) {
                        playerTurn.innerHTML = '';
                    }
                }
            }
        }
    }
    else{
        const buttons = document.querySelectorAll('.ts_buttons button');
        buttons.forEach(button => {
            button.style.display = "inline-block";
        });

        for(let p=1;p<=4;p++){
            var playerTurn = document.getElementById('token_player_'+p);
            playerTurn.innerHTML = '';
            playerTurn.style.setProperty('background-color','transparent');
        }
    }
}

/**
 * Veririfca qual Token foi clicado
 * 
 * @param {string} btn 
 * @returns Array
 */
function tokenGetted(btn){
    var thisButton = Array.from(btn.classList);

    var btnClicked = new Array(2);
    if(thisButton.includes("btn-blast")){
        btnClicked[0] = 'BLAST';
        btnClicked[1] = 'Deal 1 Damage to enenmy bases';
        btnClicked[2] = document.createElement('img');
        btnClicked[2].src = './imgs/tokens/blast.png';
        btnClicked[2].className = 'btn-blast';
        btnClicked[2].alt = btnClicked[1];
        btnClicked[3] = 'btn-blast';
    }
    else if (thisButton.includes("btn-plan")){
        btnClicked[0] = 'PLAN';
        btnClicked[1] = 'Draw 1 card, put 1 card on bottom';
        btnClicked[2] = document.createElement('img');
        btnClicked[2].src = './imgs/tokens/plan.png';
        btnClicked[2].className = 'btn-plan';
        btnClicked[2].alt = btnClicked[1];
        btnClicked[3] = 'btn-plan';
    }
    else if (thisButton.includes("btn-initiative")){
        btnClicked[0] = 'INITIATIVE';
        btnClicked[1] = 'Initiative';
        btnClicked[2] = document.createElement('img');
        btnClicked[2].src = './imgs/tokens/initiative.png';
        btnClicked[2].className = 'btn-Initiative';
        btnClicked[2].alt = btnClicked[1];
        btnClicked[3] = 'btn-initiative';
    }

    return btnClicked;
}

/**
 * Pega o posicionamento central da PAGE para centralizar o menu de tokens
 */
function posMenuTokens(){
    const buttonp1 = document.getElementById('base_p1');
    const buttonp4 = document.getElementById('base_p4');
    
    // Obtém a posição do botão
    const posButtonp1 = buttonp1.getBoundingClientRect();
    const posButtonp4 = buttonp4.getBoundingClientRect();
    var bottomPos = ((posButtonp4.bottom - posButtonp1.bottom)/2)+ posButtonp1.bottom;

    bottomPos = bottomPos - (ts_buttons.offsetHeight / 2) - 90;
    
    // Define a posição da div flutuante
    ts_buttons.style.top = bottomPos + 'px';
}

/**
 * Exibe menu para seleção de Bases e Líderes
 */
function selectBasesLeaders(){
    var bases = Array();
    var leaders = Array();
    for(let i=1;i<=4;i++){
        var thisBaseSelect = document.createElement('select');
        thisBaseSelect.id = 'base_p'+i;
        thisBaseSelect.className = 'option_selected';
        thisBaseSelect.innerHTML = '<option value="">Select a Base for Player '+i+'</option>';

        bases[i] = thisBaseSelect;

        for(let l=0;l<2;l++){
            var thisLeaderSelect = document.createElement('select');
            thisLeaderSelect.id = 'leader_p'+i+'_'+(l+1);
            thisLeaderSelect.className = 'option_selected';
            thisLeaderSelect.innerHTML = '<option value="">Select the '+(l+1)+'º Leader for Player '+i+'</option>';
            leaders[leaders.length] = thisLeaderSelect;
        }
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

        player.append(leaders[0]);
        player.append(leaders[1]);
        leaders.shift();
        leaders.shift();

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

        if(selectedInfo[1].value != '' && selectedInfo[2].value != ''){
            var leader_1 = SearchLeaderInfo(selectedInfo[1].value);
            var leader_2 = SearchLeaderInfo(selectedInfo[2].value);
            
            if(leader_1.code != leader_2.code ){
                var leader_1_type = '';
                leader_1.aspect.forEach(e => {
                    if((e.code == 'w' || e.code == 'b') && leader_1_type == '') leader_1_type = e.code;
                });

                var leader_2_type = '';
                leader_2.aspect.forEach(e => {
                    if((e.code == 'w' || e.code == 'b') && leader_2_type == '') leader_2_type = e.code;
                });
                
                if(leader_1_type != leader_2_type) alert('Select LEADERS from the same Affiliation!');
                else setPlayerTSDATA([selectedInfo[0].value,selectedInfo[1].value,selectedInfo[2].value], playerID[0]);
            }
            else alert('Select different LEADERS!');
        }
        else setPlayerTSDATA([selectedInfo[0].value,'',''], playerID[0]);
    }
}

/**
 * SET imagens para o player selecionado
 * 
 * @param {Array} playerData 
 * @param {string} playerID 
 */
function setPlayerTSDATA(playerData,playerID){
    var dbBase = '';
    var dbLeader = new Array(2);
    var playerDIV = document.getElementById(playerID);
    
    // GET BASES
    dbBase = SearchBaseInfo(playerData[0]);

    //SET BASE na tela
    var base_data = playerDIV.getElementsByClassName("base_data");
    var base_img = document.createElement('div');
    base_img.className = 'base-img';
    base_img.style.setProperty('background-image','url("https://swudb.com/images/cards/'+dbBase.collection.code+'/'+dbBase.number+'.png")');
    base_img.setAttribute('onclick','EpicActionToggle(this)');
    base_data[0].append(base_img);
    
    var leader_data = playerDIV.getElementsByClassName("leader_data");
    if(playerData[1] != '' && playerData[2] != ''){
        //GET LEADERS
        dbLeader[0] = SearchLeaderInfo(playerData[1]);
        dbLeader[1] = SearchLeaderInfo(playerData[2]);
        for(let l=0;l<2;l++){
            var leader = document.createElement('div');
            leader.className = "leader-img";
            leader.style.setProperty('background-image','url("https://swudb.com/images/cards/'+dbLeader[l].collection.code+'/'+dbLeader[l].number+'.png")');
            leader.setAttribute('onclick','EpicActionToggle(this)');
            leader_data[0].append(leader);
        }
    }

    var count = playerDIV.querySelector('.count');
    var formSelect = count.querySelector('.select_base_leader');
    count.removeChild(formSelect);

    addCounter(playerID);
}

selectBasesLeaders();
posMenuTokens();
