
jQuery(document).ready(function(){


    document.getElementById("add-img-input").addEventListener("click",addInput)

    document.getElementById("delete-img-input").addEventListener("click",removeLastInput)





    // Función para agregar inputs dinamicamente

    function addInput(e){

        button = document.getElementById("add-img-input");

        var count = button.value;

        document.getElementById("add-img-input").value = parseInt(count) + 1;

        var content= '<hr><div class="general-form-field image-row">' +
                        '<div><h2 class="filds-titles"> Image '+ count + '</h2>' +
            '<input type="file" name="image" value="" ></div>' + 

            '<div><h2 class="filds-titles"> Image Link '+ count + ' </h2>' +
            '<input type="url" name="image_link" ></div></div>'

        document.getElementById("images-container").append(stringToHTML(content))

        return false;
    }





    // Función para eliminar inputs dinamicamente

    function removeLastInput(){

        // Modifico el contador de campos
        inputCount = document.getElementById("add-img-input").value;
        document.getElementById("add-img-input").value = parseInt(inputCount) -1;


        // Elimino el último campo
        lastChild = document.getElementById("images-container").lastChild.remove()

        

    }



    // Func. Auxiliar para parsear string a HTML
    var stringToHTML = function (str) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };  


})
