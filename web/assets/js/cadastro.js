$('#cadastrar-produto').click(function () {
    var form = new FormData();
    form.append('nome', $("#nome_produto").val());
    form.append('descricao', $("#descricao_produto").val());
    form.append('imagem', $("#imagem_produto").prop('files')[0]);
    form.append('valor', $("#valor_produto").val());
    form.append('categoria', $("#categoria_produto").val());

    let error = verificarForm(form);
    if (error) {
        alert("Favor preencher todos os dados")
    } else {
        $.ajax({
            type: "POST",
            url:'http://localhost/trabalho/server/produtos.php',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            success: function () {
               window.location.href = 'index.html'
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Erro ao salvar novo produto")
            },
        });
    }
});

$('#search-button').click(function () {
    var searchVal = $('#search-input').val()

    window.location.href = 'search.html?search=' + encodeURIComponent(searchVal);
});

function verificarForm(form) {
    for (var value of form.values()) {
        if (value == undefined || value == '' || value == 'null' || value == 'undefined') {
            return true;
        }
    }
    return false;
}
