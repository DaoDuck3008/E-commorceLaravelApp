<!-- Gợi ý sản phẩm -->
<div class="recommend-section mt-3">
    <h4>Gợi ý cho bạn</h4>
    <div
        id="random-product-container"
        class="d-flex flex-nowrap overflow-auto justify-content-left justify-content-xl-center mt-3"
    >
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        const container = document.getElementById('random-product-container');

        fetch('/get-random-products')
            .then(res => res.json())
            .then(products => {
                products.forEach(product => {
                    let html = `<a
                    class="card p-3 rounded shadow position-relative mx-2"
                    style="
                        background: linear-gradient(180deg, #fff, #ffeceb);
                        width: 220px;
                        min-width: 220px;
                        text-decoration: none;
                    "
                        >
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2"
                            >Giảm 3%</span
                        >

                        <img
                            src="${product.ImageURL}"
                            class="card-img-top mt-4"
                            alt="${product.ProductName}"
                        />

                        <div class="card-body p-0 mt-2">
                            <h6 class="card-title mb-2">${product.ProductName}</h6>
                            <div class="d-flex align-items-baseline gap-2">
                            <span class="text-danger fw-bold fs-6">${formatCurrency(product.Price)}</span>
                            <small class="text-muted text-decoration-line-through"
                                >${formatCurrency(product.Price + 1000000)}</small
                            >
                            </div>
                            <div class="bg-light text-secondary small px-2 py-1 rounded mt-1">
                            Giá S-Student ${formatCurrency(product.Price - 2000000)}
                            </div>
                            <div class="d-flex flex-row-reverse mt-2">
                            <button class="btn btn-primary">♡ Yêu thích</button>
                            </div>
                        </div>
                    </a>`;

                    container.innerHTML += html;
                })
            }).catch(err => console.error(err));
    });
    
    
    // Hàm định dạng tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { 
            style: 'currency', 
            currency: 'VND' 
        }).format(amount);
    }
</script>