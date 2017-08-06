$(document).ready(function() {
    $('.quantidade_produto_shoppingcart').on('change', function() {
        idProduto = $(this).data('id');
        quantidadeProduto = $('#quantidade_' + idProduto).val();
        valorProduto      = $('#valor_' + idProduto).val();
        $labelTotalProdutoShoppingCart = $('#valor_total_produto_shoppingcart_' + idProduto);
        $labelTotalShoppingCart = $('#total_shoppingcart');

        valorAnterior = $labelTotalProdutoShoppingCart.text();

        valorShoppingCart = $labelTotalShoppingCart.text();
        /**calculo preço total do produto
         *
         * @type {number}
         */
        valorTotalProduto = quantidadeProduto * valorProduto;

        $labelTotalProdutoShoppingCart.text(valorTotalProduto);
        /**
         * calculo total carrinho de compras
         * @type {number}
         */
        valorTotalUpdate  = parseFloat(valorTotalProduto) - parseFloat(valorAnterior);
        totalShoppingCart = parseFloat(valorShoppingCart) + valorTotalUpdate;

        $labelTotalShoppingCart.text(totalShoppingCart);;
    });
});