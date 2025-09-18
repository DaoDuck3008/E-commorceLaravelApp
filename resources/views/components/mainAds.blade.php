{{-- Quảng cáo ở chính giữa --}}
<div class="ad3-container col-10 col-lg-8 border rounded">
    <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
        {{-- Phần tử này sẽ được lấp đầy bằng JS --}}
        <div id="carousel-inner" class="carousel-inner">
        </div>

        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#promoCarousel"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#promoCarousel"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- Phần tử này sẽ được lấp đầy bằng JS --}}
    <ul
        id="nav-tabs-list"
        class="nav nav-tabs mt-2 border-0 mb-2 gap-2 d-flex flex-nowrap overflow-x-auto overflow-y-hidden"
    >
        </ul>
</div>

<script>
    // Lấy phần tử HTML cần chèn nội dung
    const carouselInner = document.getElementById('carousel-inner');
    const navTabsList = document.getElementById('nav-tabs-list');

    // Gọi API để lấy dữ liệu promotions
    fetch('/api/promotions') 
        .then(response => response.json())
        .then(promotions => {
            // Lặp qua dữ liệu và tạo HTML
            console.log(promotions);
            promotions.forEach((promotion, index) => {
                // Tạo carousel item
                const carouselItem = `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img
                            src="${promotion.ImgURL}"
                            class="d-block w-100 rounded shadow"
                            alt="${promotion.Title}"
                        />
                    </div>
                `;
                carouselInner.insertAdjacentHTML('beforeend', carouselItem);

                // Tạo nav tab item
                const navTabItem = `
                    <li class="nav-item">
                        <a
                            class="nav-link ${index === 0 ? 'active' : ''} fw-bold"
                            style="width: 180px; color: black"
                            data-bs-target="#promoCarousel"
                            data-bs-slide-to="${index}"
                        >
                            ${promotion.Title}<br /><small class="text-muted">
                                ${promotion.Description}
                            </small>
                        </a>
                    </li>
                `;
                navTabsList.insertAdjacentHTML('beforeend', navTabItem);
            });
        })
        .catch(error => console.error('Error fetching promotions:', error));
</script>