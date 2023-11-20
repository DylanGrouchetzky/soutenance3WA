function addTome(tome,collection,category,idButton){
    const data = {
        tome: tome,
        collection: collection,
        category: category,
    };
    const xhr = new XMLHttpRequest();
    xhr.open('POST','/ajout-tome/utilisateur',true);
    xhr.setRequestHeader('Content-Type','application/json');
    xhr.onload = function(){
        if (xhr.status >= 200 && xhr.status < 300) {
            let button = document.getElementById(idButton)
            let numberTomeUserHTML = document.getElementById('numberTomeUser')
            let containerInfoCollection = document.getElementById('container-info-collection')
            const jsonResponse = JSON.parse(xhr.responseText);
            const numberTomeUser = jsonResponse.numberTomeUser;
            const numberTomeColection = jsonResponse.numberTomeColection;
            const actionValue = jsonResponse.action;
            if (numberTomeUser > 1) {
                textTomeUserHtml = 'Tomes possédés';
            }else{
                textTomeUserHtml = 'Tome possédé'
            }
            numberTomeUserHTML.innerHTML = `${numberTomeUser} ${textTomeUserHtml}`;
            if (numberTomeUser == 0) {
                containerInfoCollection.classList.remove('border-collection-complet')
                containerInfoCollection.classList.remove('border-collection-wait')
                containerInfoCollection.classList.add('border-collection-none')
            }else{
                if (numberTomeUser == numberTomeColection) {
                    containerInfoCollection.classList.remove('border-collection-wait')
                    containerInfoCollection.classList.remove('border-collection-none')
                    containerInfoCollection.classList.add('border-collection-complet')
                }else{
                    containerInfoCollection.classList.remove('border-collection-none')
                    containerInfoCollection.classList.remove('border-collection-complet')
                    containerInfoCollection.classList.add('border-collection-wait')
                }
            }
            if (actionValue == 'add') {
                button.innerHTML = '<i class="feather-minus-circle"></i> Enlever';
                button.classList.remove('btn-green');
                button.classList.add('btn-red');
            }
            if (actionValue == 'remove') {
                button.innerHTML = '<i class="feather-plus-circle"></i> Ajouter';
                button.classList.remove('btn-red');
                button.classList.add('btn-green');
            }
        }else{
            console.log(xhr.status);
        }
    };
    xhr.send(JSON.stringify(data));
}