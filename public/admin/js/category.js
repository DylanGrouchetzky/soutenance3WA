function editGenre(idGenre,nameGenre,idCategory){
    const ligneGenre = document.getElementById(idGenre);
    const groupBtn = document.getElementById('btn-action-'+idGenre);
    ligneGenre.innerHTML = `<input id="input-genre-${idGenre}" type="text" value="${nameGenre}">`;
    groupBtn.innerHTML = `
            <button onclick="saveNewGenre('${idGenre}','${idCategory}')" class="btn btn-green"><i class="feather-save"></i> <span class="d-responsive-none">Enregistré</span></button>
            <button onclick="cancelEdit('${idGenre}','${nameGenre}','${idCategory}')" class="btn btn-red"><i class="feather-x-circle"></i> <span class="d-responsive-none">Annulé</span></button>
        `;
}
function cancelEdit(idGenre,nameGenre,idCategory){
    const ligneGenre = document.getElementById(idGenre);
    const groupBtn = document.getElementById('btn-action-'+idGenre);
    ligneGenre.innerHTML = nameGenre;
    groupBtn.innerHTML = `
            <button onclick="editGenre('${idGenre}','${nameGenre}','${idCategory}')" class="btn btn-edit"><i class="feather-edit-2"></i> <span class="d-responsive-none">Editer</span></button>
            <a href="/gestion-super-collect/genre/supprimer/${idCategory}/${idGenre}" onclick="return confirm('Vous voulez vraiment supprimer ce genre?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
        `;
}
function saveNewGenre(idGenre,idCategory){
    const newGenre = document.getElementById('input-genre-'+idGenre).value
    const data = {
        genre: newGenre,
        idGenre: idGenre,
        idCategory: idCategory,
    };
    const xhr = new XMLHttpRequest();
    xhr.open('POST','/gestion-super-collect/genre/editer',true);
    xhr.setRequestHeader('Content-Type','application/json');
    xhr.onload = function(){
        if (xhr.status >= 200 && xhr.status < 300) {
            const ligneGenre = document.getElementById(idGenre)
            const groupBtn = document.getElementById('btn-action-'+idGenre)
            ligneGenre.innerHTML = newGenre
            groupBtn.innerHTML = `
                    <button onclick="editGenre('${idGenre}','${newGenre}','${idCategory}')" class="btn btn-edit"><i class="feather-edit-2"></i> <span class="d-responsive-none">Editer</span></button>
                    <a href="/gestion-super-collect/genre/supprimer/${idCategory}/${idGenre}" onclick="return confirm('Vous voulez vraiment supprimer ce genre?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
                `;
        }else if (xhr.status === 400) {
            const erreur = document.querySelector('#erreurAddGenre')
            const jsonResponse = JSON.parse(xhr.responseText);
            const erreurMessage = jsonResponse.message;
            erreur.innerHTML = erreurMessage
        }else{
            console.log('erreur : '+ xhr.status )
        }
    };
    xhr.send(JSON.stringify(data));
}
const btnAddGenre = document.querySelector('#addGenre');
if(btnAddGenre){
    document.querySelector('#addGenre').addEventListener('click', (e) => {
        const newGenre = document.querySelector('#nameNewGenre').value;
        if (!newGenre) {
            const erreur = document.querySelector('#erreurAddGenre')
            erreur.innerHTML = "Le nom du genre ne doit pas être vide";
        }else{
            const idCategory = document.querySelector('#idCategory').value;
            const data = {
                nameGenre: newGenre,
                idCategory: idCategory
            };
            const xhr = new XMLHttpRequest();
            xhr.open('POST','/gestion-super-collect/genre/ajout',true);
            xhr.setRequestHeader('Content-Type','application/json');
            xhr.onload = function(){
                if (xhr.status >= 200 && xhr.status < 300) {
                    const formGenre = document.querySelector('#formNewGenre');
                    const erreur = document.querySelector('#erreurAddGenre');
                    const inputNewGenre = document.querySelector('#nameNewGenre');
                    const today = new Date();
                    const day = today.getDate();
                    const month = today.getMonth() + 1;
                    const year = today.getFullYear();
                    const jsonResponse = JSON.parse(xhr.responseText);
                    const idGenre = jsonResponse.idGenre;
                    erreur.innerHTML = '';
                    inputNewGenre.value = '';
                    let newLigne = `
                                <tr>
                                    <td class="text-capitalize" id="${idGenre}">${newGenre}</td>
                                    <td class="d-responsive-none">${day}/${month}/${year}</td>
                                    <td class="d-responsive-none">${day}/${month}/${year}</td>
                                    <td class="justify-end d-flex" id="btn-action-${idGenre}">
                                        <button onclick="editGenre('${idGenre}','${newGenre}','${idCategory}')" class="btn btn-edit"><i class="feather-edit-2"></i> <span class="d-responsive-none">Editer</span></button>
                                        <a href="/gestion-super-collect/genre/supprimer/${idCategory}/${idGenre}" onclick="return confirm('Vous voulez vraiment supprimer ce genre?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
                                    </td>
                                </tr>
                            `;
                    formGenre.insertAdjacentHTML('beforebegin', newLigne)
                }else if (xhr.status === 400) {
                    const erreur = document.querySelector('#erreurAddGenre')
                    const jsonResponse = JSON.parse(xhr.responseText);
                    const erreurMessage = jsonResponse.message;
                    erreur.innerHTML = erreurMessage
                }else{
                    console.log('erreur : '+ xhr.status )
                }
                
            };
            xhr.send(JSON.stringify(data));
        }
    })
}