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
let controller=false;
openDetails=()=>{

    if(controller===false){
        controller = true;
        document.getElementById("opendetails").style.height="auto";
    }
    else{
        controller = false;
        document.getElementById("opendetails").style.height="0";
    }
};

let mymap = L.map('mapid').setView([48.9469267, 20.5665167], 20);

let CartoDB_DarkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 19,
    minZoom: 5,
    center: [48.9469267, 20.5665167],
    zoom: 1
}).addTo(mymap);

let marker = L.marker([48.9469267, 20.5665167]
).addTo(mymap);
marker.bindPopup("Hello it's me!").openPopup();