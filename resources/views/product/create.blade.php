@extends('admin.app')

@section('content')
  <div class="container my-5">
    <div class="rounded shadow border p-5">
      <h3 class="mb-4 text-danger">Thêm sản phẩm mới</h3>
      <form action="{{route('products.store')}}" method="post"  enctype="multipart/form-data">
      @csrf
        <!-- Tên sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Tên sản phẩm</label>
          <input
            type="text"
            class="form-control"
            placeholder="Nhập tên sản phẩm"
            name="name"
            value="{{ old('name') }}"
            required
          />
        </div>

        <!-- Chọn loại sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Loại sản phẩm</label>
          <select id="category" class="form-select" name="category" required>
            <option value="" {{ old('category') == '' ? 'selected' : '' }}>-- Chọn danh mục sản phẩm --</option>
            @foreach ($categories as $category )
            <option value="{{ $category->CategoryID }}" {{ old('category') == $category->CategoryID ? 'selected' : '' }}>{{ $category->CategoryName }}</option>
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
            disabled
            required
          > 
          <option value="">-- Chọn thương hiệu --</option>
        </select>
        </div>

        <!-- Giá -->
        <div class="mb-3">
          <label class="form-label">Giá</label>
          <input
            type="number"
            class="form-control"
            placeholder="Nhập giá sản phẩm"
            name="price"
            value="{{ old('price') }}"
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
              @if(old('version'))
                @foreach(old('version') as $index => $version)
                <tr id="version-row-{{ $index }}">
                  <td>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Ví dụ: 128GB"
                      name="version[{{ $index }}][name]"
                      value="{{ $version['name'] ?? '' }}"
                      required
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      class="form-control"
                      placeholder="Ví dụ: 15000000"
                      name="version[{{ $index }}][price]"
                      value="{{ $version['price'] ?? '' }}"
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
              @else
              <tr id="version-row-0">
                <td>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: 128GB"
                    name="version[0][name]"
                    required
                  />
                </td>
                <td>
                  <input
                    type="number"
                    class="form-control"
                    placeholder="Ví dụ: 15000000"
                    name="version[0][price]"
                    required
                  />
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVersionRow(0)" title="Xóa hàng">
                      <i class="fas fa-trash"></i> Xóa
                  </button>
                </td>
              </tr>
              @endif
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
            placeholder="Nhập số lượng"
            name="stockQuantity"
            value="{{ old('stockQuantity') }}"
            required
          />
        </div>

        <!-- Bảo hành -->
        <div class="mb-3">
          <label class="form-label">Bảo hành</label>
          <input
            type="text"
            class="form-control"
            placeholder="Ví dụ: 12 tháng"
            name="warrantyPeriod"
            value="{{ old('warrantyPeriod') }}"
          />
        </div>

        <!-- Video youtube -->
        <div class="mb-3">
          <label class="form-label">Video review sản phẩm (Nếu có):</label>
          <input
            type="text"
            class="form-control"
            name="videoLink"
            value="{{ old('videoLink') }}"
          />
        </div>

        <!-- Chú thích -->
        <div class="mb-3">
          <label class="form-label">Chú thích sản phẩm</label>
          <input
            type="text"
            class="form-control"
            placeholder=""
            name="description"
            value="{{ old('description') }}"
          />
        </div>

        <!-- Bảng thông số kỹ thuật -->
        <div class="mb-3">
          <label class="form-label">Thông số kỹ thuật</label>
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 40%">Tên thông số</th>
                <th>Nội dung</th>
              </tr>
            </thead>
            <tbody id="spec-table">
              @if(old('spec'))
                @foreach(old('spec') as $index => $spec)
                <tr id="spec-row-{{ $index }}">
                  <td>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Ví dụ: Màn hình"
                      name="spec[{{ $index }}][key]"
                      value="{{ $spec['key'] ?? '' }}"
                      required
                    />
                  </td>
                  <td>
                    <textarea
                      type="text"
                      class="form-control"
                      placeholder="Ví dụ: OLED, 6.1 inch"
                      name="spec[{{ $index }}][value]"
                      required
                    >{{ $spec['value'] ?? '' }}</textarea>
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow({{ $index }})" title="Xóa hàng">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                  </td>
                </tr>
                @endforeach
              @else
              <tr id="spec-row-0">
                <td>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: Màn hình"
                    name="spec[0][key]"
                    required
                  />
                </td>
                <td>
                  <textarea
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: OLED, 6.1 inch"
                    name="spec[0][value]"
                    required
                  ></textarea>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow(0)" title="Xóa hàng">
                      <i class="fas fa-trash"></i> Xóa
                  </button>
                </td>
              </tr>
              <tr id="spec-row-1">
                <td>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: Camera"
                    name="spec[1][key]"
                    required
                  />
                </td>
                <td>
                  <textarea
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: 48MP"
                    name="spec[1][value]"
                    required
                  ></textarea>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow(1)" title="Xóa hàng">
                      <i class="fas fa-trash"></i> Xóa
                  </button>
                </td>
              </tr>
              <tr id="spec-row-2">
                <td>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: Pin"
                    name="spec[2][key]"
                    required
                  />
                </td>
                <td>
                  <textarea
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: 3279 mAh"
                    name="spec[2][value]"
                    required
                  ></textarea>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow(2)" title="Xóa hàng">
                      <i class="fas fa-trash"></i> Xóa
                  </button>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
          <span class="btn btn-dark" onclick="addSpecRow()"
            >+ Thêm thông số</span
          >
        </div>

        <!-- Gán nhiều ảnh -->
        <div class="mb-3">
          <label class="form-label">Hình ảnh sản phẩm</label>
          <input type="file" class="form-control" id="file" name="images[]" multiple accept="image/*" required  />
        </div>

        <div id="preview" class="row g-2"></div>

        <!-- Màu sắc sản phẩm -->
        <div class="mb-3 mt-4">
          <label class="form-label">Màu sắc sản phẩm (Nếu có)</label>
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 40%">Tên màu</th>
                <th>Hình ảnh màu</th>
              </tr>
            </thead>
            <tbody id="color-table">
              @if(old('color'))
                @foreach(old('color') as $index => $color)
                <tr id="color-row-{{ $index }}">
                  <td>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Ví dụ: Đen"
                      name="color[{{ $index }}][name]"
                      value="{{ $color['name'] ?? '' }}"
                    />
                  </td>
                  <td class="d-flex">
                    <input
                      type="file"
                      class="form-control w-50"
                      accept="image/*"
                      name="color[{{ $index }}][image]"
                      onchange="previewColorImage(this, {{ $index }})"
                    />
                    <div id="color-preview-{{ $index }}" class="mt-1 ms-2"></div>
                  </td>

                  {{-- Lưu giá trị ảnh cũ để controller xử lý nếu user không chọn ảnh mới --}}
                  <input
                  type="hidden"
                  name="color[{{ $index }}][image]"
                  value="{{ $color['image'] }}"
                  />

                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeColorRow({{ $index }})" title="Xóa hàng">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                  </td>
                </tr>
                @endforeach
              @else
              <tr id="color-version-0">
                <td>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Ví dụ: Đen"
                    name="color[0][name]"
                  />
                </td>
                <td class="d-flex">
                  <input
                    type="file"
                    class="form-control w-50"
                    accept="image/*"
                    name="color[0][image]"
                    onchange="previewColorImage(this, 0)"
                  />
                  <div id="color-preview-0" class="mt-1 ms-2"></div>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeColorRow(0)" title="Xóa hàng">
                      <i class="fas fa-trash"></i> Xóa
                  </button>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
          <span class="btn btn-dark" onclick="addColorRow()">
            + Thêm màu sắc
          </span>
        </div>

        <!-- Nút submit -->
        <div class="text-end mt-3">
          <button type="submit" class="btn btn-danger px-4">
            Lưu sản phẩm
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
    </div>
  </div>


  {{-- JS --}}
  <script>
        document.getElementById('file').addEventListener('change', function (event) {
          selectedFiles = [...selectedFiles]
        })

        document.getElementById('file').addEventListener('change', function(event) {
            let preview = document.getElementById('preview');
            preview.innerHTML = ''; // clear trước khi chọn lại
        
            Array.from(event.target.files).forEach(file => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let col = document.createElement('div');
                    col.classList.add('col-3'); // hiển thị 4 ảnh 1 hàng (12/3 = 4)
                    
                    col.innerHTML = `
                        <div class="card shadow-sm">
                            <img src="${e.target.result}" class="card-img-top img-fluid" style="height: 100px, width:100px; object-fit: cover; border-radius: 5px;">
                        </div>
                    `;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });

        // === THÔNG SỐ KỸ THUẬT ===
        // Hàm thêm row vào thông số kỹ thuật
        let specIndex = {{ old('spec') ? count(old('spec')) : 100 }};
        function addSpecRow() {
            let table = document.getElementById("spec-table");
            let row = document.createElement("tr");
            row.innerHTML = `
              <td><input type="text" class="form-control" name="spec[${specIndex}][key]" placeholder="Tên thông số"></td>
              <td><textarea type="text" class="form-control" name="spec[${specIndex}][value]" placeholder="Nội dung thông số"></textarea></td>
              <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSpecRow(${specIndex})" title="Xóa hàng">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
              </td>
            `;
            table.appendChild(row);
            specIndex++;
        }
        // hàm xóa row thông số kỹ thuật
        function removeSpecRow(index) {
            if (confirm('Bạn có chắc chắn muốn xóa thông số này?')) {
                animateRowRemoval(`spec-row-${index}`);
                showNotification('Đã xóa thông số kỹ thuật', 'info');
            }
        }


        // PHIÊN BẢN SẢN PHẨM
        // Hàm thêm row vào phiên bản sản phẩm
        let versionIndex = {{ old('version') ? count(old('version')) : 100 }};
        function addVersionRow() {
            let table = document.getElementById("version-table");
            let row = document.createElement("tr");
            row.innerHTML = `
              <td><input type="text" class="form-control" name="version[${versionIndex}][name]" placeholder="Tên phiên bản"></td>
              <td><input type="number" class="form-control" name="version[${versionIndex}][price]" placeholder="Giá phiên bản"></td>
              <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVersionRow(${versionIndex})" title="Xóa hàng">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </td>
            `;
            table.appendChild(row);
            versionIndex++;
        }
        // Hàm xóa dòng phiên bản sản phẩm
        function removeVersionRow(index) {
          if (confirm('Bạn có chắc chắn muốn xóa phiên bản này?')) {
              animateRowRemoval(`version-row-${index}`);
              showNotification('Đã xóa phiên bản sản phẩm', 'info');
          }
        }


        // MÀU SẮC SẢN PHẨM
        // Hàm thêm row vào màu sắc sản phẩm
        let colorIndex = {{ old('color') ? count(old('color')) : 100 }};
        function addColorRow() {
            let table = document.getElementById("color-table");
            let row = document.createElement("tr");
            row.innerHTML = `
              <td><input type="text" class="form-control" name="color[${colorIndex}][name]" placeholder="Tên màu"></td>
              <td class="d-flex">
                <input type="file" class="form-control w-50" accept="image/*" name="color[${colorIndex}][image]" onchange="previewColorImage(this, ${colorIndex})">
                <div id="color-preview-${colorIndex}" class="mt-1 ms-1"></div>
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
        // Hàm xóa dòng màu sắc sản phẩm
        function removeColorRow(index) {
          if (confirm('Bạn có chắc chắn muốn xóa màu sắc này?')) {
              animateRowRemoval(`color-row-${index}`);
              showNotification('Đã xóa màu sắc', 'info');
          }
        }

        // Hàm preview ảnh cho màu sắc
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

        // Tự động load brands nếu có category được chọn từ old input
        @if(old('category'))
            document.addEventListener('DOMContentLoaded', function() {
                let categorySelect = document.getElementById('category');
                let categoryId = categorySelect.value;
                
                if(categoryId) {
                    let brandSelect = document.getElementById('brand');
                    brandSelect.innerHTML = '<option value="">-- Chọn thương hiệu --</option>';
                    
                    fetch(`/admin/brands-by-category/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(brand => {
                                let option = document.createElement('option');
                                option.value = brand.BrandID;
                                option.textContent = brand.BrandName;
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
        @endif
        </script>
@endsection