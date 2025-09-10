@extends('layouts.app')

@section('content')
    <div style="height:100vh">
        {{-- Bộ lọc --}}
        <div class="container my-3">

            <!-- Chọn theo tiêu chí -->
            <h6 class="mb-2 fw-bold">Chọn theo tiêu chí</h6>
            <div class="d-flex flex-wrap gap-2 mb-3">
        
                <!-- Bộ lọc -->
                <button class="btn btn-outline-danger" id="filter" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa-solid fa-filter me-1"></i> Bộ lọc
                </button>


                <!-- Modal Filter -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('products.searchCustomer') }}" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel"><i class="fa-solid fa-sliders"></i> Bộ lọc sản phẩm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                        <div class="modal-body">
                            <div class="row g-3">
            
                            {{-- Category --}}
                            <div class="col-md-6">
                                <label for="category" class="form-label">Danh mục</label>
                                <select name="category" id="category" class="form-select">
                                <option value="">-- Chọn danh mục --</option>
                                </select>
                            </div>
            
                            {{-- Brand --}}
                            <div class="col-md-6">
                                <label class="form-label">Thương hiệu</label>
                                <select
                                class="form-select"
                                name="brand"
                                id="brand"
                                > 
                                <option value="">-- Chọn thương hiệu --</option>
                                </select>
                            </div>
            
                            {{-- Price Range --}}
                            <div class="col-md-6">
                                <label class="form-label">Khoảng giá (VNĐ)</label>
                                <div class="input-group">
                                <input type="number" name="min_price" class="form-control" placeholder="Từ" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control" placeholder="Đến" value="{{ request('max_price') }}">
                                </div>
                            </div>
            
                            {{-- Sort --}}
                            <div class="col-md-6">
                                <label for="sort_by" class="form-label">Sắp xếp theo</label>
                                <select name="sort_by" id="sort_by" class="form-select">
                                <option value="">-- Mặc định --</option>
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                </select>
                            </div>
            
                            </div>
                        </div>
            
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-check"></i> Apply</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        
            <!-- Sắp xếp theo -->
            <h6 class="mb-2 fw-bold">Sắp xếp theo</h6>
            <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-outline-primary active">
                <i class="fa-solid fa-star me-1"></i> Phổ biến
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-bolt me-1"></i> Mới nhất
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-bolt me-1"></i> Cũ nhất
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-up-wide-short me-1"></i> Giá Thấp - Cao
            </button>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-down-wide-short me-1"></i> Giá Cao - Thấp
            </button>
            </div>
        </div>
        

        <!-- Các sản phẩm -->
        <div
        class="d-flex flex-wrap mt-3  justify-content-left"
        >
            @foreach ( $products as $product )
            <a
                class="card p-3 rounded shadow position-relative mx-2 mt-3 btn"
                href="/products/{{ $product->ProductID }}"
                style="
                background: linear-gradient(180deg, #fff, #ffeceb);
                width: 220px;
                min-width: 220px;
                "
            >
                <span class="badge bg-danger position-absolute top-0 start-0 m-2"
                >Giảm 3%</span
                >

                <img
                src="{{ $product->ImageURL }}"
                class="card-img-top mt-4"
                alt="CPU AMD Ryzen 5 5600"
                />

                <div class="card-body p-0 mt-2">
                <h6 class="card-title mb-2">
                    {{ $product->ProductName }}
                </h6>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="text-danger fw-bold fs-6">{{ $product->Price }}đ</span>
                    <small class="text-muted text-decoration-line-through"
                    >34.990.000đ</small
                    >
                </div>
                <div class="bg-light text-secondary small px-2 py-1 rounded mt-1">
                    Giá S-Student 3.705.000đ
                </div>
                <div class="d-flex flex-row-reverse mt-2">
                    <btn class="btn btn-primary">♡ Yêu thích</btn>
                </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    


    <script>
        //Lấy giá trị brand và category được truyền trên route
        const categoryIDInRoute = "{{ request('category') }}";
        const brandIDInRoute = "{{ request('brand') }}";

        //Hàm gọi category 
        let categorySelect  = document.getElementById('category');
        fetch(`/find-all-categories`)
            .then(response => response.json())
            .then(data => {
                data.forEach(category => {
                    let option = document.createElement('option');
                    option.value = category.CategoryID;
                    option.textContent = category.CategoryName;
                    //Kiểm tra nếu category được chọn trước đó
                    if(categoryIDInRoute == category.CategoryID){
                        option.selected = true;
                    } 

                    categorySelect.appendChild(option);
                })
            })
            .catch(err => console.error(err));


        //Hàm gọi giá trị Brand theo Category
        document.getElementById('category').addEventListener('change', function() {
            let categoryId = this.value;
            let brandSelect = document.getElementById('brand');

            brandSelect.innerHTML = '<option value="">-- Chọn thương hiệu --</option>'; // reset
            brandSelect.disabled = true;

            if(categoryId) {
                fetch(`/admin/brands-by-category/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(brand => {
                            let option = document.createElement('option');
                            option.value = brand.BrandID;
                            option.textContent = brand.BrandName;
                            // Kiểm tra nếu brand được chọn trước đó
                            if(brandIDInRoute == brand.BrandID) {
                                option.selected = true;
                            }
                            brandSelect.appendChild(option);
                        });
                        brandSelect.disabled = false;
                    })
                    .catch(err => console.error(err));
            }
        });
    </script>

@endsection