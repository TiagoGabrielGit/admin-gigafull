// Inicializando o mapa com Leaflet
var map = L.map('map').setView([-23.55052, -46.6333], 10); // Coordenadas iniciais e zoom

// Adicionando um tile layer (camada de mapa)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Variável para armazenar os marcadores no mapa
let markers = [];

// Função para limpar os marcadores do mapa
function clearMarkers() {
    markers.forEach(marker => {
        map.removeLayer(marker);
    });
    markers = [];
}

// Função para obter os valores selecionados de um select múltiplo
function getSelectedValues(select) {
    let result = [];
    let options = select && select.options;
    for (let i = 0, len = options.length; i < len; i++) {
        let option = options[i];
        if (option.selected) {
            result.push(option.value);
        }
    }
    return result;
}

// Carregar PONs com base nas OLTs selecionadas
document.getElementById('olt-select').addEventListener('change', function() {
    let oltIds = getSelectedValues(this); // Pega múltiplos valores
    fetch('load_pons.php', {
        method: 'POST',
        body: new URLSearchParams({ 'olt_ids': oltIds })
    })
    .then(response => response.json())
    .then(pons => {
        let ponSelect = document.getElementById('pon-select');
        ponSelect.innerHTML = ''; // Limpa as opções antigas
        pons.forEach(pon => {
            let option = document.createElement('option');
            option.value = pon.id;
            option.textContent = `Slot: ${pon.slot}, PON: ${pon.pon}`;
            ponSelect.appendChild(option);
        });
    });
});

// Carregar CTOs com base nas PONs selecionadas
document.getElementById('pon-select').addEventListener('change', function() {
    let ponIds = getSelectedValues(this); // Pega múltiplos valores
    fetch('load_ctos.php', {
        method: 'POST',
        body: new URLSearchParams({ 'pon_ids': ponIds })
    })
    .then(response => response.json())
    .then(ctos => {
        let ctoSelect = document.getElementById('cto-select');
        ctoSelect.innerHTML = ''; // Limpa as opções antigas
        ctos.forEach(cto => {
            let option = document.createElement('option');
            option.value = cto.id;
            option.textContent = `${cto.title}`;
            ctoSelect.appendChild(option);
        });
    });
});

// Exibir as CTOs selecionadas no mapa quando o botão "Mostrar no Mapa" for clicado
document.getElementById('show-map-btn').addEventListener('click', function() {
    let ctoIds = getSelectedValues(document.getElementById('cto-select')); // Pega os IDs das CTOs selecionadas
    
    if (ctoIds.length === 0) {
        alert("Por favor, selecione ao menos uma CTO para mostrar no mapa.");
        return;
    }

    // Carrega as coordenadas das CTOs selecionadas
    fetch('load_cto_coordinates.php', {
        method: 'POST',
        body: new URLSearchParams({ 'cto_ids': ctoIds })
    })
    .then(response => response.json())
    .then(ctos => {
        // Limpa os marcadores anteriores do mapa
        clearMarkers();

        // Adiciona novos marcadores com base nas coordenadas das CTOs selecionadas
        ctos.forEach(cto => {
            let marker = L.marker([cto.latitude, cto.longitude]).addTo(map)
                .bindPopup(`<b>${cto.title}</b><br>Latitude: ${cto.latitude}<br>Longitude: ${cto.longitude}`);
            markers.push(marker); // Armazena o marcador na lista
        });

        // Centraliza o mapa na primeira CTO (se houver pelo menos uma)
        if (ctos.length > 0) {
            map.setView([ctos[0].latitude, ctos[0].longitude], 12); // Centraliza no primeiro ponto
        }
    });
});
