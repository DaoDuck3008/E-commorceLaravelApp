@extends('admin.app')

@section('content')
  <div class="container my-5">
    <div class="rounded shadow border p-5">
      <div class="text-end mt-1">
        <button class="btn btn-primary" onclick="cancelUpdate()">hủy</button>
      </div>
      <h3 class="mb-4 text-danger">Thêm sản phẩm mới</h3>
      <form action="{{route('products.update', $product->ProductID)}}" method="post"  enctype="multipart/form-data">
      @csrf
      @method('PUT')
        <!-- Tên sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Tên sản phẩm</label>
          <input
            type="text"
            class="form-control"
            value="{{ $product->ProductName }}"
            name="name"
            required
          />
        </div>

        <!-- Chọn loại sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Loại sản phẩm</label>
          <select id="category" class="form-select" name="category" required>
            <option value="" selected>-- Chọn danh mục sản phẩm --</option>
            @foreach ($categories as $category )
            <option value="{{ $category->CategoryID }}" {{ $product->category->CategoryID == $category->CategoryID ? "selected": "" }}>{{ $category->CategoryName }}</option>
            @endforeach
          </select>
        </div>

        <!-- Thương hiệu -->
        <div class="mb-3">
          <label class="form-label">Thương hiệu</label>
          <select
            class="form-select"
            name="brand"
            id="brand"
            required
          > 
          <option value="{{ $product->brand->BrandID }}" selected>{{ $product->brand->BrandName }}</option>
        </select>
        </div>

        <!-- Giá -->
        <div class="mb-3">
          <label class="form-label">Giá</label>
          <input
            type="number"
            class="form-control"
            value="{{ $product->Price }}"
            name="price"
            required
          />
        </div>


        <!-- Phiên bản sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Phiên bản sản phẩm</label>
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 30%">Tên phiên bản</th>
                <th>Giá phiên bản</th>
                <th style="width: 20%">Thao tác</th>
              </tr>
            </thead>
            <tbody id="version-table">
            @foreach ($product->productVersions as $index => $version )
                <tr id="verion-row-{{ $index }}">
                    <td>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $version->VersionName }}"
                        name="version[{{ $index }}][name]"
                        required
                    />
                    </td>
                    <td>
                    <input
                        type="number"
                        class="form-control"
                        value={{ $version->Price }}
                        name="version[{{ $index }}][price]"
                        required
                    />
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVersionRow({{ $index }})" title="Xóa hàng">
                          <i class="fas fa-trash"></i> Xóa
                      </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
          </table>
          <span class="btn btn-dark" onclick="addVersionRow()">
            + Thêm phiên bản
          </span>
        </div>

        <!-- Số lượng trong kho -->
        <div class="mb-3">
          <label class="form-label">Số lượng trong kho</label>
          <input
            type="number"
            class="form-control"
            value="{{ $product->StockQuantity }}"
            name="stockQuantity"
            required
          />
        </div>

        <!-- Bảo hành -->
        <div class="mb-3">
          <label class="form-label">Bảo hành</label>
          <input
            type="text"
            class="form-control"
            value="{{ $product->WarrantyPeriod }}"
            name="warrantyPeriod"
          />
        </div>

        <!-- Video youtube -->
        <div class="mb-3">
          <label class="form-label">Video review sản phẩm (Nếu có):</label>
          <input
            type="text"
            class="form-control"
            value="{{ $product->VideoLink }}"
            name="videoLink"
          />
        </div>

        <!-- Chú thích -->
        <div class="mb-3">
          <label class="form-label">Chú thích sản phẩm</label>
          <input
            type="text"
            class="form-control"
            value="{{ $product->Description }}"
            name="description"
          />
        </div>

        <!-- Bảng thông số kỹ thuật -->
        <div class="mb-3">
          <label class="form-label">Thông số kỹ thuật</label>
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 30%">Tên thông số</th>
                <th>Nội dung</th>
                <th style="width: 20%">Thao tác</th>
              </tr>
            </thead>
            <tbody id="spec-table">
            @foreach ($product->productSpecifications as $index => $spec )
                <tr id="spec-row-{{ $index }}">
                    <td>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $spec->SpecType }}"
                        name="spec[{{ $index }}][key]"
                        required
                    />
                    </td>
                    <td>
                    <textarea
                        type="text"
                        class="form-control"
                        style="white-space: pre-line;"
                        name="spec[{{ $index }}][value]"
                        required
                    >{{ $spec->SpecValue }}</textarea>
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow({{ $index }})" title="Xóa hàng">
                          <i class="fas fa-trash"></i> Xóa
                      </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
          </table>
          <span class="btn btn-dark" onclick="addSpecRow()"
            >+ Thêm thông số</span
          >
        </div>

        <!-- Hiển thị ảnh hiện tại -->
        <div class="mb-3">
          <label class="form-label">Hình ảnh hiện tại</label>
          @if($product->productImgs && $product->productImgs->count() > 0)
              <div class="row g-2 mb-3">
                  @foreach($product->productImgs as $image)
                      <div class="col-3">
                          <div class="card shadow-sm position-relative">
                              <img src="{{  $image->ImgURL }}" 
                                  class="card-img-top img-fluid" 
                                  style="height: 100; width: 100px ;object-fit: cover; border-radius: 5px;">
                              <div class="position-absolute top-0 end-0 p-1">
                                  <input type="checkbox" name="delete_images[]" value="{{ $image->ImgID }}" 
                                        class="form-check-input bg-danger border-danger">
                                  <small class="text-danger">Xóa</small>
                              </div>
                          </div>
                      </div>
                  @endforeach
              </div>
              <small class="text-muted">✓ Tích vào ảnh để xóa</small>
          @else
              <p class="text-muted">Chưa có hình ảnh nào</p>
          @endif
        </div>

        <!-- Upload ảnh mới -->
        <div class="mb-3">
          <label class="form-label">Thêm hình ảnh mới (tùy chọn)</label>
          <input type="file" class="form-control" id="file" name="images[]" multiple accept="image/*" />
          <small class="text-muted">Chọn ảnh mới để thay thế hoặc bổ sung</small>
        </div>
        <div id="preview" class="row g-2"></div>

        <!-- Màu sắc sản phẩm -->
        <div class="mb-3 mt-4">
          <label class="form-label">Màu sắc sản phẩm (Nếu có)</label>
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 30%">Tên màu</th>
                <th>Hình ảnh màu</th>
                <th style="width: 20%">Thao tác</th>
              </tr>
            </thead>
            <tbody id="color-table">
            @foreach ($product->productColors as $index => $color )
                <tr id="color-row-{{ $index }}">
                    <td>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $color->Color }}"
                        name="color[{{ $index }}][name]"
                    />
                    </td>
                    <td class="d-flex">
                    <input
                        type="file"
                        class="form-control w-50"
                        accept="image/*"
                        name="color[{{ $index }}][image]"
                        value="{{ $color->ImgURL }}"
                        onchange="previewColorImage(this, 0)"
                    />

                    {{-- Lưu giá trị ảnh cũ để controller xử lý nếu user không chọn ảnh mới --}}
                    <input
                    type="hidden"
                    name="color[{{ $index }}][old_image]"
                    value="{{ $color->ImgURL }}"
                    />
                    
                    <div id="color-preview-0" class="mt-1 ms-2">
                        <img src="{{ $color->ImgURL }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeColorRow({{ $index }})" title="Xóa hàng">
                          <i class="fas fa-trash"></i> Xóa
                      </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
          </table>
          <span class="btn btn-dark" onclick="addColorRow()">
            + Thêm màu sắc
          </span>
        </div>

        <!-- Nút submit -->
        <div class="text-end mt-3">
          <button type="submit" class="btn btn-danger px-4">
            Sửa sản phẩm
          </button>
        </div>
      </form>

      {{-- Nếu gặp lỗi validation --}}
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      {{-- @if($error)
        <div class="alert alert-danger">
          <ul>
            <li> {{ $error }}</li>
          </ul>
      </div>
      @endif --}}
    </div>
  </div>


  //
  <script>
    // Preview ảnh mới được chọn
    document.getElementById('file').addEventListener('change', function(event) {
        let preview = document.getElementById('preview');
        preview.innerHTML = ''; // clear trước khi chọn lại

        if (event.target.files.length > 0) {
            let label = document.createElement('div');
            label.innerHTML = '<h6 class="mb-3 text-primary">Preview ảnh mới:</h6>';
            preview.appendChild(label);
        }

        Array.from(event.target.files).forEach((file, index) => {
            let reader = new FileReader(); 
            reader.onload = function(e) {
                let col = document.createElement('div');
                col.classList.add('col-3', 'mb-3');
                
                col.innerHTML = `
                    <div class="card shadow-sm image-card">
                        <img src="${e.target.result}" class="card-img-top image-preview">
                        <div class="card-body p-2">
                            <small class="text-muted">${file.name}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });

    // Xử lý checkbox xóa ảnh
    document.addEventListener('DOMContentLoaded', function() {
        const deleteCheckboxes = document.querySelectorAll('input[name="delete_images[]"]');
        
        deleteCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const imageCard = this.closest('.card');
                const img = imageCard.querySelector('img');
                
                if (this.checked) {
                    imageCard.style.opacity = '0.5';
                    img.style.filter = 'grayscale(100%)';
                    imageCard.style.border = '2px solid #dc3545';
                } else {
                    imageCard.style.opacity = '1';
                    img.style.filter = 'none';
                    imageCard.style.border = 'none';
                }
            });
        });
    });

    // Xác nhận trước khi submit form
    document.querySelector('form').addEventListener('submit', function(e) {
        const deletedImages = document.querySelectorAll('input[name="delete_images[]"]:checked');
        if (deletedImages.length > 0) {
            if (!confirm(`Bạn có chắc chắn muốn xóa ${deletedImages.length} hình ảnh được chọn?`)) {
                e.preventDefault();
            }
        }
    });

    // === THÔNG SỐ KỸ THUẬT ===
    let specIndex = 100; // Bắt đầu từ số lớn để tránh conflict
    function addSpecRow() {
        let table = document.getElementById("spec-table");
        let row = document.createElement("tr");
        row.id = `spec-row-${specIndex}`;
        row.innerHTML = `
            <td><input type="text" class="form-control" name="spec[${specIndex}][key]" placeholder="Tên thông số" required></td>
            <td><input type="text" class="form-control" name="spec[${specIndex}][value]" placeholder="Nội dung thông số" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow(${specIndex})" title="Xóa hàng">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </td>
        `;
        table.appendChild(row);
        specIndex++;
    }

    function removeSpecRow(index) {
        if (confirm('Bạn có chắc chắn muốn xóa thông số này?')) {
            animateRowRemoval(`spec-row-${index}`);
            showNotification('Đã xóa thông số kỹ thuật', 'info');
        }
    }

    // === PHIÊN BẢN SẢN PHẨM ===
    let versionIndex = 100; // Bắt đầu từ số lớn để tránh conflict
    function addVersionRow() {
        let table = document.getElementById("version-table");
        let row = document.createElement("tr");
        row.id = `version-row-${versionIndex}`;
        row.innerHTML = `
            <td><input type="text" class="form-control" name="version[${versionIndex}][name]" placeholder="Tên phiên bản" required></td>
            <td><input type="number" class="form-control" name="version[${versionIndex}][price]" placeholder="Giá phiên bản" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVersionRow(${versionIndex})" title="Xóa hàng">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </td>
        `;
        table.appendChild(row);
        versionIndex++;
    }

    function removeVersionRow(index) {
        if (confirm('Bạn có chắc chắn muốn xóa phiên bản này?')) {
            animateRowRemoval(`version-row-${index}`);
            showNotification('Đã xóa phiên bản sản phẩm', 'info');
        }
    }

    // === MÀU SẮC SẢN PHẨM ===
    let colorIndex = 100; // Bắt đầu từ số lớn để tránh conflict
    function addColorRow() {
        let table = document.getElementById("color-table");
        let row = document.createElement("tr");
        row.id = `color-row-${colorIndex}`;
        row.innerHTML = `
            <td><input type="text" class="form-control" name="color[${colorIndex}][name]" placeholder="Tên màu"></td>
            <td class="d-flex align-items-center">
                <input type="file" class="form-control w-50" accept="image/*" name="color[${colorIndex}][image]" onchange="previewColorImage(this, ${colorIndex})">
                <div id="color-preview-${colorIndex}" class="ms-2"></div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeColorRow(${colorIndex})" title="Xóa hàng">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </td>
        `;
        table.appendChild(row);
        colorIndex++;
    }

    function removeColorRow(index) {
        if (confirm('Bạn có chắc chắn muốn xóa màu sắc này?')) {
            animateRowRemoval(`color-row-${index}`);
            showNotification('Đã xóa màu sắc', 'info');
        }
    }

    function previewColorImage(input, index) {
        let preview = document.getElementById('color-preview-' + index);
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                `;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // === UTILITY FUNCTIONS ===
    // Animate khi xóa hàng
    function animateRowRemoval(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.classList.add('row-removing');
            setTimeout(() => {
                row.remove();
            }, 300);
        }
    }


    // Validate form trước khi submit
    function validateForm() {
        const requiredFields = document.querySelectorAll('input[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        return isValid;
    }

    // Thông báo khi thêm/xóa thành công
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    function cancelUpdate(){
      if(confirm("Bạn có chắc muốn hủy cập nhật sản phẩm không?")){
        window.location.href = "/admin";
      }
    }


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
                            brandSelect.appendChild(option);
                        });
                        brandSelect.disabled = false;
                    })
                    .catch(err => console.error(err));
            }
        });
        </script>
  </script>

@endsection

