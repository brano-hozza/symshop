let arr = {
    brand: false,
    type: false,
    size: false,
    price: false
};
openFilter = (id) => { //id = brand => size
    if (!arr[id]) { // brand:false => size:false
        let id_str = id + "_sub";
        document.getElementById(id_str).style.display = "flex";
        arr[id] = true; // brand:true size:true
        for (let i in arr) {
            if (arr.hasOwnProperty(i)) {
                if (i !== id) {
                    let id_str = i + "_sub";
                    document.getElementById(id_str).style.display = "none";
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