document.addEventListener('DOMContentLoaded', function () {
    const lieuSelect = document.querySelector('.lieu-select');
    const rue = document.querySelector('[name="sortie_form[lieu_rue]"]');
    const ville = document.querySelector('[name="sortie_form[lieu_ville]"]');
    const cp = document.querySelector('[name="sortie_form[lieu_cp]"]');
    const latitude = document.querySelector('[name="sortie_form[lieu_latitude]"]');
    const longitude = document.querySelector('[name="sortie_form[lieu_longitude]"]');


    lieuSelect.addEventListener('change', function () {
        const lieuId = this.value;
        if (lieuId) {
            fetch(`/sorties/lieu/${lieuId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(rue)
                    rue.value = data?.rue || '';
                    ville.value = data.ville || '';
                    cp.value = data.cp || '';
                    latitude.value = data.latitude || '';
                    longitude.value = data.longitude || '';
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des données du lieu :', error);
                });
        } else {
            rue.value = ""
            ville.value = ""
            cp.value = ""
            latitude.value = ""
            longitude.value = ""
        }
    });
});