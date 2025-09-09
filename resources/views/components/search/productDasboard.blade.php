<div class="topbar mt-3" >
    <form action="{{ route('products.search') }}" method="get" class="w-75">
      <input
      type="text"
      name="input"
      class="form-control"
      placeholder="Tìm kiếm..."
    />
    </form>

    {{-- Filter --}}
    <div>
      <button type="button" class="btn btn-outline-danger mx-2" id="filter" data-bs-toggle="modal" data-bs-target="#filterModal"><i class="fa-solid fa-filter" ></i> Filter</button>
    </div>
    <!-- Modal Filter -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="{{ route('products.search') }}" method="get">
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
                    disabled
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

    {{-- Hủy tìm kiếm --}}
    <div>
      <a href="{{ route('admin.products.dashboard') }}" class="btn btn-danger"><i class="fa-solid fa-xmark" style="white"></i></a>
    </div>
  </div>

{{-- SCRIPT --}}
<script>
    //hàm gọi giá trị Category
    document.getElementById('filter').addEventListener('click', function(){
        let categorySelect = document.getElementById('category');

        categorySelect.innerHTML = '<option value="">-- Chọn danh mục --</option>'; // reset
        categorySelect.disabled = true;

        fetch(`/find-all-categories/`)
            .then(res => res.json())
            .then(data => {
            data.forEach(category => {
                let option = document.createElement('option');
                option.value = category.CategoryID;
                option.textContent = category.CategoryName 
                categorySelect.appendChild(option);
            });
            categorySelect.disabled = false;
            })
            .catch(err => console.error(err));
    });


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
                        if('{{ old("brand") }}' == brand.BrandID) {
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