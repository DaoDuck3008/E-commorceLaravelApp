<!-- Sidebar ở bên trái -->
<div class="sidebar-container col-2 border rounded px-2 position-relative">
  <ul id="categoryList" class="list-unstyled">
  </ul>


  <!-- Container hiển thị brand -->
  <div id="megaMenuContainer" 
    class="position-absolute bg-white border rounded shadow p-3" 
    style="top:0; left:100%; width: 800px; height: 400px; display:none; z-index:1050;">
    <div class="d-flex gap-3">
        <div class="mx-5">
            <h5>Các thương hiệu</h5>
            <div id="brandContainer">   
            </div>
        </div>
        <div class="mx-5">
            <h5>Phân khúc giá</h5>
            <div class="d-flex flex-column">
                <a class="btn text-start price-link" data-query="price_min=0&price_max=2000000" href="#">Dưới 2 triệu</a>
                <a class="btn text-start price-link" data-query="price_min=2000000&price_max=4000000" href="#">Từ 2 đến 4 triệu</a>
                <a class="btn text-start price-link" data-query="price_min=4000000&price_max=8000000" href="#">Từ 4 đến 8 triệu</a>
                <a class="btn text-start price-link" data-query="price_min=8000000&price_max=14000000" href="#">Từ 8 đến 14 triệu</a>
                <a class="btn text-start price-link" data-query="price_min=14000000&price_max=20000000" href="#">Từ 14 đến 20 triệu</a>
                <a class="btn text-start price-link" data-query="price_min=20000000&price_max=30000000" href="#">Từ 20 đến 30 triệu</a>
                <a class="btn text-start price-link" data-query="price_min=30000000&price_max=100000000" href="#">Trên 30 triệu</a>
            </div>
        </div>
        
        <div class="mx-5">
            <h5>Sắp xếp theo</h5>
            <div class="d-flex flex-column">
                <a class="btn text-start sort-link" data-query="sort=oldest" href="#">Cũ nhất</a>
                <a class="btn text-start sort-link" data-query="sort=newest" href="#">Mới nhất</a>
                <a class="btn text-start sort-link" data-query="sort=high-to-low" href="#">Giá tăng dần</a>
                <a class="btn text-start sort-link" data-query="sort=low-to-high" href="#">Giá giảm dần</a>
            </div>
        </div>
    </div>
  </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const megaMenuContainer = document.querySelector("#megaMenuContainer");
        const brandContainer = document.querySelector("#brandContainer");
        const searchUrl = "{{ route('products.searchCustomer') }}";
        const sidebarContainer = document.querySelector(".sidebar-container");
        
        // Sử dụng event delegation
        sidebarContainer.addEventListener("click", function(e) {
            const sidebarItem = e.target.closest('.sidebar-items');
            if (!sidebarItem) return;
            
            let categoryId = sidebarItem.getAttribute("data-id");
            
            // Nếu đang mở cùng category thì ẩn đi
            if (brandContainer.dataset.openId === categoryId && megaMenuContainer.style.display === "block") {
                megaMenuContainer.style.display = "none";
                return;
            }
            
            fetch(`/brands-by-category/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    let html = "<ul class='list-unstyled mb-0 d-flex flex-column text-start'>";
                    data.forEach(brand => {
                        html += `<a class="py-1 btn text-start" 
                        href="{{ route('products.searchCustomer')}}?brand=${brand.BrandID}&category=${categoryId}">${brand.BrandName}</a>`;
                    });
                    html += "</ul>";
                    
                    brandContainer.innerHTML = html;
                    megaMenuContainer.style.display = "block";
                    brandContainer.dataset.openId = categoryId;
                    
                    // Gắn categoryId vào các link price & sort
                    document.querySelectorAll(".price-link, .sort-link").forEach(link => {
                        let query = link.dataset.query;
                        link.href = `${searchUrl}?${query}&category=${categoryId}`;
                    });
                })
                .catch(err => console.error(err));
        }, true); // Use capture phase
        
        // Gọi categories
        fetch('/find-all-categories')
            .then(res => res.json())
            .then(categories => {
                let container = document.getElementById("categoryList");
                container.innerHTML = ""; // clear cũ
                
                categories.forEach(category => {
                    container.innerHTML += `
                        <li class="d-flex justify-content-between mb-2" role="button">
                            <a class="btn" style="font-weight:600"
                            href="/products/search?category=${category.CategoryID}">
                                <div>
                                    <i class="fa-icon fa-solid fa-${category.Icon} me-2"></i>${category.CategoryName}
                                </div>
                            </a>
                            <a class=" btn" style="font-weight:600" >
                                <span class="my-2 sidebar-items right" data-id="${category.CategoryID}">
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </a>
                        </li>
                    `;
                });
            })
            .catch(err => console.error("Lỗi load categories:", err));
        
        // Ẩn khi rời khỏi sidebar
        sidebarContainer.addEventListener("mouseleave", function () {
            megaMenuContainer.style.display = "none";
        });
    });
</script>