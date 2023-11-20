function editTome(idTome,nameTome){
    const ligneTome = document.getElementById(idTome)
    const groupBtn = document.getElementById('btn-action-'+idTome)
    ligneTome.innerHTML = `<input id="input-tome-${idTome}" type="text" value="${nameTome}">`
    groupBtn.innerHTML = `
            <button onclick="saveNewName('${idTome}')" class="btn btn-green"><i class="feather-save"></i> <span class="d-responsive-none">Enregistré</span></button>
            <button onclick="cancelEdit('${idTome}','${nameTome}')" class="btn btn-red"><i class="feather-x-circle"></i> <span class="d-responsive-none">Annulé</span></button>
        `
}
function cancelEdit(idTome,nameTome){
    const ligneTome = document.getElementById(idTome)
    const groupBtn = document.getElementById('btn-action-'+idTome)
    const idCollection = document.getElementById('idCollection').value
    ligneTome.innerHTML = nameTome;
    groupBtn.innerHTML = `
            <button onclick="editTome('${idTome}','${nameTome}')" class="btn btn-edit"><i class="feather-edit-2"></i> <span class="d-responsive-none">Editer</span></button>
            <a href="/gestion-super-collect/tome/${idCollection}/supprimer/${idTome}" onclick="return confirm('Vous voulez vraiment supprimer ce tome?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
        `;
}
function saveNewName(idTome){
    const newName = document.getElementById('input-tome-'+idTome).value
    const data = {
            tome: newName,
            idTome: idTome,
        };
        const xhr = new XMLHttpRequest();
        xhr.open('POST','/gestion-super-collect/tome/editer',true);
        xhr.setRequestHeader('Content-Type','application/json');
        xhr.onload = function(){
            if (xhr.status >= 200 && xhr.status < 300) {
                const idCollection = document.querySelector('#idCollection').value
                const ligneTome = document.getElementById(idTome)
                const groupBtn = document.getElementById('btn-action-'+idTome)
                ligneTome.innerHTML = newName;
                groupBtn.innerHTML = `
                        <button onclick="editTome('${idTome}','${newName}')" class="btn btn-edit"><i class="feather-edit"></i> <span class="d-responsive-none">Editer</span></button>
                        <a href="/gestion-super-collect/tome/${idCollection}/supprimer/${idTome}" onclick="return confirm('Vous voulez vraiment supprimer ce tome?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
                    `
            }else if (xhr.status === 400) {
                const erreur = document.querySelector('#erreurAddTome')
                const jsonResponse = JSON.parse(xhr.responseText);
                const erreurMessage = jsonResponse.message;
                erreur.innerHTML = erreurMessage
            }else{
                console.log('erreur : '+ xhr.status )
            }
        };
        xhr.send(JSON.stringify(data));
}
const btnAddTome = document.querySelector('#addTome')
if (btnAddTome) {
    btnAddTome.addEventListener('click', (e) => {
        const newTome = document.querySelector('#nameNewTome').value
        const idCollection = document.querySelector('#idCollection').value
        const formTome = document.querySelector('#formNewTome')
        const today = new Date();
        const day = today.getDate();
        const month = today.getMonth() + 1;
        const year = today.getFullYear();
        const data = {
                tome: newTome,
                collection: idCollection
            };
            const xhr = new XMLHttpRequest();
            xhr.open('POST','/gestion-super-collect/tome/ajout',true);
            xhr.setRequestHeader('Content-Type','application/json');
            xhr.onload = function(){
                if (xhr.status >= 200 && xhr.status < 300) {
                    const erreur = document.querySelector('#erreurAddTome')
                    const inputNewTome = document.querySelector('#nameNewTome')
                    const jsonResponse = JSON.parse(xhr.responseText);
                    const idTome = jsonResponse.idTome;
                    erreur.innerHTML = ''
                    inputNewTome.value = ''
                    let newLigne = `
                             <tr>
                                 <td class="text-capitalize" id="${idTome}">${newTome}</td>
                                 <td class="d-responsive-none">${day}/${month}/${year}</td>
                                 <td class="d-responsive-none">${day}/${month}/${year}</td>
                                 <td class="justify-end d-flex" id="btn-action-${idTome}">
                                     <button onclick="editTome('${idTome}','${newTome}')" class="btn btn-edit"><i class="feather-edit"></i> <span class="d-responsive-none">Editer</span></button>
                                     <a href="/gestion-super-collect/tome/${idCollection}/supprimer/${idTome}" onclick="return confirm('Vous voulez vraiment supprimer ce tome?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
                                 </td>
                             </tr>
                         `
                    formTome.insertAdjacentHTML('beforebegin', newLigne)
                }else if (xhr.status === 400) {
                    const erreur = document.querySelector('#erreurAddTome')
                    const jsonResponse = JSON.parse(xhr.responseText);
                    const erreurMessage = jsonResponse.message;
                    erreur.innerHTML = erreurMessage
                }else{
                    console.log('erreur : '+ xhr.status )
                }
                
            };
            xhr.send(JSON.stringify(data));
    })
}
function addTomeGroup(idGroup) {
    const nameNewTomeGroup = document.querySelector('#nameNewTome-'+idGroup).value
    const idCollection = document.querySelector('#idCollection').value
    const formGroupTome = document.querySelector('#form-'+idGroup)
    const data = {
            nameNewTomeGroup: nameNewTomeGroup,
            collection: idCollection,
            group: idGroup
        };
        const xhr = new XMLHttpRequest();
        xhr.open('POST','/gestion-super-collect/groupe/ajout/tome',true);
        xhr.setRequestHeader('Content-Type','application/json');
        xhr.onload = function(){
            if (xhr.status >= 200 && xhr.status < 300) {
                const erreur = document.querySelector('#erreurAddTome-'+idGroup)
                const inputNewGroupTome = document.querySelector('#nameNewTome-'+idGroup)
                const jsonResponse = JSON.parse(xhr.responseText);
                const idTome = jsonResponse.idTome;
                const today = new Date();
                const day = today.getDate();
                const month = today.getMonth() + 1;
                const year = today.getFullYear();
                erreur.innerHTML = ''
                inputNewGroupTome.value = ''
                let newLigne = `
                             <tr>
                                 <td class="text-capitalize" id="${idTome}">${nameNewTomeGroup}</td>
                                 <td class="d-responsive-none">${day}/${month}/${year}</td>
                                 <td class="d-responsive-none">${day}/${month}/${year}</td>
                                 <td class="justify-end d-flex" id="btn-action-${idTome}">
                                     <button onclick="editTome('${idTome}','${nameNewTomeGroup}')" class="btn btn-edit"><i class="feather-edit"></i> <span class="d-responsive-none">Editer</span></button>
                                     <a href="/gestion-super-collect/tome/${idCollection}/supprimer/${idTome}" onclick="return confirm('Vous voulez vraiment supprimer ce tome?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
                                 </td>
                             </tr>
                         `
                formGroupTome.insertAdjacentHTML('beforebegin', newLigne)
            }else if (xhr.status === 400) {
                const erreur = document.querySelector('#erreurAddTome-'+idGroup)
                const jsonResponse = JSON.parse(xhr.responseText);
                const erreurMessage = jsonResponse.message;
                erreur.innerHTML = erreurMessage
            }else{
                console.log('erreur : '+ xhr.status )
            }
            
        };
        xhr.send(JSON.stringify(data));
}