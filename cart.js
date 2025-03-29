function addToCart(event, form) {
    event.preventDefault();
    const formData = new FormData(form);
    formData.append('ajax_add_to_cart', true);

    // Lấy giá trị của size
    const size = form.querySelector('select[name="size"]').value;
    formData.append('size', size);

    fetch('include/giohang.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(cartCount => {
        updateCartCount(cartCount);
        alert(`Sản phẩm đã được thêm vào giỏ hàng! (Size: ${size})`);
    })
    .catch(error => console.error('Error:', error));
}
