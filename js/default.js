/**
 * CALL game screen
 **/ 
function callGame(){
    var selectedFormat = document.querySelector('input[name="formato"]:checked').value;
    if(selectedFormat == "premier") window.location.href = selectedFormat+'.php';
    else window.location.href = selectedFormat+'.html';
}

/**
 * BUSCA informações no BD de BASES
 * 
 * @param sBase
 * @return Array
 **/
function SearchBaseInfo(sBase){
    var code = "";
    if(Array.isArray(sBase)) code = sBase.value
    else code = sBase;

    for(const item of base){
        if(item.code == code){
            return item;
        }
    }
}

/**
 * BUSCA informações no BD de Leaders
 * 
 * @param sBase
 * @return Array
 **/
function SearchLeaderInfo(sLeader){
    var code = "";
    if(Array.isArray(sLeader)) code = sLeader.value
    else code = sLeader;

    for(const item of leader){
        if(item.code == code){
            return item;
        }
    }
}

/**
 * Carrega os OPTIONS do SELECT com bases
 * 
 * @param {string} bases 
 * @return Array
 **/
function loadBases(bases = ""){
    if(!(Array.isArray(bases))) var bases = document.getElementsByClassName("option_selected");
    else bases.shift();
    
    for(const e of bases){
        base.sort((a, b) => a.name.localeCompare(b.name));
        for(const item of base){
            var option = document.createElement("option");
            option.value = item.collection.code+item.number;
            option.text = `${item.name} (${item.collection.code})`;

            e.add(option);
        }
    }

    if(Array.isArray(bases)) return bases;
}

/**
 * Carrega os OPTIONS do SELECT com líderes
 * 
 * @param {string} leaders
 * @return Array
 **/
function loadLeaders(leaders = ""){
    if(!(Array.isArray(leaders))) var leaders = document.getElementsByClassName("option_selected");
    else if(leaders.length==3) leaders.shift();
    
    for(const e of leaders){
        leader.sort((a, b) => a.name.localeCompare(b.name));
        for(const item of leader){
            var option = document.createElement("option");
            option.value = item.collection.code+item.number;
            option.text = `${item.name} (${item.collection.code})`;

            e.add(option);
        }
    }

    if(Array.isArray(leaders)) return leaders;
}

/**
 * Volta para o MENU inicial
 **/
function goHome(){
    if(confirm("Finish this game and go back to the Home?")) history.back();
}

/**
 * CRIA o Epic Token e retorna para APPEND na tela
 * 
 * @param {string} playerID 
 * @returns object
 */
function addEpicToken(playerID){
    var epic_token = document.createElement('div');
    epic_token.className = 'epic_token';
    var btnEpic = document.createElement('button');
    btnEpic.className = 'btn '+playerID+" base";
    btnEpic.setAttribute('onclick','useEpicAction(this)');
    btnEpic.style = "filter: grayscale(100%);";
    var epic_img = document.createElement('img');
    epic_img.src = "./imgs/tokens/epic_token.png";
    epic_img.alt = "Use epic action from Base";

    btnEpic.append(epic_img);
    epic_token.append(btnEpic);

    return epic_token;
}

/**
 * SETA a EPIC ACTION da BASE
 * 
 * @param {object} btn 
 */
function useEpicAction(btn){
    var thisButton = Array.from(btn.classList);
    var playerDIV = document.getElementById(thisButton[1]);
    var epic_token = playerDIV.querySelector('.epic_token');
    var btnEpic = epic_token.querySelector('.btn');
    var epicValue = false;

    if (btnEpic.style.filter == "grayscale(100%)"){
        btnEpic.style = "filter: none;";
        epicValue = true;
    }
    else {
        btnEpic.style = "filter: grayscale(100%);";
        epicValue = false;
    }

    updateEpicAction(btn,epicValue);
}

/**
 * SETA a EPIC ACTION do Líder
 * 
 * @param {object} btn 
 */
function EpicActionToggle(btn){
    btn.classList.toggle('epicUsed');
    var wasEpicUsed = btn.classList.contains('epicUsed');

    updateEpicAction(btn,wasEpicUsed);
}

function updateEpicAction(btn,epicValue){
    var thisButton = Array.from(btn.classList);
    var player = thisButton[1];
    var epicType = thisButton[2];

    $.ajax({
        url: baseUrl + 'premier_live.php',
        method: 'GET',
        data: {
            player: player,
            update: epicType,
            value: epicValue
        },
        dataType: 'text',
        xhrFields: {
            withCredentials: true
        },
        error: function (error, txtStatus, errorThrown) {
            console.error("Error "+player+":", txtStatus, errorThrown);
            console.error("Resposta do servidor "+player+":", error.responseText);
        }
    });
}