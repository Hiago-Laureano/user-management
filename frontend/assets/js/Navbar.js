function addUser(){
    let add = document.querySelector(".section-add-user")
    let list = document.querySelector(".section-list-user")
    add.style.display = "flex"
    list.style.display = "none"
}

function listUsers(){
    let add = document.querySelector(".section-add-user")
    let list = document.querySelector(".section-list-user")
    add.style.display = "none"
    list.style.display = "flex"
}