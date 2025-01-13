function backPage(){
    let page = document.querySelector("#count-page")
    let back = document.querySelector("#page-back")
    let next = document.querySelector("#page-next")
    if(parseInt(page.innerHTML) === 2){
        back.style.color = "#ccc"
        page.innerHTML = `${parseInt(page.innerHTML)-1}`
        next.style.color = "black"
        return true
    }else if(parseInt(page.innerHTML) > 1){
        back.style.color = "black"
        page.innerHTML = `${parseInt(page.innerHTML)-1}`
        next.style.color = "black"
        return true
    }
    return false
}

function nextPage(){
    let page = document.querySelector("#count-page")
    let next = document.querySelector("#page-next")
    let back = document.querySelector("#page-back")
    if(parseInt(page.innerHTML) === parseInt(page.last)-1){
        next.style.color = "#ccc"
        page.innerHTML = `${parseInt(page.innerHTML)+1}`
        back.style.color = "black"
        return true
    }else if(parseInt(page.innerHTML) < parseInt(page.last)){
        next.style.color = "black"
        page.innerHTML = `${parseInt(page.innerHTML)+1}`
        back.style.color = "black"
        return true
    }
    return false
}