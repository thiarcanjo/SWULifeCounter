const getUrl = window.location;
const baseUrl = getUrl .protocol + "//" + getUrl.host + "/";// + getUrl.pathname.split('/')[1];
const fileUrl = getUrl.pathname.split('/')[1];
let Leaders = new Array();
let Bases = new Array();

/**
 * CALL game screen
 **/ 
function callGame(){
    var selectedFormat = document.querySelector('input[name="formato"]:checked').value;
    var selectedStore = document.querySelector('select[id="store"]').value;

    if(selectedStore != '') window.location.href = selectedFormat+'.php?store='+selectedStore;
    else window.location.href = selectedFormat+'.php';
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

    for(const item of Bases){
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

    for(const item of Leaders){
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
async function loadBases(bases = ""){
    if(!(Array.isArray(bases))) var bases = document.getElementsByClassName("option_selected");
    else bases.shift();
    
    var result = getCard('all','base').then(dbBases => {
        for(const e of bases){
            //base.sort((a, b) => a.name.localeCompare(b.name));
            for(const item of dbBases){
                if (!(item.code in Bases)) Bases.push(item);
                var option = document.createElement("option");
                option.value = item.Collection.code + item.number;
                option.text = `${item.name} (${item.Collection.code})`;
                e.add(option);
            }
        }
    
        if(Array.isArray(bases)) return bases;
    });

    return result;
}

/**
 * Carrega os OPTIONS do SELECT com líderes
 * 
 * @param {string} leaders
 * @return Array
 **/
async function loadLeaders(leaders = ""){
    if(!(Array.isArray(leaders))) var leaders = document.getElementsByClassName("option_selected");
    else if(leaders.length==3) leaders.shift();
    
    var result = getCard('all','leader').then(dbLeaders => {
        for(const e of leaders){
            //leader.sort((a, b) => a.name.localeCompare(b.name));
            for(const item of dbLeaders){
                if (!(item.code in Leaders)) Leaders.push(item);
                var option = document.createElement("option");
                option.value = item.Collection.code + item.number;
                option.text = `${item.name} (${item.Collection.code})`;
    
                e.add(option);
            }
        }
    
        if(Array.isArray(leaders)) return leaders;
    });

    return result;
}

/**
 * Volta para o MENU inicial
 **/
function goHome(){
    if(confirm("Finish this game and go back to the Home?")) window.location.href = baseUrl;
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
    var epic_img = document.createElement('img');
    epic_img.className = "epicToken-img"
    epic_img.src = "./imgs/tokens/epic_token.png";

    btn.classList.toggle('epicUsed');
    var wasEpicUsed = btn.classList.contains('epicUsed');
    var epicToken = btn.querySelector('.epicToken-img');

    if(wasEpicUsed && !epicToken) btn.appendChild(epic_img);
    else if(!wasEpicUsed && epicToken) epicToken.remove();

    updateEpicAction(btn,wasEpicUsed);
}

/**
 * UPDATE Epic Action data on DB
 * 
 * @param {string} btn 
 * @param {string} epicValue 
 */
function updateEpicAction(btn,epicValue){
    var thisButton = Array.from(btn.classList);
    var player = thisButton[1];
    var epicType = thisButton[2];
    
    if(fileUrl != 'twinsuns.php'){
        $.ajax({
            url: baseUrl + 'ajax/app.php',
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
}

/**
 * GET Card data on DB
 * 
 * @param {string} player 
 * @param {string} code 
 */
async function getCard(code,type = null){
    try{
      const response = await $.ajax({
        url: baseUrl + 'ajax/app.php',
        method: 'GET',
        data: {
          card: code,
          type: type
        },
        dataType: 'json',
        xhrFields: {
          withCredentials: true
        },
        error: function (error, txtStatus, errorThrown) {
          console.error("Error :", txtStatus, errorThrown);
          console.error("Resposta do servidor :", error.responseText);
        }
      });
  
      return response;
    }
    catch (error){
      console.error("Error :", error.statusText, error.thrown);
      console.error("Resposta do servidor :", error.responseText);
      return null;
    }
}

function getUrlParameter(name) {
    name = name.replace(/[\[]/g, '\\[').replace(/[\]]/g, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    
    if (results === null) return '';
    else return decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function DEBUG(msg, json = false){
    if(json) console.log(JSON.stringify(msg, null, 2));
    else console.log(msg);
}

function getWindowSize(){
    alert(window.innerWidth+" x "+window.innerHeight);
}
