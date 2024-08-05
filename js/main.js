



// PRENDRE LES MATCHES A PARTIR DE LA BASE DE DONNEES ET LES INSERER SOUS FORM DE JSON
function getMatches(){
    $.ajax({
        url: 'functions/get_matches.php',
        success: ($res) => {console.log($res)}
    })
}
getMatches()
// PRENDRE LES MATCHES A PARTIR DU FICHIER matches.json ET LES AFFICHER DANS LA PAGE
function fetchMatches(){
    fetch('./json/matches.json')
    .then(response => response.json())
        .then(data => {
            // OPERTATIONS SUR DATA
            insertMatches(data);
            
    }).catch(error => console.error('Error fetching JSON: ', error));
}
fetchMatches()



// PRENDRE LES RESERVATIONS A PARTIR DE LA BASE DE DONNEES ET LES INSERER SOUS FORM DE JSON
function getReservations(){
    return $.ajax({
        url: 'functions/get_reservations.php',
        method: 'post',
        success: (response) => {
            return response;
        }
    })
}
getReservations()
// PRENDRE LES RESERVATIONS A PARTIR DU FICHIER reservations.json ET LES AFFICHER DANS LA PAGE
function fetchReservations() {
    fetch('./json/reservations.json')
    .then(response => response.json())
    .then(data => {
        // OPERTATIONS SUR DATA
        insertReservations(data);
    }).catch(error => console.log('Error fetching JSON: ', error))
}
fetchReservations()


// AJOUTER TOUTES LES MATCHES QUI VIENNE DU FICHIER MATCHES.JSON
function insertMatches(data){
    data.forEach(matche => {
        addMatch(matche);
    });
    let best = document.querySelector('.matches .best');
    let boxs = document.querySelector('#matchesContent .box');
    best.appendChild(boxs);
}

// AJOUTER UN MATCH A LA LIST DES MATCHES
function addMatch(matche){
    

    let container = document.getElementById('matchesContent');
    let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    let box = document.createElement('DIV');
    box.className = 'box';

    let dateSplitted = matche.date.split('-');
    
    let date = document.createElement('DIV');
    date.className = 'date';
    let month = document.createElement('SPAN');
    month.textContent = months[+dateSplitted[1]];
    let day = document.createElement('SPAN');
    day.textContent = dateSplitted[2];
    let year = document.createElement('SPAN');
    year.textContent = dateSplitted[0];

    date.appendChild(month);
    date.appendChild(day);
    date.appendChild(year);
    
    let info = document.createElement('DIV');
    info.className = 'info';

    let text = document.createElement('DIV');
    text.className = 'text';
    text.textContent = `${matche.team_home} vs ${matche.team_away}`;
    
    let description = document.createElement('P');
    description.className = 'description';
    description.textContent = `${matche.venue}`;
    
    info.appendChild(text);
    info.appendChild(description);
    
    let btn = document.createElement('BUTTON');
    btn.className = 'ticket-btn';
    btn.textContent = 'Get Ticket';
    btn.onclick = () => window.location = `pages/reserveTicket.php?id_match=${matche.id}`;

    box.appendChild(date);
    box.appendChild(info);
    box.appendChild(btn);

    container.appendChild(box);
}

// AJOUTER TOUTES LES MATCHES QUI VIENNE DU FICHIER RESERVATIONS.JSON

let reservationsContainer = document.querySelector('.reservations');

function insertReservations(reservations){
    reservationsContainer.innerHTML = '';
    if(reservations != ''){
        reservations.forEach(res => {
            insertReservation(res);
        })
    } else {
        reservationsContainer.textContent = "You Don't Have Any Reservation Yet";
    }
}

function insertReservation(MyRes){
    
    let res = document.createElement('DIV');
    res.className = 'res';

    let p1 = document.createElement("P");
    p1.textContent = MyRes['team_home'] + ' VS ' + MyRes['team_away'];
    
    let p2 = document.createElement("P");
    p2.textContent = MyRes.quantity + ' PLACES';

    let btn = document.createElement("BUTTON");
    btn.className = 'cancel_btn';
    btn.textContent = 'X';

    btn.onclick = () => {
        $.ajax({
            url: 'functions/delete_reservation.php',
            method: 'POST',
            data: {
                reservation_id: MyRes.id
            },
            success: (deleted) => {
                getReservations().then((response) => {
                    fetchReservations();
                })
            }
        })
    }

    res.appendChild(p1);
    res.appendChild(p2);
    res.appendChild(btn);

    reservationsContainer.appendChild(res);
}



let show_reservations;
let links = document.getElementById("links");
let overlay = document.getElementById('overlay');


// SAVOIR SI L'UTILISATEUR EST CONNECTEE
$.ajax({
    url: 'functions/is_connected.php',
    method: 'POST',
    success: function(connected){
        if (connected){
            links.innerHTML += `
            <li class="link"><a href="#matches">Get Ticket</a></li>
            <li class="link"><a id='show_reservations' href="#">My Reservations</a></li>
            <li class="link"><a href="functions/log_out.php">Log Out</a></li>
            `;
        }
        else {
            links.innerHTML += `
            <li class="link"><a href="#matches">Get Ticket</a></li>
            <li class="link"><a href="pages/sign_in.php" class="active">Sign in</a></li>
            <li class="link"><a href="pages/log_in.php">Log in</a></li>
            `
        }
        show_reservations = document.getElementById('show_reservations');
        show_reservations.onclick = () => {
            let reservations_menu = document.getElementById('reservations_menu');
            reservations_menu.classList.add('active');
            overlay.classList.add('active');
            document.body.classList.add("block-scrolling");
        }
    }
})







// FIX DES PROBLEMMES DANS LA PAGE

let reservations_menu_cancel_btn = document.querySelector('#reservations_menu .cancel');
reservations_menu_cancel_btn.onclick = () => {
    reservations_menu_cancel_btn.parentElement.parentElement.classList.remove("active");
overlay.classList.remove('active');
document.body.classList.remove("block-scrolling");
}

let header = document.getElementById("header");
headerHeight = header.offsetHeight;
window.onscroll = function(){
    if (window.scrollY > header.offsetHeight){
        header.classList.add("fixed");
    }
    else {
        header.classList.remove("fixed");
    }
}

let indent = document.getElementById('indent');
indent.style.height =  headerHeight + 'px';

function parallaxEffect() {
    const parallax = document.querySelector('main');
    const scrollPosition = window.pageYOffset;
        const zoomFactor = 1 + (scrollPosition / 5000);
        parallax.style.backgroundSize = `${100 * zoomFactor}%`; // Zoom in
}

window.addEventListener('scroll', parallaxEffect);
parallaxEffect();



