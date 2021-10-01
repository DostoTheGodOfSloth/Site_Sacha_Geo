<<<<<<< HEAD
/* CONSTANTES */

//1
const text = document.getElementById("text");               //On récupére le text

/**
 * Class StopWatch
 * @param {*} elem  Element text 
 * @param {*} delay Temps entre chaque refresh
 */
const Stopwatch = function(elem, delay) 
{
    let offset;
    let clock = 0;
    let interval;

    render();

  function start() {
    if (!interval) {
      offset   = Date.now();
      interval = setInterval(update, delay);
    }
  }

  function stop() {
    if (interval) {
      clearInterval(interval);
      interval = null;
    }
  }

  function update() {
    clock = delta();
    render();
  }

  function render() {
    elem.innerText = Format(new Date(clock)); 
  }

  function delta() {
    return Date.now() - offset;
  }

  // public API
  this.start  = start;
  this.stop  = stop;
};

window.onload = function() {
    new Stopwatch(text, 100).start();
}

function Format(date) {
    return `${("0" + (date.getHours() - 1)).slice(-2)}:${("0" + date.getMinutes()).slice(-2)}:${("0" + date.getSeconds()).slice(-2)}`;
=======
/* CONSTANTES */

//1
const text = document.getElementById("text");               //On récupére le text

/**
 * Class StopWatch
 * @param {*} elem  Element text 
 * @param {*} delay Temps entre chaque refresh
 */
const Stopwatch = function(elem, delay) 
{
    let offset;
    let clock = 0;
    let interval;

    render();

  function start() {
    if (!interval) {
      offset   = Date.now();
      interval = setInterval(update, delay);
    }
  }

  function stop() {
    if (interval) {
      clearInterval(interval);
      interval = null;
    }
  }

  function update() {
    clock = delta();
    render();
  }

  function render() {
    elem.innerText = Format(new Date(clock)); 
  }

  function delta() {
    return Date.now() - offset;
  }

  // public API
  this.start  = start;
  this.stop  = stop;
};

window.onload = function() {
    new Stopwatch(text, 100).start();
}

function Format(date) {
    return `${("0" + (date.getHours() - 1)).slice(-2)}:${("0" + date.getMinutes()).slice(-2)}:${("0" + date.getSeconds()).slice(-2)}`;
>>>>>>> 52483df8747c43191efbd10f394b24588eb337aa
}