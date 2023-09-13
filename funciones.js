function formatoMonedaGTQ(numero) {
    return new Intl.NumberFormat('es-GT', { style: 'currency', currency: 'GTQ' }).format(numero);
}
