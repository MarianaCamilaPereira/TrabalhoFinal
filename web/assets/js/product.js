function getURLParams() {
    const url = window.location.href;
    const params = {};
    const queryString = url.split('?')[1];

    if (queryString) {
        const keyValuePairs = queryString.split('&');

        keyValuePairs.forEach(pair => {
            const [key, value] = pair.split('=');
            params[key] = value;
        });
    }

    return params;
}

const queryParams = getURLParams();

$(document).ready(function () {
    $.ajax({
        url: 'http://localhost/trabalho/server/produtos.php',
        method: 'GET',
        data: { id: queryParams.id },
        success: function (product) {
            var productName = $('#product-name');
            var productDescription = $('#product-description');
            var productPrice = $('#product-price');
            var productImage = $('#image-container');

            var imageComponent = `
                <img src="http://localhost/trabalho/web/public/imagens/${product.imagem}" alt="Product image"
                    class="img-fluid product-image">
            `

            productName.text(product.nome);
            productDescription.text(product.descricao);
            productPrice.text("R$ " + product.valor);
            productImage.append(imageComponent);
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição:', status, error);
            window.location.href = '404.html'
        }
    });
})

$('#search-button').click(function () {
    var searchVal = $('#search-input').val()

    window.location.href = 'search.html?search=' + encodeURIComponent(searchVal);
});
