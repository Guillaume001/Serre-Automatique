window.onload=function() {
        horloge('horloge');
};

function horloge(hr) {
        hr = document.getElementById(hr);
        function actualiser() {
                var date = new Date();
                var dateheure = date.toLocaleDateString();
                dateheure += " - ";
                dateheure += date.toLocaleTimeString();
                hr.innerHTML = dateheure;
        }
        actualiser();
        setInterval(actualiser,1000);
}