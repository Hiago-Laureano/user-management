function closeModal(){
    let modal = document.querySelector(".modal-section")
    modal.style.display = "none"
}

function openModal(type, userId, nameUser = "", emailUser = ""){
    let modal = document.querySelector(".modal-section")
    modal.style.display = "flex"
    if(type === "delete"){
        modal.style.height = "200px"
        let editModal = document.querySelector(".modal-section-edit")
        editModal.style.display = "none"
        let deleteModal = document.querySelector(".modal-section-delete")
        deleteModal.style.display = "flex"
        let referenceUserId = document.querySelector("#edit-user-id")
        referenceUserId.innerHTML = ""
        referenceUserId.innerHTML = userId
    }else if(type === "edit"){
        modal.style.height = "auto"
        let deleteModal = document.querySelector(".modal-section-delete")
        deleteModal.style.display = "none"
        let editModal = document.querySelector(".modal-section-edit")
        editModal.style.display = "flex"

        let id = document.querySelector("#input-edit-id")
        let name = document.querySelector("#input-edit-name")
        let email = document.querySelector("#input-edit-email")
        id.value = userId
        name.value = nameUser
        email.value = emailUser
    }
}