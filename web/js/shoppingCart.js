$(document).ready(function() {
    $('.quantidade_produto_shoppingcart').on('change', function() {
        idProduto = $(this).data('id');
        quantidadeProduto = $('#quantidade_' + idProduto).val();
        valorProduto      = $('#valor_' + idProduto).val();
        $labelValorFrete        = $('#valor_frete_' + idProduto);
        valorFrete = $labelValorFrete.text();
        $labelTotalProdutoShoppingCart = $('#valor_total_produto_shoppingcart_' + idProduto);
        $labelValorTotalComFrete = $('#valor_total_frete_' + idProduto);
        $labelTotalShoppingCart = $('#total_shoppingcart');

        valorAnterior = $labelValorTotalComFrete.text();

        valorShoppingCart = $labelTotalShoppingCart.text();
        /**calculo preço total do produto
         *
         * @type {number}
         */
        valorTotalProduto = (quantidadeProduto * valorProduto);
        novoValorFrete = (quantidadeProduto * valorFrete);
        valorTotalComFrete = valorTotalProduto + novoValorFrete;

        $labelValorFrete.text(novoValorFrete);
        $labelValorTotalComFrete.text(valorTotalComFrete);

        $labelTotalProdutoShoppingCart.text(valorTotalProduto);
        /**
         * calculo total carrinho de compras
         * @type {number}
         */
        valorTotalUpdate  = parseFloat(valorTotalComFrete) - parseFloat(valorAnterior);
        totalShoppingCart = parseFloat(valorShoppingCart) + valorTotalUpdate;

        $labelTotalShoppingCart.text(totalShoppingCart);;
    });
});