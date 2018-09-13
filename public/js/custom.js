function adicionarLinha(e){
    var tbody=document.getElementById('tableBody');
    var tr = document.createElement('tr');
    
    var td = document.createElement('td');
    td.setAttribute("hidden","hidden");
    var input = document.createElement('input');
    setAttributes(input,{
        "hidden":"hidden",
        "type":"text",
        "class":"form-control",
        "name":"telefones[idTelefone][]"
    });
    td.appendChild(input);
    tr.appendChild(td);
    
    var td = document.createElement('td');
    var input = document.createElement('input');
    setAttributes(input,{
        "type":"text",
        "class":"form-control",
        "name":"telefones[numero][]",
        "placeholder":"(99)9 9999-9999"
    });
    td.appendChild(input);
    tr.appendChild(td);

    var td = document.createElement('td');
    var button = document.createElement('button');
    setAttributes(button,{
        "type":"button",
        "class":"btn col-12",
        "onclick":"excluirLinha(event)"
    });
    button.textContent = "Excluir";
    td.appendChild(button);
    tr.appendChild(td);


    tbody.appendChild(tr);
    

}

function excluirLinha(e){
    if(e.target.parentElement.parentElement.hasChildNodes()){
        var tel = document.getElementById('telefonesExcluir');
        tel.setAttribute('value',tel.value +";"+ e.target.parentElement.parentElement.children[0].children[0].value);
    }
    e.target.parentNode.parentNode.parentNode.removeChild(e.target.parentNode.parentNode);
}

function setAttributes(element, attributes){
    for(var attribute in attributes){
        element.setAttribute(attribute,attributes[attribute]);
    }
}