let arr = {
    brand: false,
    type: false,
    size: false,
    price: false
};
openFilter = (id) => { //id = brand => size
    console.log(id);
    if (!arr[id]) { // brand:false => size:false
        let id_str = id + "_sub";
        document.getElementById(id_str).setAttribute("style", "display: flex;");
        arr[id] = true; // brand:true size:true
        for (let i in arr) {
            if (arr.hasOwnProperty(i)) {
                if (i !== id) {
                    let id_str = i + "_sub";
                    document.getElementById(id_str).setAttribute("style", "display: none;");
                    arr[i] = false;
                }
            }//{"brand":true, "type":false, "price":false, "size":false}
        }
    } else {
        let id_str = id + "_sub";
        document.getElementById(id_str).style.display = "none";
        arr[id] = false;

    }
};
var mymap = L.map('mapid').setView([51.505, -0.09], 13);
var CartoDB_DarkMatter = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);