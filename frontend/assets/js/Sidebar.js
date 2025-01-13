function openSidebar(){
    let sidebar = document.querySelector(".nav-sidebar")
    let buttonOpen = document.querySelector(".icon-menu")
    let buttonClose = document.querySelector(".icon-close-sidebar")
    sidebar.style.left = 0
    buttonOpen.style.display = "none"
    buttonClose.style.display = "block"
}

function closeSidebar(){
    let sidebar = document.querySelector(".nav-sidebar")
    let buttonOpen = document.querySelector(".icon-menu")
    let buttonClose = document.querySelector(".icon-close-sidebar")
    sidebar.style.left = "-300px"
    buttonOpen.style.display = "block"
    buttonClose.style.display = "none"
}