$(document).ready(function()
{
    const clock = document.getElementById('clock');
    const gameTime = 55;
    let timerStarted = false;
    let intervalId;
    let clockTimer;
    clock.textContent = 'START CLOCK!';

    function beginTime() {
        if (!timerStarted) {
            clockTimer = gameTime * 60;
            updateClock();
            intervalId = setInterval(updateClock, 1000);
            timerStarted = true;
        }
        else{
            if(confirm('('+clock.textContent+') Stop clock to start again?')){
                clock.textContent = 'START CLOCK!';
                clearInterval(intervalId);
                timerStarted = false;
            }
        }
    }

    function updateClock() {
        const minutes = Math.floor(clockTimer / 60);
        const seconds = clockTimer % 60;

        const formattedMinutes = String(minutes).padStart(2, '0');
        const formattedSeconds = String(seconds).padStart(2, '0');

        clock.textContent = `${formattedMinutes}:${formattedSeconds}`;

        if (--clockTimer < 0) {
            clearInterval(intervalId);
            clock.textContent = "TIME END - LAST TURN";
            timerStarted = false;
        }
    }

    clock.addEventListener('click', beginTime);
});