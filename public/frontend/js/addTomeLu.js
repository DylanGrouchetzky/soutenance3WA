function addTomeLu(tome,collection,category,idButton){
    const data = {
        tome: tome,
        collection: collection,
        category: category,
    };
    const xhr = new XMLHttpRequest();
    xhr.open('POST','/ajout-tome-lu/utilisateur',true);
    xhr.setRequestHeader('Content-Type','application/json');
    xhr.onload = function(){
        if (xhr.status >= 200 && xhr.status < 300) {
            let button = document.getElementById(`lu-${idButton}`)
            let numberTomeUserReadHTML = document.getElementById('numberTomeUserRead')
            let containerInfoCollectionRead = document.getElementById('container-info-collection-read')
            const jsonResponse = JSON.parse(xhr.responseText);
            const numberTomeUserRead = jsonResponse.numberTomeUserRead;
            const numberTomeColection = jsonResponse.numberTomeColection;
            const actionValue = jsonResponse.action;
            let textTomeUserReadHtml = "";
            if (numberTomeUserRead > 1) {
                textTomeUserReadHtml = 'Tomes lus';
            }else{
                textTomeUserReadHtml = 'Tome lu';
            }
            numberTomeUserReadHTML.innerHTML = `${numberTomeUserRead} ${textTomeUserReadHtml}`;
            if (numberTomeUserRead == 0) {
                containerInfoCollectionRead.classList.remove('border-collection-complet')
                containerInfoCollectionRead.classList.remove('border-collection-wait')
                containerInfoCollectionRead.classList.add('border-collection-none')
            }else{
                if (numberTomeUserRead == numberTomeColection) {
                    containerInfoCollectionRead.classList.remove('border-collection-wait')
                    containerInfoCollectionRead.classList.remove('border-collection-none')
                    containerInfoCollectionRead.classList.add('border-collection-complet')
                }else{
                    containerInfoCollectionRead.classList.remove('border-collection-none')
                    containerInfoCollectionRead.classList.remove('border-collection-complet')
                    containerInfoCollectionRead.classList.add('border-collection-wait')
                }
            }
            if (actionValue == 'add') {
                button.innerHTML = '<i class="feather-check-circle"></i> Lu';
                button.classList.remove('btn-gray');
                button.classList.add('btn-green');
            }
            if (actionValue == 'remove') {
                button.innerHTML = '<i class="feather-check-circle"></i> A Lire';
                button.classList.remove('btn-green');
                button.classList.add('btn-gray');
            }
        }else{
            console.log(xhr.status);
        }
    };
    xhr.send(JSON.stringify(data));
}