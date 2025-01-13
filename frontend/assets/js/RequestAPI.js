function loadingAddUser(){
    let spinner = document.querySelector("#load-add-user")
    spinner.style.display = "block"
    let btn = document.querySelector("#btn-add-user")
    btn.style.display = "none"
}

function loadedAddUser(){
    let spinner = document.querySelector("#load-add-user")
    spinner.style.display = "none"
    let btn = document.querySelector("#btn-add-user")
    btn.style.display = "block"
}

function loadingModal(){
    let spinner = document.querySelector("#modal-load")
    spinner.style.display = "block"
    let btnDelete = document.querySelector("#model-btn-delete")
    btnDelete.style.display = "none"
    let btnEdit = document.querySelector("#btn-edit-user")
    btnEdit.style.display = "none"
}

function loadedModal(){
    let spinner = document.querySelector("#modal-load")
    spinner.style.display = "none"
    let btnDelete = document.querySelector("#model-btn-delete")
    btnDelete.style.display = "block"
    let btnEdit = document.querySelector("#btn-edit-user")
    btnEdit.style.display = "block"
}

function loadingListUsers(){
    let table = document.querySelector("#table-users")
    table.innerHTML = ""
    let spinner = document.querySelector("#load-list-users")
    spinner.style.display = "block"
    let btn = document.querySelector("#btn-list-user")
    btn.style.display = "none"
}

function loadedListUsers(){
    let spinner = document.querySelector("#load-list-users")
    spinner.style.display = "none"
    let btn = document.querySelector("#btn-list-user")
    btn.style.display = "block"
}

function closeAllAlerts(){
    let alertList = document.querySelector("#alert-list-user")
    alertList.style.display = "none"
    let alertAdd = document.querySelector("#alert-add-user")
    alertAdd.style.display = "none"
    let alertModal = document.querySelector("#modal-alert")
    alertModal.style.display = "none"
}

function openAlert(alertId, type = "danger", text){
    let alert = document.querySelector(alertId)
    alert.style.display = "block"
    alert.innerHTML = ""
    let content = ""
    if(type === "danger"){
        alert.style.background = "rgb(163, 67, 67)"
        content += '<i class="bi bi-exclamation-diamond-fill"></i> ' + text
    }else if(type === "success"){
        alert.style.background = "rgb(11, 117, 8)"
        content += '<i class="bi bi-check-circle-fill"></i> ' + text
    }
    alert.innerHTML = content
}

function checkPassword(password, rPassword){
    if(password === rPassword){
        return true
    }
    return false
}

function createUser(){
    loadingAddUser()
    let name = document.querySelector("#input-name")
    let email = document.querySelector("#input-email")
    let password = document.querySelector("#input-password")
    let rPassword = document.querySelector("#input-repeat-password")
    if(! checkPassword(password.value, rPassword.value)){
        loadedAddUser()
        openAlert("#alert-add-user", "danger", "As senhas não estão iguais")
        return false
    }
    fetch("http://127.0.0.1:80/api/v1/usuarios", {
        method: "POST",
        headers: {"Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest"},
        body: JSON.stringify({"nome": name.value, "email": email.value, "senha": password.value})
    }).then(res => {
        if(res.status === 201){
            name.value = ""
            email.value = ""
            password.value = ""
            rPassword.value = ""
            loadedAddUser()
            openAlert("#alert-add-user", "success", "Usuário cadastrado")
            return true
        }else if(res.status === 422){
            res.json().then(data => {
                loadedAddUser()
                openAlert("#alert-add-user", "danger", data["message"].split(".")[0])
                return false
            }).catch(e =>{
                loadedListUsers()
                openAlert("#alert-add-user", "danger", "Ocorreu um erro durante o processo, tente novamente")
                return false
            })
        }else{
            loadedAddUser()
            openAlert("#alert-add-user", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
            return false
        }
    }).catch(e =>{
        loadedAddUser()
        openAlert("#alert-add-user", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
        return false
    })
}

function createTableUsers(data){
    let table = document.querySelector("#table-users")
    table.innerHTML = ""
    content = ""
    if(data.data){
        let countPage = document.querySelector("#count-page")
        if(parseInt(countPage.innerHTML) === 0){
            countPage.innerHTML = "1"
        }
        countPage.last = data.links["last"].split("?page=")[1][0]
        let nextButton = document.querySelector("#page-next")
        if(parseInt(countPage.last) === parseInt(countPage.innerHTML)){
            nextButton.style.color = "#ccc"
        }else{
            nextButton.style.color = "black"
        }
        content += '<tr>'
        content += '<th>ID</th>'
        content += '<th>Nome</th>'
        content += '<th>E-mail</th>'
        content += '<th>Data criação</th>'
        content += '<th>Data atualização</th>'
        content += '<th>Atualizar</th>'
        content += '<th>Deletar</th>'
        content += '</tr>'
        for(let i of data.data){
            content += '<tr>'
            content += '<td>'+i.id+'</td>'
            content += '<td>'+i.nome+'</td>'
            content += '<td>'+i.email+'</td>'
            content += '<td>'+i.criado_em+'</td>'
            content += '<td>'+i.atualizado_em+'</td>'
            content += `<td onclick="closeAllAlerts(); openModal('edit', ${i.id}, '${i.nome}', '${i.email}')" class="table-icon"><i style="color: green; width: 100%;" class="bi bi-pencil-square"></i></td>`
            content += `<td onclick="loadedModal(); closeAllAlerts(); openModal('delete', ${i.id})" class="table-icon"><i style="color: red; width: 100%;" class="bi bi-x-square"></i></td>`
            content += '</tr>'
        }
    }else{
        content += '<tr><td>Não há registros</td></tr>'
    }
    table.innerHTML = content
}

function getUsers(){
    loadingListUsers()
    let countPage = document.querySelector("#count-page")
    let page
    if(countPage.innerHTML === "0"){
        page = "1"
    }else{
        page = countPage.innerHTML
    }
    fetch(`http://127.0.0.1:80/api/v1/usuarios?page=${page}`, {
        method: "GET",
        headers: {"Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest"}
    }).then(res => {
        if(res.status === 200){
            res.json().then(data => {
                createTableUsers(data)
                loadedListUsers()
                openAlert("#alert-list-user", "success", "Busca concluída")
                return true
            }).catch(e =>{
                loadedListUsers()
                openAlert("#alert-list-user", "danger", "Ocorreu um erro durante o processo, tente novamente")
                return false
            })
        }else{
            loadedListUsers()
            openAlert("#alert-list-user", "danger", "Ocorreu um erro durante o processo, tente novamente")
            return false
        }
    }).catch(e =>{
        loadedListUsers()
        openAlert("#alert-list-user", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
        return false
    })
}

function deleteUser(){
    loadingModal()
    userId = document.querySelector("#edit-user-id")
    fetch(`http://127.0.0.1:80/api/v1/usuarios/${userId.innerHTML}`, {
        method: "DELETE",
        headers: {"Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest"},
    }).then(res => {
        if(res.status === 204){
            loadedModal()
            let btnDelete = document.querySelector("#model-btn-delete")
            btnDelete.style.display = "none"
            openAlert("#modal-alert", "success", "Usuário deletado")
            getUsers()
            return true
        }else if(res.status === 404){
            res.json().then(data => {
                loadedModal()
                openAlert("#modal-alert", "danger", data["message"])
                return false
            }).catch(e =>{
                loadedModal()
                openAlert("#modal-alert", "danger", "Ocorreu um erro durante o processo, tente novamente")
                return false
            })
        }else{
            loadedModal()
            openAlert("#modal-alert", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
            return false
        }
    }).catch(e =>{
        loadedModal()
        openAlert("#modal-alert", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
        return false
    })
}

function updateUser(){
    loadingModal()
    let id = document.querySelector("#input-edit-id")
    let name = document.querySelector("#input-edit-name")
    let email = document.querySelector("#input-edit-email")
    let password = document.querySelector("#input-edit-password")
    let rPassword = document.querySelector("#input-edit-repeat-password")

    let data = {"nome": name.value, "email": email.value}

    if(password.value !== ""){
        if(! checkPassword(password.value, rPassword.value)){
            loadedModal()
            openAlert("#modal-alert", "danger", "As senhas não estão iguais")
            return false
        }
        data["senha"] = password.value
    }
    fetch(`http://127.0.0.1:80/api/v1/usuarios/${id.value}`, {
        method: "PATCH",
        headers: {"Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest"},
        body: JSON.stringify(data)
    }).then(res => {
        if(res.status === 200){
            password.value = ""
            rPassword.value = ""
            loadedModal()
            openAlert("#modal-alert", "success", "Usuário atualizado")
            getUsers()
            return true
        }else if(res.status === 422){
            res.json().then(data => {
                loadedModal()
                openAlert("#modal-alert", "danger", data["message"].split(".")[0])
                return false
            }).catch(e =>{
                loadedModal()
                openAlert("#modal-alert", "danger", "Ocorreu um erro durante o processo, tente novamente")
                return false
            })
        }else if(res.status === 404){
            res.json().then(data => {
                loadedModal()
                openAlert("#modal-alert", "danger", data["message"])
                return false
            }).catch(e =>{
                loadedModal()
                openAlert("#modal-alert", "danger", "Ocorreu um erro durante o processo, tente novamente")
                return false
            })
        }else{
            loadedModal()
            openAlert("#modal-alert", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
            return false
        }
    }).catch(e =>{
        loadedModal()
        openAlert("#modal-alert", "danger", "Erro ao tentar conectar ao servidor, tente novamente")
        return false
    })
}