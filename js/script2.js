/**
 * Created by Stig on 24.03.2017.
 */

let TIME = 4;
let hotelTimers = [];
let result = "";
let flightTimers = [];

function init() {
    let button = document.getElementById("analyser_logg");
    document.getElementById("stealTimers").style.visibility="hidden";
    button.addEventListener("click", analyserLogg, true);
}


function analyserLogg() {
    flightTimers = [];
    hotelTimers = [];
    removeChilds(document.getElementById("stealTimers"));
    let inputLog = document.getElementById("logg").value;
    let inputLines = inputLog.split("\n");

    let t1 = performance.now();
    getTimers(inputLines);
    hotelTimers.reverse();
    logArray(hotelTimers);
    postResults();
    let t2 = performance.now();
    console.log("Time: " + (t2-t1));
    saveLog();
}

function getTimers(inputLines) {
    for(let i = 0; i < inputLines.length; i++) {
        let data = inputLines[i];
        if(!data.includes("flyr")) {
            hotelTimers.push(data.split(" ")[TIME]);
        } else {
            flightTimers.push(data.split(" ")[TIME]);
        }
    }
}


function removeChilds(myNode) {
    var fc = myNode.firstChild;

    while(fc) {
        myNode.removeChild( fc );
        fc = myNode.firstChild;
    }
}

function logArray(array) {
    console.log("PRINT ARRAY: ");
    for(let i = 0; i < array.length; i++)
        console.log(array[i]);
}

function postResults() {
    let mod = 7;
    let debug = document.getElementById("debug");
    result = hotelTimers.length + " ganger i hotell mellom " + hotelTimers[hotelTimers.length-1] + " og " + hotelTimers[0] + "<br/>";

    for(let i = 0; i < hotelTimers.length; i++) {
        if(i % mod == 0) {
            result += "<br />";
        }

        if(i < hotelTimers.length-1)
            result += hotelTimers[i] + " | ";
        else
            result += hotelTimers[i];
    }

    result += "</br></br><font style='font-weight: bold'>Stjeletimere: </font><br/>";
    let div = findTimers();

    div.style.visibility="visible";

    debug.innerHTML = result;

}

function HMSToSeconds(hms) {
    let a = hms.split(':');
    let ms = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    ms = ms * 1000;
    return ms;
}

function msToHMS(duration) {
    let seconds = parseInt((duration/1000)%60)
        , minutes = parseInt((duration/(1000*60))%60)
        , hours = parseInt((duration/(1000*60*60))%24);

    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;

    return hours + ":" + minutes + ":" + seconds;
}



function findTimers () {

    //Get the minute and second select-menu
    let minSelect = document.getElementById("minutes");
    let secSelect = document.getElementById("seconds");

    //Get minutes and seconds from select-menu
    let minInput = minSelect.options[minSelect.selectedIndex].value;
    let secInput = secSelect.options[secSelect.selectedIndex].value;


    let limit = HMSToSeconds("00:"+minInput+":"+secInput);
    console.log("LIMIT: " + limit);
    let div = document.getElementById("stealTimers");

    for(let i = 0; i < hotelTimers.length; i++) {

        let span = document.createElement("SPAN");
        span.getAttribute("id", "time"+i);
        span.style.padding = "10px";
        let foundMatch = false;
        let timeToAnalyze = HMSToSeconds(hotelTimers[i]);

        let stealTimes = msToHMS(timeToAnalyze) + ": ";

        let stopSearch = false;
        for(let j = i+1; j < hotelTimers.length && !stopSearch; j++) {
            let nextTime = HMSToSeconds(hotelTimers[j]);
            let diff = nextTime - timeToAnalyze;

            console.log("Diff: " + diff + ", 5 min: " + 5*60*1000 + ", limit: " + limit);
            if(diff >= 5*60*1000 && diff < limit) {
                stealTimes = stealTimes + " " + msToHMS(nextTime) + " | ";
                foundMatch = true;
            }
        }

        if(!foundMatch) {
            stealTimes += " ( X ) </br></span>";
            span.style.color="red";
        } else {
            stealTimes+= " </br></span>";
            foundMatch = false;
            span.style.color="green";
        }
        console.log(stealTimes);
        span.innerHTML = stealTimes;
        div.appendChild(span);
    }

    return div;
}

function saveLog() {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };

    xhttp.open("POST", "controller/add_to_log.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("type=Timing&status=Logg analysert&message=Trykket analyser logg");
}




document.addEventListener("DOMContentLoaded", init, false);
