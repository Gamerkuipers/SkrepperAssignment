const API_URL = "https://jsonplaceholder.typicode.com/photos";

let galleryEl = document.querySelector('#gallery');

window.onload = () => {
    fetchPictures()
}

function fetchPictures() {
    let request = new XMLHttpRequest();
    request.open("GET", API_URL , true);
    request.onreadystatechange = function () {
        if (request.readyState !== 4 || request.status !== 200) return;
        setPictures(JSON.parse(request.responseText))
    };
    request.send();
}

function setPictures(pictures) {
    let numbers = getRandomNumbers(5, pictures.length)
    numbers.forEach(number => {
        let picture = pictures[number];
        let imageEl = createElement('img', {src: picture.url, class: 'mt-4'})

        galleryEl.append(imageEl)
    })
}

function createElement(element = 'div', attributes = {}, text = '') {
    let el = document.createElement(element);

    if(typeof attributes === 'object') {
        for (let key in attributes) {
            el.setAttribute(key, attributes[key]);
        }
    }

    if (typeof text != "undefined") {
        el.innerHTML = text;
    }

    return el;
}

function getRandomNumbers(amount, max) {
    let numbers = []
    for (let index = 0; index < amount; index++) {
        let randomNumber = Math.random() * max;
        numbers.push(Math.floor(randomNumber))
    }
    return numbers;
}