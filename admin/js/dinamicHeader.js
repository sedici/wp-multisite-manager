
jQuery(document).ready(function(){

    document.getElementById("add-img-input").addEventListener("click",addInput)

    var stringToHTML = function (str) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };  

    function addInput(e){

        button = document.getElementById("add-img-input");

        var count = button.value;

        document.getElementById("add-img-input").value = parseInt(count) + 1;

        var content= '<hr><div class="general-form-field">' +
                        '<h2 class="filds-titles"> Image '+ count + '</h2>' +
            '<input type="file" name="image" value="" >' + 

            '<h2 class="filds-titles"> Image Link '+ count + ' </h2>' +
            '<input type="url" name="image_link" ></div>'
        
            var el = document.createElement("div");
            el.appendChild(document.createTextNode("Put yout HTML"));


        document.getElementById("images-container").append(stringToHTML(content))


        return false;
    }

})
