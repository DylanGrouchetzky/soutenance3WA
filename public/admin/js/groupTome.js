function editGroup(idGroup,nameGroup){
    const ligneTome = document.getElementById(idGroup)
    const groupBtn = document.getElementById('btn-action-'+idGroup)
    ligneTome.innerHTML = `<input id="input-group-${idGroup}" type="text" value="${nameGroup}">`
    groupBtn.innerHTML = `
            <button onclick="saveNewNameGroup('${idGroup}')" class="btn btn-green"><i class="feather-save"></i> <span class="d-responsive-none">Enregistré</span></button>
            <button onclick="cancelEditGroup('${idGroup}','${nameGroup}')" class="btn btn-red"><i class="feather-x-circle"></i> <span class="d-responsive-none">Annulé</span></button>
        `
}
function cancelEditGroup(idGroup,nameGroup){
    const ligneTome = document.getElementById(idGroup)
    const groupBtn = document.getElementById('btn-action-'+idGroup)
    const idCollection = document.getElementById('idCollection').value
    ligneTome.innerHTML = nameGroup;
    groupBtn.innerHTML = `
            <button onclick="editGroup('${idGroup}','${nameGroup}')" class="btn btn-edit"><i class="feather-edit-2"></i> <span class="d-responsive-none">Editer</span></button>
            <a href="/gestion-super-collect/groupe/${idCollection}/supprimer/${idGroup}" onclick="return confirm('Vous voulez vraiment supprimer ce groupe?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
        `;
}
function saveNewNameGroup(idGroup){
    const newName = document.getElementById('input-group-'+idGroup).value
    const data = {
            group: newName,
            idGroup: idGroup,
        };
        const xhr = new XMLHttpRequest();
        xhr.open('POST','/gestion-super-collect/groupe/editer',true);
        xhr.setRequestHeader('Content-Type','application/json');
        xhr.onload = function(){
            if (xhr.status >= 200 && xhr.status < 300) {
                const idCollection = document.querySelector('#idCollection').value
                const ligneTome = document.getElementById(idGroup)
                const groupBtn = document.getElementById('btn-action-'+idGroup)
                ligneTome.innerHTML = newName;
                groupBtn.innerHTML = `
                        <button onclick="editGroup('${idGroup}','${newName}')" class="btn btn-edit"><i class="feather-edit"></i> <span class="d-responsive-none">Editer</span></button>
                        <a href="/gestion-super-collect/groupe/${idCollection}/supprimer/${idGroup}" onclick="return confirm('Vous voulez vraiment supprimer ce groupe?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
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
const btnAddGroup = document.querySelector('#addGroup')
if (btnAddGroup) {
    btnAddGroup.addEventListener('click', (e) => {
        const nameNewGroup = document.querySelector('#nameNewGroup').value
        const idCollection = document.querySelector('#idCollection').value
        const formGroup = document.querySelector('#formNewGroup')
        const data = {
                group: nameNewGroup,
                collection: idCollection
            };
            const xhr = new XMLHttpRequest();
            xhr.open('POST','/gestion-super-collect/groupe/ajout',true);
            xhr.setRequestHeader('Content-Type','application/json');
            xhr.onload = function(){
                if (xhr.status >= 200 && xhr.status < 300) {
                    const erreur = document.querySelector('#erreurAddGroup')
                    const inputNewGroup = document.querySelector('#nameNewGroup')
                    const jsonResponse = JSON.parse(xhr.responseText);
                    const idGroup = jsonResponse.idGroup;
                    erreur.innerHTML = ''
                    inputNewGroup.value = ''
                    let newLigne = `
                             <tr>
                                 <td class="text-capitalize" id="${idGroup}">${nameNewGroup}</td>
                                 <td class="justify-end d-flex" id="btn-action-${idGroup}">
                                     <button onclick="editGroup('${idGroup}','${nameNewGroup}')" class="btn btn-edit"><i class="feather-edit"></i> <span class="d-responsive-none">Editer</span></button>
                                     <a href="/gestion-super-collect/groupe/${idCollection}/supprimer/${idGroup}" onclick="return confirm('Vous voulez vraiment supprimer ce groupe?')" class="btn btn-red"><i class="feather-trash-2"></i> <span class="d-responsive-none">Supprimer</span></a>
                                 </td>
                             </tr>
                         `
                    formGroup.insertAdjacentHTML('beforebegin', newLigne)
                    const groupTome = document.querySelector('#groupTome')
                    const newTable = `
                    <h2 id="section-${idGroup}">${nameNewGroup}</h2>
                    <table>
                        <thead>
                            <tr>
                                <th class="fx-13">Nom</th>
                                <th class="fx-13 d-responsive-none">Ajouter le</th>
                                <th class="fx-13 d-responsive-none">Modifier le</th> 
                                <th class="fx-13" width="30%" id="theadAction">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="form-${idGroup}">
                                <td><input type="text" id="nameNewTome-${idGroup}"></td>
                                <td class="d-responsive-none" colspan="2"></td>
                                <td class="text-right"><button onclick="addTomeGroup('${idGroup}')" class="btn btn-green"><i class="feather-save"></i> Enregistré</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <p id="erreurAddTome-${idGroup}" class="text-red"></p>
                    `
                    groupTome.insertAdjacentHTML('beforeend',newTable)
                }else if (xhr.status === 400) {
                    const erreur = document.querySelector('#erreurAddGroup')
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