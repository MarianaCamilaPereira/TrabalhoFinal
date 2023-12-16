$.ajax({
    url: 'http://localhost/trabalho/server/produtos.php',
    method: 'GET',
    success: function (products) {
        products.forEach(function (product) {
            var shopItems = $('.shop-items');

            var item = `
                <div class="col-12 col-md-4">
                    <div class="card rounded oveflow-hidden my-2">
                        <img src="http://localhost/trabalho/web/public/imagens/${product.imagem}" alt="imagem" class="product-image">
                        <div class="card-content d-flex flex-column gap-2 p-3">
                            <span class="item-title">
                                <a href="product.html?id=${product.id}">
                                    ${product.nome.length > 15 ?
                    `<span title="${product.nome}">${product.nome.substring(0, 15)}...</span>` :
                    product.nome
                }
                                </a>
                            </span>
                            <span class="item-price">
                                R$ ${product.valor}
                            </span>
                            <span class="item-text">
                                ${product.descricao.length > 80 ?
                    `<span title="${product.descricao}">${product.descricao.substring(0, 80)}...</span>` :
                    product.descricao
                }
                            </span>
                        </div>
                    </div>
                </div>
            `

            shopItems.append(item);
        });
    },
    error: function (xhr, status, error) {
        console.error('Erro na requisição:', status, error);
    }
});

$.ajax({
    url: 'http://localhost/trabalho/server/categorias.php',
    method: 'GET',
    success: function (categories) {
        categories.forEach(function (category) {
            var categoriesList = $('.lista-categorias');

            var item = `
                <a href="search.html?category=${category.nome}">
                    <li class="categorias d-block p-3">
                        ${category.nome}
                    </li>
                </a>
            `

            categoriesList.append(item);
        });
    },
    error: function (xhr, status, error) {
        console.error('Erro na requisição:', status, error);
    }
});

$('#search-button').click(function () {
    var searchVal = $('#search-input').val()

    window.location.href = 'search.html?search=' + encodeURIComponent(searchVal);
});
