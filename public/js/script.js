let arr = {
    brand: false,
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
            }
        }
    } else {
        let id_str = id + "_sub";
        document.getElementById(id_str).style.display = "none";
        arr[id] = false;

    }
};

$(document).ready(function () {
    $("#searchbar").on("keyup", function () {
        var value = $(this).val();
        $("#hidden_phrase").val(value);
        $.post(
            '/blog',
            {
                data: value
            },
            function (data, status) {
                console.log(status);
                $("#blogs").html("");
                for (let row in data) {
                    if (data.hasOwnProperty(row)) {
                        $("#blogs").append(data[row]);
                    }
                }
                console.log(data.length);
                if (data.length < 20) {
                    $("#next").css("visibility", "hidden")
                } else {
                    $("#next").css("visibility", "visible")

                }
            },
        );
    });
});
let coll = document.getElementsByClassName("order-item-phone");
let i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
        let content = this.nextElementSibling;
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = "15rem";
        }
    })
}



openPopup = () => {
    let content = document.getElementById("popup");
    if (content.style.height) {
        content.style.height = null;
        content.style.padding = null;
    } else {
        content.style.height = "auto";
        content.style.padding = "2rem";
    }
};


productPopup = () => {
    let content = document.getElementById("productPopup");
    let element = document.getElementById('title');
    if (content.style.height) {
        content.style.height = null;
        element.classList.remove("shake");
    } else {
        content.style.height = "auto";
        element.classList.add("shake");
    }
};

popupClose = () => {
    let content = document.getElementById("productPopup");
    content.style.height = null;
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
